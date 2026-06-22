<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname   = $_POST['fullname'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $position   = $_POST['position'];
    $experience = $_POST['experience'];
    $message    = $_POST['message'];

    $to = "arathi@signroots.com"; // Change to your HR email
    $subject = "New Job Application - " . $fullname;

    $body = "
    New Job Application Received

    Full Name: $fullname
    Email: $email
    Phone: $phone
    Position: $position
    Experience: $experience Years

    Message:
    $message
    ";

    $headers = "From: $email";

    if(mail($to, $subject, $body, $headers)){
        echo "<script>
                alert('Application submitted successfully.');
                window.location.href='careers.html';
              </script>";
    } else {
        echo "<script>
                alert('Failed to send application.');
                window.history.back();
              </script>";
    }
}
?>