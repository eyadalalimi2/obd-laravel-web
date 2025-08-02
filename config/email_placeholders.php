<?php
// config/email_placeholders.php

return [

    // المفتاح => قائمة المتغيرات
    'welcome_email'         => ['user_name','login_url'],
    'account_activation'    => ['user_name','activation_link'],
    'password_reset'        => ['user_name','reset_link'],
    'order_confirmation'    => ['user_name','order_id','order_total','tracking_url'],
    'shipping_notification' => ['user_name','order_id','tracking_number','tracking_url'],
    'invoice_email'         => ['user_name','order_id','invoice_url'],
    'account_activity_alert'=> ['user_name','support_url'],
    'weekly_newsletter'     => ['user_name','items'],
    'promo_offer'           => ['user_name','upgrade_url'],
    'product_onboarding'    => ['user_name'],

];
