<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../lib/phpmailer/src/Exception.php';
require_once __DIR__ . '/../../lib/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../lib/phpmailer/src/SMTP.php';

class SendMailModel {
    private static $instance = null;
    private $mail;

    private function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'monarka.yanno@gmail.com';
        $this->mail->Password = 'phmh ftkl yljw ezdg';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = 465;
        $this->mail->setFrom('monarka.yanno@gmail.com', 'Monarka Yanno');
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Encoding = 'base64';
        $this->mail->SMTPDebug = 2; // Activer le débogage SMTP
        $this->mail->Debugoutput = 'error_log'; // Rediriger les messages de débogage vers le journal d'erreurs PHP
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new SendMailModel();
        }
        return self::$instance;
    }

    public function sendMail($to, $subject, $body) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);
            
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Erreur lors de l'envoi du mail : {$this->mail->ErrorInfo}");
            return false;
        }
    }
}
?>
