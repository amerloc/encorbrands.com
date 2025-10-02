<?php
// Encore Brands - Contact Form Handler
// Updated to use With Your Shield mail system

// Include configuration
require_once 'config.php';

// Set content type for JSON response
header('Content-Type: application/json');

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get form data and sanitize
$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$company = trim($_POST['company'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validate required fields
$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required';
}

if (empty($phone)) {
    $errors[] = 'Phone is required';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email is required';
}

if (empty($company)) {
    $errors[] = 'Company is required';
}

if (empty($message)) {
    $errors[] = 'Message is required';
}

// If there are validation errors, return them
if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => 'Validation errors', 'errors' => $errors]);
    exit;
}

// Check rate limiting
$client_ip = $_SERVER['REMOTE_ADDR'];
if (!checkRateLimit($client_ip)) {
    echo json_encode([
        'success' => false, 
        'message' => 'Too many submissions. Please wait before submitting again.'
    ]);
    exit;
}

// Check honeypot (spam protection)
if (!validateHoneypot()) {
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid submission detected.'
    ]);
    exit;
}

// Prepare email content
$email_subject = "Encore Brands Contact Form - " . $name;
$email_body = "
New contact form submission from Encore Brands website:

Name: {$name}
Email: {$email}
Phone: " . ($phone ?: 'Not provided') . "
Company: " . ($company ?: 'Not provided') . "

Message:
{$message}

---
This message was sent from the contact form on encorebrands.com
IP Address: " . $_SERVER['REMOTE_ADDR'] . "
Timestamp: " . date('Y-m-d H:i:s') . "
";

// Set email headers
$headers = [
    'From: ' . $config['from_email'],
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/plain; charset=UTF-8'
];

// Send email to both addresses
$recipients = $config['to_email'] . ', ' . $config['to_email_secondary'];
$mail_sent = mail(
    $recipients,
    $email_subject,
    $email_body,
    implode("\r\n", $headers)
);

if ($mail_sent) {
    // Log successful submission (optional)
    $log_entry = date('Y-m-d H:i:s') . " - Contact form submitted by: {$name} ({$email})\n";
    file_put_contents('contact_log.txt', $log_entry, FILE_APPEND | LOCK_EX);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Thank you for your message! We will get back to you soon.'
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Sorry, there was an error sending your message. Please try again or contact us directly.'
    ]);
}
?>
