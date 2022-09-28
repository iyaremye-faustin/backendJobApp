<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require __DIR__ . "/config/bootstrap.php"; 

require PROJECT_ROOT_PATH . "/Controller/ProductController.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];
$productObject = new ProductController();
if(strtoupper($requestMethod) == 'POST'){
    $productObject->addProduct();
}

if(strtoupper($requestMethod) == 'GET'){
    $productObject->listProducts();
}

header("HTTP/1.1 404 Not Found");
exit();
?>