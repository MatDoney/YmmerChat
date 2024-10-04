<?php

/*
 * 
 */
header('Content-Type: application/json');
include '../Outil.php';
$pdo = PdoInit();
$requestMethod = $_SERVER['REQUEST_METHOD'];

$searchby = $_POST["searchby"];

switch ($requestMethod) {
    // ------ ROUTE GET -----
    case 'GET':
        try {
            if ($searchby == "conv_id") {
                $request = "select message.id, message.texte, user.username, message.date
                    from message 
                    inner join participant on message.participant_id = participant.participant_id
                    inner join user on participant.user_id = user.user_id
                    where participant.conversation_id = :conversation_id;";
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':conversation_id', $conv_id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
            }else {
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
        

        break;
    // ------ FIN ROUTE POST -----
    // ------ ROUTE PUT -----
    case 'PUT':
        break;

    // ------ FIN ROUTE PUT -----
    // ------ ROUTE DELETE -----
    case 'DELETE':


        break;
    // ----- FIN ROUTE DELETE -----
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}