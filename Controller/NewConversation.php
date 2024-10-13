<?php
 session_start();

require '../Model/Outil.php';
$pdo = PdoInit();

VerifyConnexion();

$user_id = $_SESSION["user_id"];
//if (isset($_GET["debug"])) {
//    $user_id = 2;
//    
//}

//if (VerifSession($pdo)) {

    ?>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Chat</title>
            <link rel="stylesheet" href="/style/styles.css">
            <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
        </head>
<body>

    <div class="chat-container">
    <h2>Créer une Conversation</h2>
   
    
    <form action="CreateConversation.php" method="POST">
        <!-- Nom de la conversation -->
        <div class="form-group">
        <label for="name">Nom de la conversation :</label>
        <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
        <!-- Conversation privée ou non -->
        <label for="private">Conversation privée :</label>
        <input type="checkbox" id="private" name="private">
        </div>
        <div class="form-group">
        <!-- Liste des utilisateurs à ajouter comme participants -->
        <label for="participants">Ajouter des participants :</label>
        <?php
       

        // Récupérer l'ID de l'utilisateur en cours
        $author = $_SESSION['user_id'];

        // Connexion à la base de données et récupération des utilisateurs
        $pdo = PdoInit();
        // Exclure l'utilisateur en cours de la liste
        $request = "SELECT user_id, username FROM user WHERE user_id != :author";
        $stmt = $pdo->prepare($request);
        $stmt->bindParam(':author', $author, PDO::PARAM_INT);
        $stmt->execute();

        // Générer des cases à cocher pour chaque utilisateur
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<input type="checkbox" name="participants[]" value="' . htmlspecialchars($row['user_id']) . '"> ' . htmlspecialchars($row['username']) . '<br>';
        }
        ?>
        </div>
        <br>
        
        <input type="submit" value="Créer la conversation">
    </form>
    </div>
    <?php include '../View/Footer.php'; ?>
</body>
