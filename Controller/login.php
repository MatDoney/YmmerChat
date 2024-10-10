<?php
session_start();
require_once '../bdd/db_settings.php'; // Inclut le fichier de configuration de la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire de connexion
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Préparer la requête pour vérifier si l'utilisateur existe (vérifie par username ou email)
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        // Vérification si l'utilisateur existe
        if ($user) {
            // Vérifie le mot de passe hashé
            if (password_verify($password, $user['password'])) {
                // Si le mot de passe correspond, démarre la session utilisateur
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['success_message'] = "Connexion réussie. Bienvenue, " . $user['username'] . "!";
                header('Location: ../Controller/home.php'); // Redirige vers la page d'accueil
                exit;
            } else {
                // Message d'erreur si le mot de passe est incorrect
                $_SESSION['error_message'] = "Mot de passe incorrect. Veuillez réessayer.";
                header('Location: login.php'); // Redirige vers la page de connexion
                exit;
            }
        } else {
            // Message d'erreur si l'utilisateur n'existe pas
            $_SESSION['error_message'] = "Nom d'utilisateur ou email non trouvé.";
            header('Location: login.php'); // Redirige vers la page de connexion
            exit;
        }
    } catch (Exception $e) {
        // Gère les erreurs avec la base de données
        $_SESSION['error_message'] = "Erreur lors de la connexion. Veuillez réessayer plus tard.";
        header('Location: login.php'); // Redirige vers la page de connexion
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
</head>
<body>
    <div class="container mt-5">
        <h2>Connexion</h2>

        <!-- Affichage des messages d'erreur ou de succès -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error_message']; ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire de connexion -->
        <form action="" method="post" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="username">Nom d'utilisateur ou Email</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur ou email.</div>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">Veuillez entrer votre mot de passe.</div>
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>
