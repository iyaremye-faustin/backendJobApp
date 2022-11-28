<?php
require_once realpath("config/bootstrap.php");
use MyApp\Routes\Router;
use MyApp\Controllers\ProductController;

$routes = new Router();

$routes->add("/api/getProducts", function () {
    $product = new ProductController();
    $product->listProducts();
});

$routes->add("/api/addProduct", function () {
    $product = new ProductController();
    $product->addProduct();
});
$routes->run();
?>
