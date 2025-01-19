

این API یک اندپوینت سفارشی REST در وردپرس ارائه می‌دهد که کاربران می‌توانند از طریق متد POST فایل‌هایی را آپلود کنند و به صورت خودکار تصویر شاخص (Featured Image) یک محصول خاص را تنظیم کنند. این API مناسب برای مدیریت محصولات یا پست‌ها در وردپرس است، مخصوصاً اگر بخواهید تصاویر شاخص را از طریق برنامه‌های خارجی (مانند سیستم‌های مدیریت محتوا یا نرم‌افزارهای دیگر) به‌روزرسانی کنید.
نحوه عملکرد:

    مجوز دسترسی: تنها کاربرانی که توانایی ویرایش پست‌ها (مثل مدیران یا نویسندگان) دارند، می‌توانند از این اندپوینت استفاده کنند.
    آپلود فایل: فایل‌های آپلود شده بررسی می‌شوند و به کمک تابع wp_handle_upload در کتابخانه رسانه وردپرس ذخیره می‌شوند.
    استخراج شناسه محصول: این API فرض می‌کند شناسه محصول باید در نام فایل وجود داشته باشد (به شکل #123). اگر شناسه پیدا نشود، فایل پردازش نمی‌شود.
    تنظیم تصویر شاخص: پس از آپلود موفقیت‌آمیز، تصویر به عنوان تصویر شاخص محصول مشخص‌شده ثبت می‌شود.
    پاسخ API: پاسخ API شامل جزئیات وضعیت آپلود هر فایل است، مانند موفقیت یا شکست و URL تصویر آپلود شده.



This API provides a custom REST endpoint in WordPress that allows users to upload files via the POST method and automatically set the uploaded files as the featured image of specific products. It is ideal for managing products or posts in WordPress, especially when you need to update featured images via external applications or systems.
How it Works:

    Permission Check: Only users with the ability to edit posts (e.g., admins or editors) can use this endpoint.
    File Upload: Uploaded files are validated and stored in the WordPress media library using the wp_handle_upload function.
    Extract Product ID: The API assumes that the product ID is included in the filename (e.g., #123). If no ID is found, the file is skipped.
    Set Featured Image: After a successful upload, the image is set as the featured image for the specified product.
    API Response: The API returns a detailed response for each file, including success or failure status and the URL of the uploaded image.

نمونه استفاده از API:

    اندپوینت: http://yourwebsite.com/wp-json/custom/v1/upload-and-set-featured-image
    متد: POST
    پارامترها:
        فایل‌ها (Files) شامل تصاویر با نام حاوی شناسه محصول (مانند #123_image.jpg).
        Sample Usage of the API:

    Endpoint: http://yourwebsite.com/wp-json/custom/v1/upload-and-set-featured-image
    Method: POST
    Parameters:
        Files: Include images with filenames containing the product ID (e.g., #123_image.jpg).
