<?php
session_start(); 

require_once __DIR__ . '/../../controller/Admin_Controller.php';

class InterfaceProfiels {
    private $adminController;
    private $message;
    private $message_type;
    private $admin;

    public function __construct() {
        if (!isset($_SESSION['admin_email'])) {
            header("Location: ../login/login.php");
            exit();
        }

        $this->adminController = new AdminController();
        $this->AdminProfile();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
            $this->PasswordUpdate();
        }
    }

    private function AdminProfile() {
        $admins = $this->adminController->afficheAdmin();
        $email = $_SESSION['admin_email'];
        foreach ($admins as $admin) {
            if ($admin['email'] === $email) {
                $this->admin = $admin;
                break;
            }
        }
        if (!$this->admin) {
            $this->message = "Profil non trouvé.";
            $this->message_type = "alert-danger";
        }
    }

    private function PasswordUpdate() {
        try{
            $new_password=$_POST['new_password'] ?? '';
            $confirm_password=$_POST['confirm_password'] ?? '';

            if (empty($new_password) || empty($confirm_password)){
                throw new Exception("Les champs de mot de passe ne peuvent pas être vides.");
            }

            if ($new_password !== $confirm_password){
                throw new Exception("Les mots de passe ne correspondent pas.");
            }

            if (strlen($new_password)<6){
                throw new Exception("Le mot de passe doit contenir au moins 6 caractères.");
            }

            $this->adminController->updateAdminPassword($this->admin['email'],$new_password);
            $this->message="Mot de passe mis à jour avec succès !";
            $this->message_type="alert-success";
        } catch (Exception $e) {
            $this->message="Erreur : " . $e->getMessage();
            $this->message_type="alert-danger";
        }
    }

    public function displayInterface() {
        if (!isset($_COOKIE['admin_email'])) {
            setcookie('admin_email',$this->admin['email'],time()+(2 * 60 * 60),"/");
        }
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Profil de l'Administrateur</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #f8f9fa;
                }
                .container {
                    margin-top: 30px;
                    max-width: 800px;
                }
                .card {
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                }
                .profile-image {
                    width: 150px;
                    height: 150px;
                    object-fit: cover;
                    border-radius: 50%;
                    margin-bottom: 15px;
                }
                .temp-alert {
                    position: fixed;
                    top: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    z-index: 1000;
                    animation: fadeOut 2s forwards;
                }
                @keyframes fadeOut {
                    0% { opacity: 1; }
                    90% { opacity: 1; }
                    100% { opacity: 0; visibility: hidden; }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2 class="text-center mb-4">Profil de l'Administrateur</h2>
                <div class="card">
                    <?php if (isset($this->message)): ?>
                        <div class="alert <?php echo $this->message_type; ?> temp-alert" role="alert">
                            <?php echo htmlspecialchars($this->message); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->admin): ?>
                        <div class="text-center">
                            <img src="<?php echo htmlspecialchars('../../public/' . $this->admin['profile_image'] ?? '/images/default.jpg'); ?>" class="profile-image" alt="Photo de profil">
                        </div>
                        <h4 class="text-center"><?php echo htmlspecialchars($this->admin['nom'] . ' ' . $this->admin['prenom']); ?></h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Email :</strong> <?php echo htmlspecialchars($this->admin['email']); ?></p>
                                <p><strong>Date de Naissance :</strong> <?php echo htmlspecialchars($this->admin['date_naissance']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Créé le :</strong> <?php echo htmlspecialchars($this->admin['created_at']); ?></p>
                                <p><strong>ID :</strong> <?php echo htmlspecialchars($this->admin['id']); ?></p>
                            </div>
                        </div>
                        <hr>
                        <h5 class="mt-4">Modifier le Mot de Passe</h5>
                        <form method="POST">
                            <input type="hidden" name="update_password" value="1">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Nouveau Mot de Passe</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmer le Mot de Passe</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                                <a href="../admin/intrface.php" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    <?php else: ?>
                        <p class="text-center text-danger">Aucune information de profil disponible.</p>
                    <?php endif; ?>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                const alert = document.querySelector('.temp-alert');
                if (alert) {
                    setTimeout(() => alert.style.display = 'none', 2000);
                }
            </script>
        </body>
        </html>
        <?php
    }
}




// Instantiate and display
$interface = new InterfaceProfiels();
$interface->displayInterface();
?>