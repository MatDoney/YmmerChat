<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="chat-container">
        <h2>Bienvenue, <?php echo htmlspecialchars($username); ?> !</h2>
        <div class="chat-window">
            <!-- Fenêtre de discussion en temps réel -->
            <!-- Affichage des messages -->
        </div>
        <form action="send_message.php" method="POST">
            <input type="text" name="message" placeholder="Tapez votre message...">
            <button type="submit">Envoyer</button>
        </form>
    </div>
</body>
</html>
