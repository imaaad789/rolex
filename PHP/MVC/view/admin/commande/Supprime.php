<?php
require_once __DIR__ . '/../../../controller/Commande_Controller.php';

class InterfaceCommandeSupprime {
    private $commandController;
    private $para;
    private $message;
    private $message_type;

    public function __construct() {
        $this->commandController = new CommandController();
        $this->para = $this->commandController->Affiche_Commande();
        $this->handleDeletion();
    }

    private function handleDeletion() {
        if (isset($_GET['url']) && $_GET['url'] == 'supprimecommande' && isset($_GET['id'])) {
            try {
                $id = $_GET['id'];
                $this->commandController->Delete_Commande($id);
                $this->message = "Commande avec l'ID $id supprimée avec succès!";
                $this->message_type = "alert-success";
                $this->para = $this->commandController->Affiche_Commande();
            } catch (Exception $e) {
                $this->message = "Erreur: " . $e->getMessage();
                $this->message_type = "alert-danger";
            }
        }
    }

    public function InterfaceSupprime() {
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
                .alert {
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2 class="text-center mb-4">Liste des Commandes pour supprimer</h2>
                <?php if (isset($this->message)): ?>
                    <div class="alert <?php echo $this->message_type; ?>"><?php echo $this->message; ?></div>
                <?php endif; ?>
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
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (is_array($this->para) && count($this->para) > 0) {
                            foreach ($this->para as $cle => $value) {
                                ?>
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
                                        <form method="POST" action="Supprime.php?id=<?php echo htmlspecialchars($value['id']); ?>&url=supprimecommande" onsubmit="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="12" class="text-center">Aucune commande trouvée.</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }
}

$interface = new InterfaceCommandeSupprime();
$interface->InterfaceSupprime();
?>