<?php
class LoginController {
    public function index() {
        // Charge la vue de connexion
        require_once BASE_PATH . '/app/view/connexion.php';
    }

    public function login() {
        require_once BASE_PATH . '/init.php'; 
        require_once BASE_PATH . '/app/model/UserModel.php';
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    
            // Vérifiez que les champs ne sont pas vides
            if (!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $userModel = new UserModel();
    
                // Vérifiez si le cooldown est expiré
                $loginCooldown = 180; // 3 minutes en secondes
                $maxLoginAttempts = 5;
    
                if (isset($_SESSION['login_attempts']) && isset($_SESSION['last_login_attempt_time'])) {
                    $lastLoginAttemptTime = $_SESSION['last_login_attempt_time'];
                    $loginAttempts = $_SESSION['login_attempts'];
    
                    // Vérifiez si le cooldown est expiré
                    if (time() - $lastLoginAttemptTime > $loginCooldown) {
                        // Le cooldown est expiré, réinitialisez les tentatives de connexion
                        $_SESSION['login_attempts'] = 1;
                        $_SESSION['last_login_attempt_time'] = time();
                    } else {
                        // Le cooldown n'est pas expiré, vérifiez si le nombre maximum de tentatives de connexion est dépassé
                        if ($loginAttempts >= $maxLoginAttempts) {
                            header("Location: /app/connexion?error=" . urlencode("Vous avez atteint le nombre maximal de tentatives de connexion. Veuillez réessayer plus tard."));
                            exit();
                        }
                    }
                } else {
                    // Première tentative de connexion
                    $_SESSION['login_attempts'] = 1;
                    $_SESSION['last_login_attempt_time'] = time();
                }
    
                // Vérifiez les identifiants de l'utilisateur
                $isValid = $userModel->validateUser($email, $password);
    
                if (!$isValid) {
                    // Identifiants incorrects, incrémentez le nombre de tentatives de connexion
                    if (isset($_SESSION['login_attempts'])) {
                        $_SESSION['login_attempts']++;
                    } else {
                        $_SESSION['login_attempts'] = 1;
                    }
                    $_SESSION['last_login_attempt_time'] = time();
                    header("Location: /app/connexion?error=" . urlencode("Identifiants incorrects, veuillez réessayer."));
                    exit();
                }
    
                // Vérifie si l'utilisateur est vérifié
                if ($userModel->isUserVerified($email)) {
                    // Utilisateur vérifié, connectez-le
                    $userType = $userModel->getUserType($email);
                    $_SESSION['user_logged_in'] = true; 
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_type'] = $userType;

                    // Récupérer et stocker toutes les informations de l'utilisateur dans la session
                    $userInfo = $userModel->getUserInfo($email);
                    $_SESSION['user'] = $userInfo;

                    $userModel->updateLastLogin($email); // Mise à jour de la dernière connexion
                    header("Location: /app/index"); // Redirigez vers la page d'accueil
                    exit();
                } else {
                    // Si l'utilisateur n'est pas vérifié, génère un nouveau token si nécessaire
                    $newToken = $userModel->generateTokenIfNeeded($email);
                    if ($newToken) {                  
                        // Envoi de l'e-mail de vérification avec le token
                        $verificationLink = "<p>http://" . $_SERVER['HTTP_HOST'] . "/app/verify_email?token=" . $newToken . "</p>";
                        $subject = "Forum du Pays de Grasse - Vérification de votre adresse e-mail";
                        $message = "<p>Cliquez sur le lien suivant pour vérifier votre adresse e-mail : " . $verificationLink . "</p><p>Ce lien expire dans 24 heures.</p>";
                        $emailSent = $userModel->sendEmail($email, $subject, $message);
                        if (!$emailSent) {
                            // Erreur lors de l'envoi de l'e-mail
                            $error = "Erreur lors de l'envoi de l'e-mail du token. Veuillez réessayer ultérieurement.";
                        } else {
                            // Redirection vers la page de connexion avec un message de succès
                            header('Location: /app/connexion?success=check_email');
                            exit();
                        }
                    } else {
                        // Redirection vers une page d'erreur indiquant que l'utilisateur doit vérifier son e-mail
                        header("Location: /app/connexion?error=" . urlencode("Votre compte n'a pas encore été vérifié. Veuillez vérifier votre adresse email avant de vous connecter."));
                        exit();
                    }
                }
            } else {
                header("Location: /app/connexion?error=" . urlencode("Email invalide ou champs vides, veuillez réessayer."));
                exit();
            }
        }
    }
}
?>
