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
        $this->mail->Host = 'smtp.assoforum-paysdegrasse.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'contact@assoforum-paysdegrasse.com';
        $this->mail->Password = '#FORUM06130';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Utiliser SMTPS pour la sécurité
        $this->mail->Port = 465;
        $this->mail->setFrom('contact@assoforum-paysdegrasse.com', 'Assoforum Pays de Grasse');
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Encoding = 'base64';
        $this->mail->SMTPDebug = 2; // Activer le débogage SMTP
        $this->mail->Debugoutput = 'error_log'; // Rediriger les messages de débogage vers le journal d'erreurs PHP
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
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
            $this->mail->isHTML(true); // Assurez-vous que les emails sont envoyés en HTML
            $this->mail->Subject = $subject;

            // Adding an image to the email body
            $imageUrl = 'https://www.assoforum-paysdegrasse.com/public/images/logo/Logo%20Association%20Forum.jpg'; // Replace with your image URL
            $body .= '<br><br><img src="' . $imageUrl . '" alt="Profile Image" style="width:100px;height:100px;">';

            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body); // Version texte brut pour les clients email ne supportant pas le HTML
            
            $this->mail->send();
        return true;
        } catch (Exception $e) {
            error_log("Erreur lors de l'envoi du mail : {$this->mail->ErrorInfo}");
            return false;
        }
    }
}

?>
