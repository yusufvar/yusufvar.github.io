<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Replace with your email address
    $to = 'amiry3398@gmail.com';

    // Email headers
    $headers = "From: $name <$email>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";

    // Email body
    $body = "<p><strong>Name:</strong> $name</p>";
    $body .= "<p><strong>Email:</strong> $email</p>";
    $body .= "<p><strong>Subject:</strong> $subject</p>";
    $body .= "<p><strong>Message:</strong> $message</p>";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo 'Email sent successfully.';
    } else {
        echo 'Error sending email.';
    }
} else {
    // Redirect to the form if accessed directly
    header('Location: index.html');
    exit();
}
?>
