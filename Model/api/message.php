<?php

/*
 * 
 */
header('Content-Type: application/json');
include '../Outil.php';
$pdo = PdoInit();
$requestMethod = $_SERVER['REQUEST_METHOD'];

if (isset($_REQUEST["searchby"])) {
    $searchby = $_REQUEST["searchby"];
}
if (isset($_REQUEST["conv_id"])) {
    $conv_id = $_REQUEST["conv_id"];
}
if (isset($_REQUEST["message_id"])) {
    $message_id = $_REQUEST["message_id"];
}
if (isset($_REQUEST["searchby"])) {
    $searchby = $_REQUEST["searchby"];
}
if (isset($_REQUEST["texte"])) {
    $texte = $_REQUEST["texte"];
}
if (isset($_REQUEST["participant_id"])) {
    $participant_id = $_REQUEST["participant_id"];
}


switch ($requestMethod) {
    // ------ ROUTE GET -----
    case 'GET':
        try {
            //get message par conv_ID
            if (isset($searchby) && isset($conv_id) && $searchby == "conv_id") {
                $request = "select message.id, message.texte, user.username, message.date,message.participant_id
                    from message 
                    inner join participant on message.participant_id = participant.participant_id
                    inner join user on participant.user_id = user.user_id
                    where participant.conversation_id = :conversation_id
                    order by message.date asc";
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':conversation_id', $conv_id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
            } else {
                throw new Exception("Message n'existe pas");
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo '{"Erreur":"' . $e->getMessage() . '"}';
        }


        break;
    // ------ FIN ROUTE GET -----
    // ------ ROUTE POST -----
    case 'POST':
        TRY {
            //post message 

            if (isset($texte) && isset($participant_id)) {
                $request = "insert into message (texte,participant_id)
            values (:texte,:participant_id);";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':texte', $texte, PDO::PARAM_STR);
                $stmt->bindParam(':participant_id', $participant_id, PDO::PARAM_INT);

                $stmt->execute();
            } else {
                throw new Exception("Valeur non défini");
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
        try {
            if (isset($message_id)) {
                $request = "delete from ymmerchat.message where ymmerchat.message.id = :id;";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':id', $message_id, PDO::PARAM_STR);
                //$stmt->bindParam(':participant_id', $participant_id, PDO::PARAM_INT);

                $stmt->execute();
                echo '{"status":"ok"}';
            } else {
                throw new Exception("Message non supprimé");
            }
        } catch (Exception $e) {
            echo '{"Erreur":"' . $e->getMessage() . '"}';
        }


        break;
    // ----- FIN ROUTE DELETE -----
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}