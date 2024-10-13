<?php
 session_start();

require '../Model/Outil.php';
$pdo = PdoInit();

VerifyConnexion();

// Récupérer l'ID de l'utilisateur connecté
if (!isset($_SESSION['user_id'])) {
    echo "L'utilisateur n'est pas connecté.";
    exit;
}


// Récupérer l'ID de l'utilisateur connecté
$author = $_SESSION['user_id'];

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $private = isset($_POST['private']) ? 1 : 0; // 1 si privé, sinon 0
    $participants = isset($_POST['participants']) ? $_POST['participants'] : [];

    // Initialiser la connexion à la base de données
   
    try {
        // Insérer la conversation et récupérer l'ID de la conversation
        $stmt = $pdo->prepare("INSERT INTO conversation (name, author, private) VALUES (?, ?, ?)");
        $stmt->execute([$name, $author, $private]); // Utiliser l'ID de l'auteur ici
        $conversation_id = $pdo->lastInsertId(); // Récupérer l'ID de la nouvelle conversation

        // Ajouter l'auteur comme participant
        $stmt_participant = $pdo->prepare("INSERT INTO participant (user_id, conversation_id) VALUES (?, ?)");
        $stmt_participant->execute([$author, $conversation_id]); // Ajout de l'auteur

        // Vérifier l'existence des autres utilisateurs avant de les ajouter
        foreach ($participants as $user_id) {
            // Vérifie si l'utilisateur existe
            $userCheck = $pdo->prepare("SELECT COUNT(*) FROM user WHERE user_id = ?");
            $userCheck->execute([$user_id]);
            if ($userCheck->fetchColumn() > 0) {
                // Ajouter le participant à la conversation
                $stmt_participant->execute([$user_id, $conversation_id]);
            } else {
                echo "L'utilisateur avec l'ID $user_id n'existe pas. <br>";
            }
        }


        // Rediriger vers la page de la conversation
        header("Location: Chatting.php?conv_id=" . $conversation_id);

        exit(); // Toujours utiliser exit après une redirection
        
    } catch (PDOException $e) {
        // Gérer les erreurs (optionnel : enregistrer les erreurs, afficher un message, etc.)
        echo "Erreur lors de la création de la conversation : " . $e->getMessage();
        
    }
    echo "Paramètres pour la conversation : Name: $name, Author ID: $participant_id, Private: $private <br>";
}
?>