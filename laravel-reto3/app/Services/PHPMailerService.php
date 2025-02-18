<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    public function sendEmail(string $to, string $subject, string $body, string $altBody = null)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;  // Enable verbose debug output (use DEBUG_SERVER for testing)
            $mail->isSMTP();                                      // Send using SMTP
            $mail->Host       = config('mail.mailers.smtp.host');  // Set the SMTP server to send through (from config/mail.php)
            $mail->SMTPAuth   = true;                               // Enable SMTP authentication
            $mail->Username   = config('mail.mailers.smtp.username'); // SMTP username (from config/mail.php)
            $mail->Password   = config('mail.mailers.smtp.password'); // SMTP password (from config/mail.php)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = config('mail.mailers.smtp.port');   // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS`

            //Recipients
            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($to);     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = $altBody ?? strip_tags($body);  // Optional: Plain text version

            $mail->send();
            return true; // Success
        } catch (Exception $e) {
            \Log::error("PHPMailer Error: {$mail->ErrorInfo}"); // Log the error
            return false; // Failure
        }
    }
}