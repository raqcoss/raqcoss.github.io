﻿<?php

// Replace this with your own email address
$siteOwnersEmail = 'rakecoss@hotmail.com';


if($_POST) {

    $error = array(); // Initialize error array
    $message = "";    // Initialize message variable

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }
    // Check Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please enter a valid email address.";
    }
    // Check Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }
    // Subject
    if ($subject == '') { $subject = "Contact Form Submission"; }


    // Set Message
    $message .= "Email from: " . htmlspecialchars($name) . "<br />";
    $message .= "Email address: " . htmlspecialchars($email) . "<br />";
    $message .= "Message: <br />";
    $message .= nl2br(htmlspecialchars($contact_message));
    $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

    // Set From: header (sanitize to prevent header injection)
    $from = htmlspecialchars($name) . " <" . htmlspecialchars($email) . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . htmlspecialchars($email) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


    if (empty($error)) {

        ini_set("sendmail_from", $siteOwnersEmail); // for windows server
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) { echo "OK"; }
        else { echo "Something went wrong. Please try again."; }
        
    } # end if - no validation error

    else {

        $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
        
        echo $response;

    } # end if - there was a validation error

}

?>