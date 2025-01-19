<?php

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/upload-and-set-featured-image', array(
        'methods' => 'POST',
        'callback' => 'upload_and_set_featured_image',
        'permission_callback' => function () {
            return current_user_can('edit_posts'); // permission Users
        },
    ));
});

//get the files
function upload_and_set_featured_image(WP_REST_Request $request) {
    $uploaded_files = $request->get_file_params(); 

    
    if (empty($uploaded_files)) {
        return new WP_Error('missing_files', 'هیچ فایلی ارسال نشده است.', array('status' => 400));
    }

    $results = array();

    foreach ($uploaded_files as $file_key => $file) {
        
        $upload = wp_handle_upload($file, array('test_form' => false));
        if (isset($upload['error'])) {
            $results[] = array(
                'success' => false,
                'error' => $upload['error'],
                'file_name' => $file['name']
            );
            continue;
        }

        $filename = $upload['file'];
        $file_url = $upload['url'];

        
        preg_match('/#(\d+)/', $file['name'], $matches);
        if (!isset($matches[1])) {
            $results[] = array(
                'success' => false,
                'error' => 'شناسه محصول در نام فایل یافت نشد.',
                'file_name' => $file['name']
            );
            continue;
        }

        $product_id = intval($matches[1]);

       
        $attachment_id = wp_insert_attachment(array(
            'guid' => $file_url,
            'post_mime_type' => mime_content_type($filename),
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => '',
            'post_status' => 'inherit'
        ), $filename);

        if (is_wp_error($attachment_id)) {
            $results[] = array(
                'success' => false,
                'error' => 'خطا در ثبت فایل در کتابخانه رسانه.',
                'file_name' => $file['name']
            );
            continue;
        }

        
        $attachment_data = wp_generate_attachment_metadata($attachment_id, $filename);
        wp_update_attachment_metadata($attachment_id, $attachment_data);

     
        set_post_thumbnail($product_id, $attachment_id);

        $results[] = array(
            'success' => true,
            'product_id' => $product_id,
            'file_name' => $file['name'],
            'image_url' => $file_url
        );
    }

    return rest_ensure_response($results);
}
