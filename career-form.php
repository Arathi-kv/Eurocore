<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname   = $_POST['fullname'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $position   = $_POST['position'];
    $experience = $_POST['experience'];
    $message    = $_POST['message'];

    // Resume Upload
    $resumePath = "";

    if(isset($_FILES['resume']) && $_FILES['resume']['error'] == 0){

        $uploadDir = "uploads/";

        if(!file_exists($uploadDir)){
            mkdir($uploadDir, 0755, true);
        }

        $resumeName = time() . "_" . basename($_FILES["resume"]["name"]);
        $resumePath = $uploadDir . $resumeName;

        move_uploaded_file($_FILES["resume"]["tmp_name"], $resumePath);
    }

    $to = "arathi@signroots.com";
    $subject = "New Job Application - " . $fullname;

    $body = "
New Job Application Received

Full Name: $fullname
Email: $email
Phone: $phone
Position Applied: $position
Experience: $experience Years

Resume:
$resumePath

Message:
$message
";

    $headers = "From: noreply@yourdomain.com\r\n";
    $headers .= "Reply-To: $email\r\n";

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