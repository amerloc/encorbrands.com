<?php
// Test script for Encore Brands mail system
// This script tests the updated mail system to ensure it works correctly

require_once 'config.php';

echo "<h2>Encore Brands Mail System Test</h2>";

// Test 1: Check if config is loaded correctly
echo "<h3>1. Configuration Test</h3>";
if (isset($config) && is_array($config)) {
    echo "✅ Config loaded successfully<br>";
    echo "Primary email: " . $config['to_email'] . "<br>";
    echo "Secondary email: " . $config['to_email_secondary'] . "<br>";
    echo "From email: " . $config['from_email'] . "<br>";
} else {
    echo "❌ Config not loaded properly<br>";
}

// Test 2: Check rate limiting function
echo "<h3>2. Rate Limiting Test</h3>";
$test_ip = '127.0.0.1';
if (function_exists('checkRateLimit')) {
    $rate_limit_result = checkRateLimit($test_ip);
    echo "Rate limiting function exists: ✅<br>";
    echo "Rate limit check result: " . ($rate_limit_result ? 'Allowed' : 'Blocked') . "<br>";
} else {
    echo "❌ Rate limiting function not found<br>";
}

// Test 3: Check honeypot function
echo "<h3>3. Honeypot Test</h3>";
if (function_exists('validateHoneypot')) {
    echo "Honeypot function exists: ✅<br>";
    // Simulate clean POST data (no honeypot filled)
    $_POST = [];
    $honeypot_result = validateHoneypot();
    echo "Honeypot validation result: " . ($honeypot_result ? 'Clean' : 'Bot detected') . "<br>";
} else {
    echo "❌ Honeypot function not found<br>";
}

// Test 4: Test email sending (if mail function is available)
echo "<h3>4. Email Function Test</h3>";
if (function_exists('mail')) {
    echo "PHP mail() function available: ✅<br>";
    
    // Test email content
    $test_subject = "Encore Brands Test Email - " . date('Y-m-d H:i:s');
    $test_body = "This is a test email from the Encore Brands mail system.\n\n";
    $test_body .= "Test completed at: " . date('Y-m-d H:i:s') . "\n";
    $test_body .= "Server: " . $_SERVER['HTTP_HOST'] . "\n";
    
    $test_headers = [
        'From: ' . $config['from_email'],
        'Reply-To: ' . $config['from_email'],
        'X-Mailer: PHP/' . phpversion(),
        'Content-Type: text/plain; charset=UTF-8'
    ];
    
    // Send test email
    $test_recipients = $config['to_email'] . ', ' . $config['to_email_secondary'];
    $mail_result = mail($test_recipients, $test_subject, $test_body, implode("\r\n", $test_headers));
    
    if ($mail_result) {
        echo "✅ Test email sent successfully to: $test_recipients<br>";
        echo "📧 Check your email inbox and spam folder<br>";
    } else {
        echo "❌ Test email failed to send<br>";
        echo "This might indicate a server configuration issue<br>";
    }
} else {
    echo "❌ PHP mail() function not available<br>";
    echo "Contact your hosting provider to enable mail functionality<br>";
}

// Test 5: Check file permissions
echo "<h3>5. File Permissions Test</h3>";
$log_file = 'contact_log.txt';
$rate_limit_file = 'rate_limit.json';

if (is_writable('.')) {
    echo "✅ Current directory is writable<br>";
} else {
    echo "❌ Current directory is not writable<br>";
}

// Test 6: Summary
echo "<h3>6. Test Summary</h3>";
echo "The Encore Brands mail system has been updated to use the same structure as With Your Shield.<br>";
echo "Key features implemented:<br>";
echo "• Simple config array structure<br>";
echo "• Rate limiting protection<br>";
echo "• Honeypot spam protection<br>";
echo "• Multiple recipient support<br>";
echo "• Simple text email format<br>";
echo "• Logging functionality<br>";

echo "<br><strong>Next steps:</strong><br>";
echo "1. Test the contact form on your website<br>";
echo "2. Check that emails are being received<br>";
echo "3. Verify rate limiting is working<br>";
echo "4. Remove this test file after testing<br>";

?>
