<?php
session_start();
require_once '../bdd/db_settings.php'; // Inclut le fichier de configuration de la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $num = $_POST['num'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Vérifie si les mots de passe correspondent
    if ($password !== $confirmPassword) {
        $_SESSION['error_message'] = "Les mots de passe ne correspondent pas."; // Stocke l'erreur dans une session
        header('Location: signup.php'); // Redirige vers le formulaire d'inscription
        exit;
    }

    // Vérification si l'utilisateur ou l'email existe déjà
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['error_message'] = "Le nom d'utilisateur ou l'email existe déjà."; // Stocke l'erreur dans une session
        header('Location: signup.php'); // Redirige vers le formulaire d'inscription
        exit;
    } else {
        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insérer dans la base de données
        $stmt = $pdo->prepare("INSERT INTO user (username, email, nom, prenom, num, password) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$username, $email, $nom, $prenom, $num, $hashedPassword])) {
            $_SESSION['success_message'] = "Inscription réussie. Vous allez être redirigé vers la page d'accueil."; // Message de succès
            header('Location: home.php'); // Redirige vers home.php
            exit;
        } else {
            $_SESSION['error_message'] = "Erreur lors de l'inscription. Veuillez réessayer."; // Stocke l'erreur dans une session
            header('Location: signup.php'); // Redirige vers le formulaire d'inscription
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Lien vers Bootstrap -->
</head>
<body>
    <div class="container mt-5">
        <h2>Inscription</h2>

        <!-- Affichage des messages d'erreur ou de succès -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error_message']; ?>
                <?php unset($_SESSION['error_message']); ?> <!-- Efface le message après affichage -->
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); ?> <!-- Efface le message après affichage -->
            </div>
        <?php endif; ?>

        <!-- Formulaire d'inscription -->
        <form action="" method="post" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <div class="invalid-feedback">Veuillez entrer un nom d'utilisateur.</div>
            </div>

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
            </div>

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
                <div class="invalid-feedback">Veuillez entrer votre nom.</div>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
                <div class="invalid-feedback">Veuillez entrer votre prénom.</div>
            </div>

            <div class="form-group">
                <label for="num">Numéro de téléphone</label>
                <input type="tel" class="form-control" id="num" name="num" required>
                <div class="invalid-feedback">Veuillez entrer votre numéro de téléphone.</div>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">Veuillez entrer un mot de passe.</div>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                <div class="invalid-feedback">Les mots de passe ne correspondent pas.</div>
            </div>

            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</body>
</html>
