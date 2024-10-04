<?php
// Inclure la connexion à la base de données
require_once '../db/db.php'; // Ajuste le chemin selon la structure

// Si le formulaire d'inscription a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérification des mots de passe
    if ($password !== $confirm_password) {
        die("Les mots de passe ne correspondent pas !");
    }

    // Vérification de l'existence de l'email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        die("Cette adresse e-mail est déjà utilisée !");
    }

    // Hacher le mot de passe et insérer les données
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $result = $stmt->execute([$username, $email, $password_hash]);

    if ($result) {
        // Rediriger vers la page de connexion après l'inscription
        header("Location: login.php");
        exit();
    } else {
        echo "Une erreur est survenue.";
    }
}
?>

<!-- HTML pour le formulaire d'inscription -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <form action="register.php" method="POST">
            <!-- Formulaire d'inscription -->
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>
        <p>Déjà inscrit ? <a href="login.php">Connectez-vous ici</a></p>
    </div>
</body>
</html>
