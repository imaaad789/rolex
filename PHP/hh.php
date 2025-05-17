<?php
if (isset($_GET['url']) && $_GET['url'] === 'supprimecommande' && isset($_GET['id'])) {
    $conn = new mysqli("localhost", "username", "password", "database");
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $id = $conn->real_escape_string($_GET['id']);
    $sql = "DELETE FROM commande WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: interface.php?message=Commande supprimée avec succès");
        exit;
    } else {
        header("Location: interface.php?error=Erreur lors de la suppression");
        exit;
    }

    $conn->close();
}
?>











<?php
class InterfaceCommandeModifier {
    private $conn;
    private $para;

    public function __construct($conn, $para) {
        $this->conn = $conn;
        $this->para = $para;
    }

    public function InterfaceModifier($para) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Liste des Commandes</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #f8f9fa;
                }
                .container {
                    margin-top: 30px;
                }
                .table {
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                .table th {
                    background-color: #007bff;
                    color: white;
                }
                .table td, .table th {
                    vertical-align: middle;
                }
                .btn-warning {
                    padding: 5px 10px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2 class="text-center mb-4">Liste des Commandes à Modifier</h2>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Ville</th>
                            <th>Code Postal</th>
                            <th>N° Téléphone</th>
                            <th>Référence</th>
                            <th>Type de Paiement</th>
                            <th>Date de Création</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($para) > 0): ?>
                            <?php foreach ($para as $value): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($value['id']); ?></td>
                                    <td><?php echo htmlspecialchars($value['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($value['prenom']); ?></td>
                                    <td><?php echo htmlspecialchars($value['email']); ?></td>
                                    <td><?php echo htmlspecialchars($value['adress']); ?></td>
                                    <td><?php echo htmlspecialchars($value['ville']); ?></td>
                                    <td><?php echo htmlspecialchars($value['code_postal']); ?></td>
                                    <td><?php echo htmlspecialchars($value['numero_telephone']); ?></td>
                                    <td><?php echo htmlspecialchars($value['reference_number']); ?></td>
                                    <td><?php echo htmlspecialchars($value['type_paiement']); ?></td>
                                    <td><?php echo htmlspecialchars($value['created_at']); ?></td>
                                    <td>
                                        <form method="GET" action="modifier_commande.php">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($value['id']); ?>">
                                            <button type="submit" class="btn btn-warning btn-sm">Modifier</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="12" class="text-center">Aucune commande trouvée.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }

    public function FormulaireModifier($id) {
        // Échapper l'ID pour éviter les injections SQL
        $id = $this->conn->real_escape_string($id);

        // Récupérer les détails de la commande
        $sql = "SELECT * FROM commande WHERE id = '$id'";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $commande = $result->fetch_assoc();
        } else {
            echo "<p class='text-center text-danger'>Commande non trouvée.</p>";
            return;
        }

        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier la Commande #<?php echo htmlspecialchars($id); ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #f8f9fa;
                }
                .container {
                    margin-top: 30px;
                    max-width: 800px;
                }
                .form-label {
                    font-weight: bold;
                }
                .card {
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2 class="text-center mb-4">Modifier la Commande #<?php echo htmlspecialchars($id); ?></h2>
                <div class="card">
                    <form method="POST" action="modifier_commande.php">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($commande['id']); ?>">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($commande['nom']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($commande['prenom']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($commande['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="adress" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="adress" name="adress" value="<?php echo htmlspecialchars($commande['adress']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" class="form-control" id="ville" name="ville" value="<?php echo htmlspecialchars($commande['ville']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="code_postal" class="form-label">Code Postal</label>
                            <input type="text" class="form-control" id="code_postal" name="code_postal" value="<?php echo htmlspecialchars($commande['code_postal']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="numero_telephone" class="form-label">N° Téléphone</label>
                            <input type="text" class="form-control" id="numero_telephone" name="numero_telephone" value="<?php echo htmlspecialchars($commande['numero_telephone']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="reference_number" class="form-label">Référence</label>
                            <input type="text" class="form-control" id="reference_number" name="reference_number" value="<?php echo htmlspecialchars($commande['reference_number']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="type_paiement" class="form-label">Type de Paiement</label>
                            <select class="form-select" id="type_paiement" name="type_paiement" required>
                                <option value="MasterCard" <?php echo $commande['type_paiement'] === 'MasterCard' ? 'selected' : ''; ?>>MasterCard</option>
                                <option value="Visa" <?php echo $commande['type_paiement'] === 'Visa' ? 'selected' : ''; ?>>Visa</option>
                                <option value="Apple Pay" <?php echo $commande['type_paiement'] === 'Apple Pay' ? 'selected' : ''; ?>>Apple Pay</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Valider</button>
                            <a href="interface.php" class="btn btn-secondary">Annuler</a>
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
?>