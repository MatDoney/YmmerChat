<?php

/* 
 * 
 */

include '../Outil.php';
$pdo = PdoInit();
$requestMethod = $_SERVER['REQUEST_METHOD'];

$id= $_POST["id"];
$name= $_POST["name"];
$author = $_POST["author"];
$created_at = $_POST["created_AT"];
$searchby = $_POST["searchby"];

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