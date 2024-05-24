    <?php
    class RegisterController {
        public function index() {
            // Charge la vue d'inscription
            require_once BASE_PATH . '/app/view/inscription.php';
        }

        public function register() {
            require_once BASE_PATH . '/init.php'; 
            require_once BASE_PATH . '/app/model/UserModel.php';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $date_naissance = filter_input(INPUT_POST, 'date_naissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $date_naissance = date('Y-m-d', strtotime($date_naissance)); // Reformate la date
                $adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $ville = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $code_postal = filter_input(INPUT_POST, 'code_postal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $pays = filter_input(INPUT_POST, 'pays', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_SPECIAL_CHARS);

                $userModel = new UserModel(); // Création de l'utilisateur

                // Validation côté serveur
                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "Adresse email non valide.";
                } elseif ($password !== $confirm_password) {
                    $error = "Les mots de passe ne correspondent pas.";
                } elseif (strlen($password) < 8 || !preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]/', $password)) {
                    $error = "Le mot de passe doit contenir au moins 8 caractères, incluant une majuscule, un chiffre et un caractère spécial.";
                } elseif ($userModel->emailExists($email)) {
                    $error = "Email déjà utilisé par un autre compte.";
                } else {
                    // Génération du token de vérification
                    $verificationToken = $userModel->generateEmailVerificationToken($email);
                
                    // Envoi de l'e-mail de vérification avec le token
                    $verificationLink = "<p>http://" . $_SERVER['HTTP_HOST'] . "/app/verify_email?token=" . $verificationToken . "</p>";
                    $subject = "Forum du Pays de Grasse - Vérification de votre adresse e-mail";
                    $message = "<p>Cliquez sur le lien suivant pour vérifier votre adresse e-mail : " . $verificationLink . "</p><p>Ce lien expire dans 24 heures.</p>";
                    $emailSent = $userModel->sendEmail($email, $subject, $message);
                
                    if (!$emailSent) {
                        // Erreur lors de l'envoi de l'e-mail
                        $error = "Erreur lors de l'envoi de l'e-mail. Veuillez réessayer ultérieurement.";
                    } else {
                        // Insertion dans la base de données
                        if ($userModel->createUser($nom, $prenom, $email, $password, $date_naissance, $adresse, $ville, $code_postal, $pays)) {
                            // Redirection vers la page de connexion
                            header('Location: /app/connexion?success=check_email');
                            exit();
                        } else {
                            // Gestion de l'erreur
                            $error = "Erreur lors de l'inscription. L'utilisateur existe peut-être déjà ou il y a un problème avec la base de données.";
                        }
                    }
                }
                if (isset($error)) {
                    // Redirection vers la page d'inscription avec le message d'erreur
                    header('Location: /app/inscription?error=' . urlencode($error));
                    exit();
                }
            }
        }

        public function verifyEmail() {
            require_once BASE_PATH . '/init.php'; 
            require_once BASE_PATH . '/app/model/UserModel.php';
    
            // On récupère le token depuis l'URL
            $token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            if (!empty($token)) {
                // Création du UserModel
                $userModel = new UserModel();
    
                // Vérification token
                $emailVerified = $userModel->verifyEmailVerificationToken($token);
    
                if ($emailVerified) {
                    // L'email a été vérifiée
                    // Redirection vers une page de succès
                    header('Location: /app/email_verified');
                    exit();
                } else {
                    // L'email n'a pas été vérifiée
                    // Redirection vers une page d'erreur
                    header('Location: /app/email_verification_failed');
                    exit();
                }
            } else {
                // Token non detecté dans l'URL
                // Redirection vers une page d'erreur
                header('Location: /app/email_verification_failed');
                exit();
            }
        }
    }