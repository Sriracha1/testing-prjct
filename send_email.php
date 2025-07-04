<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['guestName'];
    $guests = $_POST['guestCount'];
    $attending = $_POST['attendance'];

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your_sender@gmail.com';
        $mail->Password = 'your_16_digit_app_password'; // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your_sender@gmail.com', 'Wedding RSVP');
        $mail->addAddress('your_receiver@gmail.com');

        // Content
        $mail->Subject = 'RSVP Submission';
        $mail->Body    = "Name: $name\nGuests: $guests\nAttending: $attending";

        $mail->send();
        echo "Message sent!";
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
