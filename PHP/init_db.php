<?php
    require_once __DIR__ . '/MVC/config/create_db.php';
    require_once __DIR__ . '/MVC/config/connexion_db.php';
    require_once __DIR__ . '/MVC/model/admin/admin.php';
    require_once __DIR__ . '/MVC/model/commande/commande.php';
    require_once __DIR__ . '/MVC/model/watches/watche.php';

    $baseDonnee=new Create_DateBase();
    $conn=DatabaseConnection::getInstance()->getConnection();
    $table_Admin=new Admin($conn);
    $table_Admin->createTable();

    $table_Commande=new Commande($conn);
    $table_Watche=new Create_Table_Watche($conn);


?>