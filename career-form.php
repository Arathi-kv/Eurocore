<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Google reCAPTCHA Verification
    $secretKey = "YOUR_SECRET_KEY";

    if (empty($_POST['g-recaptcha-response'])) {
        die("Please verify the CAPTCHA.");
    }

    $captcha = $_POST['g-recaptcha-response'];

    $verifyResponse = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret="
        . $secretKey .
        "&response=" . $captcha
    );

    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        die("CAPTCHA verification failed.");
    }

    $fullname   = htmlspecialchars($_POST['fullname']);
    $email      = htmlspecialchars($_POST['email']);
    $phone      = htmlspecialchars($_POST['phone']);
    $position   = htmlspecialchars($_POST['position']);
    $experience = htmlspecialchars($_POST['experience']);
    $message    = htmlspecialchars($_POST['message']);

    
    // Resume Upload
    $resumeName = "";

    if(isset($_FILES['resume']) && $_FILES['resume']['error'] == 0){

        // File size check 5MB
        if($_FILES['resume']['size'] > 5 * 1024 * 1024){
            die("Resume size must be less than 5MB");
        }

        $allowedTypes = [
            "application/pdf",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
        ];

        if(!in_array($_FILES['resume']['type'], $allowedTypes)){
            die("Invalid resume format");
        }


        $uploadDir = __DIR__ . "/uploads/";

        if(!file_exists($uploadDir)){
            mkdir($uploadDir, 0755, true);
        }


        $resumeName = time() . "_" . basename($_FILES["resume"]["name"]);

        $resumePath = $uploadDir . $resumeName;


        move_uploaded_file(
            $_FILES["resume"]["tmp_name"],
            $resumePath
        );
    }


    $to = "arathi@signroots.com";  // Your email id

    $subject = "New Job Application - " . $fullname;


            $body = "
        New Job Application Received

        Full Name: $fullname
        Email: $email
        Phone: $phone
        Position Applied: $position
        Experience: $experience Years

        Resume:
        $resumeName

        Message:
        $message
        ";


    $headers = "From: noreply@yourdomain.com\r\n"; //add your domain
    $headers .= "Reply-To: $email\r\n";


    if(mail($to, $subject, $body, $headers)){

        echo "
        <script>
        alert('Application submitted successfully.');
        window.location.href='careers.html';
        </script>";

    } else {

        echo "
        <script>
        alert('Failed to send application.');
        window.history.back();
        </script>";
    }

}

?>