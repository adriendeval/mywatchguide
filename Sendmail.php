<?php

/**
 * MyWatchGuide - Sendmail
 * 
 * @package Adrien\Mywatchguide
 * @author Adrien 
 * @license MIT
 */

namespace Adrien\Mywatchguide;

class Sendmail
{
    private $mail;
    private $log;

    public function __construct($log)
    {
        $this->log = $log;
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = $_ENV['SMTP_HOST'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['SMTP_USERNAME'];
        $this->mail->Password = $_ENV['SMTP_PASSWORD'];
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 587;
    }
    public function send($subject, $body, $to='adrien.deval@ikmail.com')
    {
        try {
            $this->mail->setFrom('adrien.deval@ikmail.com', 'MyWatchGuide');
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->send();
            $this->log->info("Email sent to $to with subject: $subject");
        } catch (\Exception $e) {
            $this->log->error("Email could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
        }
    }               

}

header('Location: index.php');