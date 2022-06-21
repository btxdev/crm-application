<?php

/**
 * This example shows how to send via Google's Gmail servers using XOAUTH2 authentication.
 */

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
//Alias the League Google OAuth2 provider class
use League\OAuth2\Client\Provider\Google;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Asia/Tashkent');

//Load dependencies from composer
//If this causes an error, run 'composer install'
require 'vendor/autoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption mechanism to use - STARTTLS or SMTPS
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Set AuthType to use XOAUTH2
$mail->AuthType = 'XOAUTH2';

//Fill in authentication details here
//Either the gmail account owner, or the user that gave consent
$email = 'shop.crm123@gmail.com';
$clientId = '984963150318-mm6vtujvu743m6vr1b56iisnav0jb0ub.apps.googleusercontent.com';
$clientSecret = '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';

//Obtained by configuring and running get_oauth_token.php
//after setting up an app in Google Developer Console.
$refreshToken = '1//0cEaz6BtuULVPCgYIARAAGAwSNwF-L9Irzq92ZtlB1s3JpDhoQIkbapQOsRWiNgB-up4tEMfyXiSKoJiFV2iaJz65G4nMXIeFrS0';

//Create a new OAuth2 provider instance
$provider = new Google(
    [
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]
);

//Pass the OAuth provider instance to PHPMailer
$mail->setOAuth(
    new OAuth(
        [
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $email,
        ]
    )
);

//Set who the message is to be sent from
//For gmail, this generally needs to be the same as the user you logged in as
$mail->setFrom($email, 'Sender Name');

//Set who the message is to be sent to
$mail->addAddress('limecompro@gmail.com');

// if you want to send email to multiple users, then add the email addresses you which you want to send.
//$mail->addAddress('reciver2@gmail.com');
//$mail->addAddress('reciver3@gmail.com');

$mail->isHTML(true);

//Set the subject line
$mail->Subject = 'PHPMailer GMail XOAUTH2 SMTP test';

$mail->Body    = 'This is the HTML message body <b>in bold!</b>';

//Replace the plain text body with one created manually
// $mail->AltBody = 'This is a plain-text message body';

//For Attachments
//$mail->addAttachment('/var/tmp/file.tar.gz');  // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // You can specify the file name

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}

?>