<?php
// Encore Brands - Configuration File
// Updated to use With Your Shield mail system

// Email Configuration using array structure like With Your Shield
$config = [
    // Email settings
    'to_email' => 'amerlocfr@gmail.com',  // Primary contact email
    'to_email_secondary' => 'doshevlin@encorebrands.com',  // Secondary contact email
    'from_email' => 'noreply@encorebrands.com',  // Change this to your domain email
    
    // Using PHP's built-in mail() function
    
    // Form settings
    'max_message_length' => 2000,
    'allowed_subjects' => [
        'General Inquiry',
        'Product Information', 
        'Wholesale Inquiry',
        'Partnership',
        'Media Inquiry',
        'Other'
    ],
    
    // Security settings
    'rate_limit' => 5,  // Max submissions per hour per IP
    'honeypot_field' => 'website',  // Hidden field name for spam protection
    
    // Notification settings
    'send_notifications' => true,
    'notification_email' => 'admin@encorebrands.com',  // Admin notification email
];

// Rate limiting function (from With Your Shield)
function checkRateLimit($ip) {
    global $config;
    $rate_limit_file = 'rate_limit.json';
    
    if (!file_exists($rate_limit_file)) {
        file_put_contents($rate_limit_file, '{}');
    }
    
    $rate_data = json_decode(file_get_contents($rate_limit_file), true);
    $current_time = time();
    $hour_ago = $current_time - 3600;
    
    // Clean old entries
    foreach ($rate_data as $ip_addr => $times) {
        $rate_data[$ip_addr] = array_filter($times, function($time) use ($hour_ago) {
            return $time > $hour_ago;
        });
        if (empty($rate_data[$ip_addr])) {
            unset($rate_data[$ip_addr]);
        }
    }
    
    // Check current IP
    if (!isset($rate_data[$ip])) {
        $rate_data[$ip] = [];
    }
    
    if (count($rate_data[$ip]) >= $config['rate_limit']) {
        return false;
    }
    
    // Add current submission
    $rate_data[$ip][] = $current_time;
    file_put_contents($rate_limit_file, json_encode($rate_data));
    
    return true;
}

// Honeypot validation (from With Your Shield)
function validateHoneypot() {
    global $config;
    $honeypot_field = $config['honeypot_field'];
    
    if (isset($_POST[$honeypot_field]) && !empty($_POST[$honeypot_field])) {
        return false; // Bot detected
    }
    
    return true;
}
?>
