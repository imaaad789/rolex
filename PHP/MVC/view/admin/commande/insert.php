<?php
    require_once __DIR__ . '/../../../controller/Commande_Controller.php';
    require_once __DIR__ . '/../../../../init_db.php';

    if(isset($_GET['url']) && !empty($_GET['url'])){
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $email=$_POST['email'];
        $adress=$_POST['adress'];
        $ville=$_POST['ville'];
        $code_postal=$_POST['code_postal'];
        $numero_telephone=$_POST['numero_telephone'];
        
        $reference_number=$_POST['reference_number'];
        $type_paiement=$_POST['type_paiement'];
        $commandeController = new CommandController();
        $message = $commandeController->Validation_Commande($nom,$prenom,$email,$adress,$ville,$code_postal,$numero_telephone,$reference_number,$type_paiement);
        if(isset($message)){
            echo "<script>alert('$message');</script>";
            header("Refresh:1; url=../../../../../html/".$_GET['url']);
        }else{
            echo "<script>alert('Erreur lors de la validation de la commande.');</script>";
            header("Refresh:1; url=../../../../../html/".$_GET['url']);
        }
    }



?>