<?php

/*
 * 
 */

include '../Outil.php';
$pdo = PdoInit();
$requestMethod = $_SERVER['REQUEST_METHOD'];

if (isset($_POST["conv_id"])) {
    $conv_id = $_POST["conv_id"];
}
if (isset($_POST["name"])) {
    $name = $_POST["name"];
}
if (isset($_POST["author"])) {
    $author = $_POST["author"];
}
if (isset($_POST["created_at"])) {
    $created_at = $_POST["created_at"];
}
if (isset($_POST["searchby"])) {
    $searchby = $_POST["searchby"];
}



switch ($requestMethod) {
    // ------ ROUTE GET -----
    case 'GET':


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