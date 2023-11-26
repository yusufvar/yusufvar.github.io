<?php
session_start();

// Security check: Only allow access if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    die('Access denied.');
}

// Security check: Validate CSRF token
$expected_token = 'your_secret_key';

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $expected_token) {
    die('Access denied.');
}

// Include the "PHP Email Form" library
$php_email_form_path = '../assets/vendor/php-email-form/php-email-form.php';
if (file_exists($php_email_form_path)) {
    include($php_email_form_path);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

// Create a PHP_Email_Form instance
$contact = new PHP_Email_Form;
$contact->ajax = true;

// Replace 'your_email@example.com' with your real receiving email address
$receiving_email_address = 'your_email@example.com';

$contact->to = $receiving_email_address;
$contact->from_name = $_POST['name'];
$contact->from_email = $_POST['email'];
$contact->subject = $_POST['subject'];

// Uncomment below code if you want to use SMTP to send emails
/*
$contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
);
*/

// Add form data to the email message
$contact->add_message($_POST['name'], 'From');
$contact->add_message($_POST['email'], 'Email');
$contact->add_message($_POST['message'], 'Message', 10);

// Generate and store a new CSRF token for the next form submission
$new_csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $new_csrf_token;

// Set the CSRF token in the response for AJAX verification
echo json_encode(array('csrf_token' => $new_csrf_token, 'status' => $contact->send()));
