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

$user_id = $_SESSION['user_id'];
// Récupérer l'ID de l'utilisateur connecté


// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $private = isset($_POST['private']) ? 1 : 0; // 1 si privé, sinon 0
    $participants = isset($_POST['participants']) ? $_POST['participants'] : [];


    // Initialiser la connexion à la base de données

    try {
        //creation du participant a partir de l'auteur";
        $request = "insert into participant (user_id,conversation_id) 
        values (:user_id,null)";
        $stmt = $pdo->prepare($request);

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $participant_id = $pdo->lastInsertId();
        //création de la conversation";
        $request = "insert into conversation (name,author,private) 
        values (:name,:author,:private)";
        $stmt = $pdo->prepare($request);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':author', $participant_id, PDO::PARAM_INT);
        $stmt->bindParam(':private', $private, PDO::PARAM_INT);
        $stmt->execute();
        $conv_id = $pdo->lastInsertId();
        //on assigne au participant la conversation";
        $request = "update participant 
                set conversation_id = :conv_id
                where participant_id = :participant_id ";
        $stmt = $pdo->prepare($request);
        $stmt->bindParam(':participant_id', $participant_id, PDO::PARAM_INT);
        $stmt->bindParam(':conv_id', $conv_id, PDO::PARAM_INT);
        $stmt->execute();
        // Vérifier l'existence des autres utilisateurs avant de les ajouter
        foreach ($participants as $user_id) {
            // Vérifie si l'utilisateur existe
            $userCheck = $pdo->prepare("SELECT COUNT(*) FROM user WHERE user_id = ?");
            $userCheck->execute([$user_id]);
            if ($userCheck->fetchColumn() > 0) {
                // Ajouter le participant à la conversation
                $request = "insert into participant (user_id,conversation_id) 
        values (:user_id,:conv_id)";
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':conv_id', $conv_id, PDO::PARAM_INT);

                $stmt->execute();
            } else {
                echo "L'utilisateur avec l'ID $user_id n'existe pas. <br>";
            }
        }


        // Rediriger vers la page de la conversation
        header("Location: Chatting.php?conv_id=" . $conversation_id);

        exit(); // Toujours utiliser exit après une redirection

    } catch (PDOException $e) {
        // Gérer les erreurs (optionnel : enregistrer les erreurs, afficher un message, etc.)
        echo "Erreur lors de la création de la conversation : ".$e->getLine()." " . $e->getMessage();
    }
    //echo "Paramètres pour la conversation : Name: $name, Author ID: $participant_id, Private: $private <br>";
}
