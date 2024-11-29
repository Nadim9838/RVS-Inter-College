<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $phone = htmlspecialchars($_POST['phone']);

    // Email details
    $to = "rvsintercollege@gmail.com";
    $subject = "New message from your website by " . $name;
    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n\n";
    $body .= "Message:\n$message\n";

    // Set email headers
    $headers = "From: $email\n";
    $headers .= "Reply-To: $email";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo "
        <script> alert('Email sent successfully.');
        window.location.replace('https://rvs-inter-college.in/');
        </script>";
    } else {
        echo "
        <script> alert('Failed to send email.');
        window.location.replace('https://rvs-inter-college.in/');
        </script>";
    }
}
?>
