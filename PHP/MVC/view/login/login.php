<?php
session_start(); // Start the session

require_once __DIR__ . '/../../controller/Admin_Controller.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminController = new AdminController();
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember_me = isset($_POST['remember_me']);

    try {
        $admins = $adminController->afficheAdmin();
        $authenticated = false;

        foreach ($admins as $admin) {
            if ($admin['email'] === $email && password_verify($password, $admin['password'])) {
                $authenticated = true;
                $_SESSION['admin_email'] = $email;
                if ($remember_me) {
                    setcookie('admin_email', $email, time() + (30 * 24 * 60 * 60), "/");
                } else {
                    setcookie('admin_email', '', time() - 3600, "/");
                }
                header("Location: ../admin/intrface.php");
                exit();
            }
        }

        if (!$authenticated) {
            throw new Exception("Email ou mot de passe incorrect.");
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
        $message_type = "alert-danger";
    }
}

$preFilledEmail = $_COOKIE['admin_email'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            /* background: linear-gradient(135deg,rgb(166, 168, 173),rgb(156, 171, 164)); */
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .form-label {
            font-weight: 500;
            color: #444;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .btn-primary {
            background: linear-gradient(95deg,#007740,#009751);
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-weight: 500;
            width: 100%;
            transition: transform 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(90deg,#093c24,#02341dc3);
        }
        .form-check-label {
            color: #555;
        }
        .temp-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            animation: fadeOut 2s forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; visibility: hidden; }
        }
        .footer-text {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Connexion Administrateur</h2>
        <?php if ($message): ?>
            <div class="alert <?php echo $message_type; ?> temp-alert" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($preFilledEmail); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de Passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me" <?php echo $preFilledEmail ? 'checked' : ''; ?>>
                <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
            </div>
            <button type="submit" class="btn btn-primary">Se Connecter</button>
        </form>
        <div class="footer-text">
            © <?php echo date('Y'); ?> Rolex Admin System
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const alert = document.querySelector('.temp-alert');
        if (alert) {
            setTimeout(() => alert.style.display = 'none', 2000);
        }
    </script>
</body>
</html>