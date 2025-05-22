<?php
class InterfaceCommandeAffiche {
    private $para;

    public function __construct($para) {
        $this->para = $para ?? [];
        $this->AfficheInterface($this->para);
    }

    public function AfficheInterface($para) {
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
            </style>
        </head>
        <body>
            <div class="container">
                <h2 class="text-center mb-4">Liste des Commandes</h2>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (is_array($para) && count($para)>0) {
                            foreach ($para as $value) {
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($value['id']) ?></td>
                                    <td><?= htmlspecialchars($value['nom']) ?></td>
                                    <td><?= htmlspecialchars($value['prenom']) ?></td>
                                    <td><?= htmlspecialchars($value['email']) ?></td>
                                    <td><?= htmlspecialchars($value['adress']) ?></td>
                                    <td><?= htmlspecialchars($value['ville']) ?></td>
                                    <td><?= htmlspecialchars($value['code_postal']) ?></td>
                                    <td><?= htmlspecialchars($value['numero_telephone']) ?></td>
                                    <td><?= htmlspecialchars($value['reference_number']) ?></td>
                                    <td><?= htmlspecialchars($value['type_paiement']) ?></td>
                                    <td><?= htmlspecialchars($value['created_at']) ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="11" class="text-center">Aucune commande trouvée.</td>
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
require_once __DIR__ . '/../../../controller/Commande_Controller.php';
$ParaAfficheComm = (new CommandController())->Affiche_Commande();
$AfficheComm = new InterfaceCommandeAffiche($ParaAfficheComm);
?>

