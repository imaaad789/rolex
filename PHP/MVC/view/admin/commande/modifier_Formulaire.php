<?php
require_once __DIR__ . '/../../../controller/Commande_Controller.php';

if (!class_exists('Modifier_par_Formulaire')) {
    class Modifier_par_Formulaire {
        private $id;
        private $para;
        public $message;
        public $message_type;

        public function __construct($id) {
            $this->id = $id;
            $this->para = (new CommandController())->Affiche_Commande_id($id);
            $this->handleFormSubmission();
        }

        private function handleFormSubmission() {
            if (isset($_GET['url']) && $_GET['url'] == "valideCommande") {
                try {
                    $id = $_POST['id'];
                    $nom = $_POST['nom'];
                    $prenom = $_POST['prenom'];
                    $email = $_POST['email'];
                    $adress = $_POST['adress'];
                    $ville = $_POST['ville'];
                    $code_postal = $_POST['code_postal'];
                    $numero_telephone = $_POST['numero_telephone'];
                    $reference_number = $_POST['reference_number'];
                    $type_paiement = $_POST['type_paiement'];

                    if (!$id || !$nom || !$prenom || !$email || !$adress || !$ville || !$code_postal || !$numero_telephone || !$reference_number || !$type_paiement) {
                        throw new Exception("Tous les champs sont requis.");
                    }

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        throw new Exception("Format d'email invalide.");
                    }
                    require_once __DIR__ . '/../../../config/connexion_db.php';
                    $conn = DatabaseConnection::getInstance()->getConnection();

                    $sql = "UPDATE commande SET 
                        nom = ?, 
                        prenom = ?, 
                        email = ?, 
                        adress = ?, 
                        ville = ?, 
                        code_postal = ?, 
                        numero_telephone = ?, 
                        reference_number = ?, 
                        type_paiement = ?
                        WHERE id = ?";

                    $stmt = $conn->prepare($sql);
                    if (!$stmt) {
                        throw new Exception("Erreur de préparation de la requête.");
                    }

                    $stmt->bindParam(1, $nom);
                    $stmt->bindParam(2, $prenom);
                    $stmt->bindParam(3, $email);
                    $stmt->bindParam(4, $adress);
                    $stmt->bindParam(5, $ville);
                    $stmt->bindParam(6, $code_postal);
                    $stmt->bindParam(7, $numero_telephone);
                    $stmt->bindParam(8, $reference_number);
                    $stmt->bindParam(9, $type_paiement);
                    $stmt->bindParam(10, $id);

                    if ($stmt->execute()) {
                        $this->message = "Commande mise à jour avec succès.";
                        $this->message_type = "alert-success";
                        header("Location: modifier.php");
                        exit;
                    } else {
                        throw new Exception("Erreur lors de la mise à jour de la commande.");
                    }
                } catch (Exception $e) {
                    $this->message = "Erreur: " . $e->getMessage();
                    $this->message_type = "alert-danger";
                }
            }
        }

        public function FormulaireModifier($id) {
            if ($this->para && count($this->para) == 0) {
                echo "<p class='text-center text-danger'>Commande non trouvée.</p>";
                return;
            }
            // print_r($this->para);
            ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Modifier la Commande #<?php echo htmlspecialchars($id); ?></title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { background-color: #f8f9fa; }
                    .container { margin-top: 30px; max-width: 800px; }
                    .form-label { font-weight: bold; }
                    .card { box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2 class="text-center mb-4">Modifier la Commande #<?php echo htmlspecialchars($id); ?></h2>
                    <div class="card">
                        <?php if (isset($this->message)): ?>
                            <div class="alert <?php echo $this->message_type; ?>"><?php echo $this->message; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="modifier_Formulaire.php?url=valideCommande">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($this->para[$id-1]['id']); ?>">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($this->para[$id-1]['nom']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($this->para[$id-1]['prenom']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($this->para[$id-1]['email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="adress" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="adress" name="adress" value="<?php echo htmlspecialchars($this->para[$id-1]['adress']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="ville" class="form-label">Ville</label>
                                <input type="text" class="form-control" id="ville" name="ville" value="<?php echo htmlspecialchars($this->para[$id-1]['ville']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="code_postal" class="form-label">Code Postal</label>
                                <input type="text" class="form-control" id="code_postal" name="code_postal" value="<?php echo htmlspecialchars($this->para[$id-1]['code_postal']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="numero_telephone" class="form-label">N° Téléphone</label>
                                <input type="text" class="form-control" id="numero_telephone" name="numero_telephone" value="<?php echo htmlspecialchars($this->para[$id-1]['numero_telephone']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="reference_number" class="form-label">Référence</label>
                                <input type="text" class="form-control" id="reference_number" name="reference_number" value="<?php echo htmlspecialchars($this->para[$id-1]['reference_number']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="type_paiement" class="form-label">Type de Paiement</label>
                                <select class="form-select" id="type_paiement" name="type_paiement" required>
                                    <option value="MasterCard" <?php echo $this->para[$id-1]['type_paiement'] === 'MasterCard' ? 'selected' : ''; ?>>MasterCard</option>
                                    <option value="Visa" <?php echo $this->para[$id-1]['type_paiement'] === 'Visa' ? 'selected' : ''; ?>>Visa</option>
                                    <option value="Apple Pay" <?php echo $this->para[$id-1]['type_paiement'] === 'Apple Pay' ? 'selected' : ''; ?>>Apple Pay</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <a href="../intrface.php" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            </body>
            </html>
            <?php
        }
    }
}

$modifier_obj = new Modifier_par_Formulaire($_GET['id']);
$modifier_obj->FormulaireModifier($_GET['id']);
?>