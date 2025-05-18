<?php
require_once __DIR__ . '/../../../controller/Admin_Controller.php';

$adminController = new AdminController();
$admins = $adminController->afficheAdmin();
$success_message = null;

// Handle delete request
if (isset($_POST['delete_email'])) {
    $email = $_POST['delete_email'];
    $adminController->deleteAdmin($email);
    $success_message = "Admin avec l'email $email supprimé avec succès !";
    header("Refresh:2; url=".$_SERVER['PHP_SELF']);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }
        .delete-btn:hover {
            background-color: #cc0000;
        }
        .success-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            animation: fadeInOut 3s ease-in-out;
            z-index: 1000;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
            10% { opacity: 1; transform: translateX(-50%) translateY(0); }
            90% { opacity: 1; transform: translateX(-50%) translateY(0); }
            100% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
        }
    </style>
</head>
<body>
    <?php if ($success_message): ?>
        <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>
    <h1>Admin Management</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Date de Naissance</th>
                <th>Image de Profil</th>
                <th>Créé le</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($admins && count($admins) > 0): ?>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin['id']); ?></td>
                        <td><?php echo htmlspecialchars($admin['nom']); ?></td>
                        <td><?php echo htmlspecialchars($admin['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                        <td><?php echo htmlspecialchars($admin['date_naissance']); ?></td>
                        <td><?php echo htmlspecialchars($admin['profile_image'] ?? 'Aucune'); ?></td>
                        <td><?php echo htmlspecialchars($admin['created_at']); ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="delete_email" value="<?php echo htmlspecialchars($admin['email']); ?>">
                                <button type="submit" class="delete-btn" onclick="return confirm('Voulez-vous vraiment supprimer cet admin ?');">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Aucun administrateur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>