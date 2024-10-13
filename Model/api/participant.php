<?php

/*
 * 
 */
header('Content-Type: application/json');
include '../Outil.php';
$pdo = PdoInit();
$requestMethod = $_SERVER['REQUEST_METHOD'];
if (isset($_REQUEST["conv_id"])) {
    $conv_id = $_REQUEST["conv_id"];
}
if (isset($_REQUEST["user_id"])) {
    $user_id = $_REQUEST["user_id"];
}
if (isset($_REQUEST["name"])) {
    $name = $_REQUEST["name"];
}
if (isset($_REQUEST["participant_id"])) {
    $participant_id = $_REQUEST["participant_id"];
}
if (isset($_REQUEST["searchby"])) {
    $searchby = $_REQUEST["searchby"];
}

switch ($requestMethod) {
        // ------ ROUTE GET -----
    case 'GET':
        try {
            //recupere les conversation d'un user
            if ($searchby == "user_id") {
                $request = "select conversation.* from participant "
                    . "inner join conversation on participant.conversation_id = conversation.conv_id"
                    . " where user_id = :user_id;";
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
                //Recupere les participants d'une conversation
            } else if ($searchby == "conv_id") {
                $request = "select participant.participant_id, user.username,conversation.author 
                from participant left join user on participant.user_id = user.user_id 
                left join conversation on participant.participant_id =conversation.author 
                where conversation_id = :conversation_id;";
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':conversation_id', $conv_id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
                //recupere le participant qui correspond a la conversation et le user
            } else if ($searchby == "both") {
                $request = "select * from participant where user_id = :user_id && conversation_id = :conversation_id";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':conversation_id', $conv_id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
            } else {
                throw new Exception("Participation n'existe pas");
            }
        } catch (Exception $e) {
            echo '{"Erreur":"' . $e->getMessage() . '"}';
        }

        break;
        // ------ FIN ROUTE GET -----
        // ------ ROUTE POST -----
    case 'POST':
        try {
            //si recherche par name
            if (!isset($user_id) && isset($name)) {
                $request = "select user_id from user where username = :name";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':name', $name, PDO::PARAM_STR);

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($result)) {
                    $user_id = $result[0]["user_id"];
                }
            }
            //verification si le participant n'existe pas déja
            $request = "select * from participant where user_id = :user_id && conversation_id = :conversation_id";
            $stmt = $pdo->prepare($request);

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':conversation_id', $conv_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result) && isset($user_id)) {
                //creation du participant
                $request = "insert into participant (user_id,conversation_id) 
                    values (:user_id,:conversation_id)";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':conversation_id', $conv_id, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                throw new Exception("Utilisateur participe déja à la conversation");
            }
            echo '{"status":"ok"}';
        } catch (Exception $e) {
            echo '{"Erreur":"' . $e->getMessage() . '"}';
        }
        break;
        // ------ FIN ROUTE POST -----
        // ------ ROUTE PUT -----
    case 'PUT':
        break;

        // ------ FIN ROUTE PUT -----
        // ------ ROUTE DELETE -----
    case 'DELETE':
        if (isset($participant_id)) {
            try {
                $request = "delete from participant where participant_id = :participant_id";
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':participant_id', $participant_id, PDO::PARAM_INT);
                $stmt->execute();
                echo '{"status":"ok"}';
            } catch (Exception $e) {
                echo '{"Erreur":"' . $e->getMessage() . '"}';
            }
        }

        break;
        // ----- FIN ROUTE DELETE -----
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}
