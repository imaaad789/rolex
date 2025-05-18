<?php
require_once __DIR__.'/../../config/create_db.php';
require_once __DIR__.'/../../config/helper.php';

$createDateBase = new Create_DateBase();

if (isset($_GET['url'])) {
    $url = $_GET['url'];

    switch ($url) {
        case 'ajouteAdmin':
            header("location:admin_int/addAdmin.php");
            break;
        case 'supprimeAdmin':
            header("location:admin_int/deleteAdmin.php");
            break;
        case 'afficheAdmin':
            header("location:admin_int/afficheAdmin.php");
            break;

        case 'Profil':
            header("location:../Profiels/Profiels.php");
            break;
        case 'afficheCommande':
            header("location:commande/affichage.php");
            break;
        
        case 'validationCommande':
            require_once 'PHP/MVC/view/admin/commande/validationCommande.php';
            break;
        case 'supprimeCommande':
            header("location:commande/Supprime.php");
            break;
        case 'modifierCommande':
            header("location:commande/modifier.php");
            break;
        case 'afficheHorloge':
            require_once 'afficheHorloge.php';
            break;
        case 'validationHorloge':
            require_once 'validationHorloge.php';
            break;
        case 'supprimeHorloge':
            require_once 'supprimeHorloge.php';
            break;
        case 'modifierHorloge':
            require_once 'modifierHorloge.php';
            break;
        default:
            echo "<h1>Page not found</h1>";
            break;
    }


}
?>






<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rolex Official Site</title>
    <<link rel="shortcut icon" href="/image/crown-gold.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        .header {
            width: 100%;
            background-color: #13422d;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            max-width: 150px;
        }

        .logo img {
            width: 75%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .theme-toggle {
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.1);
        }

        .user-button {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .user-button:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .user-icon {
            transition: transform 0.5s ease;
        }

        .user-button:hover .user-icon {
            transform: rotate(360deg);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            min-width: 220px;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            margin-top: 0.75rem;
            overflow: hidden;
        }

        .dropdown.active .dropdown-content {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .dropdown-content a {
            color: #1e293b;
            padding: 0.75rem 1.25rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .dropdown-content a:hover {
            background-color: #f8fafc;
            color: #13422d;
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 0.5rem 0;
        }

        .menu-icon {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.8rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .menu-icon:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background: #ffffff;
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.15);
            transition: left 0.3s ease-in-out;
            padding: 2rem;
            z-index: 1001;
        }

        .sidebar.active {
            left: 0;
        }

        .close-btn {
            font-size: 1.5rem;
            cursor: pointer;
            color: #1e293b;
            text-align: left;
            margin-bottom: 2rem;
        }

        .nav-links2 {
            list-style: none;
            padding: 0;
        }

        .nav-links2 li {
            padding: 1rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .nav-links2 a {
            text-decoration: none;
            color: #1e293b;
            font-weight: 500;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: block;
            text-align: left;
        }

        .nav-links2 a:hover {
            color: #13422d;
            transform: translateX(-5px);
        }

        .nav-links2 ul {
            display: none;
            padding-left: 1rem;
        }

        .nav-links2 ul li {
            padding: 0.5rem 0;
            font-size: 0.9rem;
            color: #4a5568;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 0 1rem;
            }

            .logo {
                max-width: 100px;
            }

            .user-button span {
                display: none;
            }

            .user-button {
                padding: 0.5rem;
            }
        }
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding-top: 80px;
            padding-bottom: 20px;
        }

        main div {
            text-align: center;
        }

        main h1 {
            color: #1e293b;
            font-size: 2rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <button class="menu-icon" id="menuIcon">
                <i class="bi bi-list"></i>
            </button>
            <div class="logo">
                <img src="<?= asset('images/crown-gold.png') ?>" alt="Rolex Logo">
            </div>
            <div class="user-section">
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
                    <i class="fas fa-moon"></i>
                </button>
                <div class="dropdown">
                    <button class="user-button" id="userButton">
                        <i class="fas fa-user user-icon"></i>
                        <span>CEO ROLEX</span>
                    </button>
                    <div class="dropdown-content" id="userDropdown">
                        <a href="../Profiels/Profiels.php" id="profile"><i class="fas fa-user-circle"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <a href="../../../../index.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="sidebar" id="sidebar">
        <div class="close-btn" id="closeBtn">✖</div>
        <ul class="nav-links2">
            <li><a href="#" id="commandeLink">Commande</a>
                <ul id="commandeSubmenu">
                    <li><a href="intrface.php?url=afficheCommande">Affiche commande</a></li>
                    <li><a href="intrface.php?url=validationCommande">Validation commande</a></li>
                    <li><a href="intrface.php?url=supprimeCommande">Supprime commande</a></li>
                    <li><a href="intrface.php?url=modifierCommande">Modifier commande</a></li>
                </ul>
            </li>
            <li><a href="#" id="horlogeLink">Horloge</a>
                <ul id="horlogeSubmenu">
                    <li><a href="intrface.php?url=afficheHorloge">Affiche Horloge</a></li>
                    <li><a href="intrface.php?url=validationHorloge">Validation Horloge</a></li>
                    <li><a href="intrface.php?url=supprimeHorloge">Supprime Horloge</a></li>
                    <li><a href="intrface.php?url=modifierHorloge">Modifier Horloge</a></li>
                </ul>
            </li>
            <li><a href="/contact">Client</a></li>
            <li><a href="intrface.php?url=Profil">Profil</a></li>
            <li><a href="/login" id="adminLink">Settings</a>
                <ul id="adminSubmenu">
                    <li><a href="intrface.php?url=afficheAdmin">Affiche admin</a></li>
                    <li><a href="intrface.php?url=supprimeAdmin">Supprime Admin</a></li>
                    <li><a href="intrface.php?url=ajouteAdmin">Ajoute Admin</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- <main>
        <div class="resultats_inter" id="resultats_inter">
            <h1>Aucun résultat</h1>
        </div>
    </main> -->

    <script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>


