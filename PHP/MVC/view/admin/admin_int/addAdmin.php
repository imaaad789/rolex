<?php
require_once __DIR__ . '/../../../controller/Admin_Controller.php';
$CreatTableAdmin=(new AdminController())->createTable();
echo $CreatTableAdmin;
class InterfaceAddAdmin {
    private $adminController;
    private $message;
    private $message_type;
    private $uploaded_image;

    public function __construct() {
        $this->adminController = new AdminController();
        $this->handleFormSubmission();
    }

    
    private function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $nom = trim($_POST['nom'] ?? '');
                $prenom = trim($_POST['prenom'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $date_naissance = trim($_POST['date_naissance'] ?? '');
                $plain_password = trim($_POST['plain_password'] ?? '');
                $profile_image = null;

                // Validate required fields
                if (!$nom || !$prenom || !$email || !$date_naissance || !$plain_password) {
                    throw new Exception("Tous les champs obligatoires doivent être remplis.");
                }

                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Format d'email invalide.");
                }

                // Handle image upload
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = __DIR__ . '/../../../public/uploads/';
                    if (!is_dir($upload_dir)) {
                        $old_umask = umask(0);
                        if (!mkdir($upload_dir, 0755, true) && !is_dir($upload_dir)) {
                            throw new Exception("Échec de la création du répertoire des uploads. Vérifiez les permissions.");
                        }
                        umask($old_umask);
                    }

                    if (!is_writable($upload_dir)) {
                        throw new Exception("Le répertoire des uploads n'est pas accessible en écriture. Vérifiez les permissions.");
                    }

                    // Validate image extension
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif','jfif'];
                    $file_extension = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
                    if (!in_array($file_extension, $allowed_extensions)) {
                        throw new Exception("Extension de fichier non autorisée. Seuls les fichiers JPG, JPEG, PNG et GIF sont acceptés.");
                    }

                    $file_name = uniqid() . '_' . basename($_FILES['profile_image']['name']);
                    $file_path = $upload_dir . $file_name;

                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $file_path)) {
                        $profile_image = '/uploads/' . $file_name;
                        $this->uploaded_image = $profile_image;
                    } else {
                        throw new Exception("Erreur lors du téléchargement de l'image. Vérifiez les permissions ou l'espace disque.");
                    }
                }

                // Add admin using the controller
                $this->adminController->addAdmin($nom, $prenom, $email, $date_naissance, $plain_password, $profile_image);
                $this->message = "Administrateur ajouté avec succès!";
                $this->message_type = "alert-success";
            } catch (Exception $e) {
                $this->message = $e->getMessage();
                $this->message_type = "alert-warning";
            }
        }
    }


    public function displayInterface() {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ajouter un Administrateur</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #f8f9fa;
                }
                .container {
                    margin-top: 30px;
                    max-width: 600px;
                }
                .form-label {
                    font-weight: bold;
                }
                .card {
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                }
                .profile-image-preview {
                    width: 150px;
                    height: 150px;
                    object-fit: cover;
                    border-radius: 50%;
                    display: block;
                    margin: 0 auto 15px;
                }
                .hidden {
                    display: none;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2 class="text-center mb-4">Ajouter un Administrateur</h2>
                <div class="card">
                    <?php if (isset($this->message)): ?>
                        <div class="alert <?php echo $this->message_type; ?>"><?php echo $this->message; ?></div>
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3 text-center">
                            <img src="<?php echo isset($this->uploaded_image) ? htmlspecialchars($this->uploaded_image) : 'https://via.placeholder.com/150'; ?>" 
                                 id="imagePreview" 
                                 class="profile-image-preview <?php echo !isset($this->uploaded_image) ? 'hidden' : ''; ?>" 
                                 alt="Aperçu de l'image">
                            <label for="profile_image" class="form-label">Image de Profil (facultatif)</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="date_naissance" class="form-label">Date de Naissance</label>
                            <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                        </div>
                        <div class="mb-3">
                            <label for="plain_password" class="form-label">Mot de Passe</label>
                            <input type="password" class="form-control" id="plain_password" name="plain_password" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                            <a href="../intrface.php" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                document.getElementById('profile_image').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imagePreview = document.getElementById('imagePreview');
                            imagePreview.src = e.target.result;
                            imagePreview.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            </script>
        </body>
        </html>
        <?php
    }
}

// Instantiate and display
$interface = new InterfaceAddAdmin();
$interface->displayInterface();
?>