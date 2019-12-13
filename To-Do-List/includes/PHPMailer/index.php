<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 1;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.sendgrid.net';                                  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'simon7';                              // SMTP username
    $mail->Password = 'bkJetp.8773';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;
    $mail->AddEmbeddedImage("images/success.jpg", 1001, 'success.jpg');                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('simon_h@gmx.ch', 'Simon');

    $mail->addAddress('Luca.Calderone@cognizant.com', 'Joe User');     // Add a recipient

    
    $body = '<p><strong>Hello</strong>This is my first email with PHPMAILER</p>';


    //Content
    $mail->isHTML(true); 
    $body = '<img src="cid:1001">';                                 // Set email format to HTML
    $mail->Subject = 'This is a test email';

    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}