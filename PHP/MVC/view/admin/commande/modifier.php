<?php
    require_once __DIR__ . '../../../../controller/Commande_Controller.php';
    class InterfaceCommandeModifier{
        private $para;

        public function __construct($para){
            $this->para=$para;
            $this->InterfaceModifier($this->para);
        }

        public function InterfaceModifier($para){
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
                <h2 class="text-center mb-4">Liste des Commandes pour supprime</h2>
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
                            <th>Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (is_array($para) && count($para) > 0){
                            foreach($para as $cle=>$value) {
                                ?>
                                <tr>
                                    <td><?php echo $value['id'];?></td>
                                    <td><?php echo $value['nom'];?></td>
                                    <td><?php echo $value['prenom'];?></td>
                                    <td><?php echo $value['email'];?></td>
                                    <td><?php echo $value['adress'];?></td>
                                    <td><?php echo $value['ville'];?></td>
                                    <td><?php echo $value['code_postal'];?></td>
                                    <td><?php echo $value['numero_telephone'];?></td>
                                    <td><?php echo $value['reference_number'];?></td>
                                    <td><?php echo $value['type_paiement'];?></td>
                                    <td><?php echo $value['created_at'];?></td>
                                    <td>
                                        <form method="POST" action="modifier_Formulaire.php?id=<?php echo ($value['id']); ?>&url=modifiercommande" onsubmit="return confirm('Voulez-vous vraiment modifer cette commande ?');">
                                            <button type="submit" class="btn btn-danger btn-sm">Modifier</button>
                                        </form>
                                    </td>
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
    
    $controller_obj=new CommandController();
    $affiche_comm=$controller_obj->Affiche_Commande();
    $obj=new InterfaceCommandeModifier($affiche_comm);

?>