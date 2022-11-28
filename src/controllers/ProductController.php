<?php
namespace MyApp\Controllers;
use Exception;
use MyApp\Traits\Response;
use MyApp\Models\ProductModel;

class ProductController
{
    protected $connection;
    use Response;

    public function listProducts()
    {
        try {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            if (!(strtoupper($requestMethod) == "GET")) {
                return $this->errorResponse(
                    [
                        "status" => false,
                        "error" => "Method not allowed",
                        "code" => 401,
                    ],
                    ["Content-Type: application/json", 
                    "HTTP/1.1 401 OK"],
                    401
                );
            }
            $productModel = new ProductModel();
            $arrProducts = $productModel->getProducts();
            $this->successResponse(
                [
                    "status" => true,
                    "data" => $arrProducts,
                    "code" => 200,
                ],
                200,
                ["Content-Type: application/json", "HTTP/1.1 200 OK","Access-Control-Allow-Origin: *"]
            );
        } catch (Exception $e) {
            $strErrorDesc = $e->getMessage() . "Something went wrong!";
            $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
            $this->sendOutput(
                json_encode(["error" => $strErrorDesc]),
                500,
                ["Content-Type: application/json", $strErrorHeader]
            );
        }
    }

    public function addProduct()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (!(strtoupper($requestMethod) == "POST")) {
            return $this->errorResponse(
                [
                    "status" => false,
                    "error" => "Method not allowed",
                    "code" => 401,
                ],
                401,
                ["Content-Type: application/json", "HTTP/1.1 401 OK","Access-Control-Allow-Origin: *"]
            );
        }
        $json = file_get_contents("php://input");
        $data = json_decode($json);
        $requestKeys = array_keys((array) $data);
        $required = ["sku", "name", "price", "type"];
        $optionalKeys = [
            "size",
            "weight",
            "height",
            "width",
            "length",
            "price",
        ];
        foreach ($required as $key) {
            if (!in_array($key, $requestKeys) || empty($data->$key)) {
                $data = [
                    "error" => $key . " field is required",
                    "status" => "false",
                    "code" => "400",
                ];
                return $this->errorResponse(
                    $data,
                    400,
                    ["Content-Type: application/json","Access-Control-Allow-Origin: *"]
                );
            }
        }
        foreach ($optionalKeys as $key) {
            if (in_array($key, $requestKeys)) {
                if (!is_numeric($data->$key) || $data->$key <= 0) {
                    $data = [
                        "status" => false,
                        "code" => "400",
                        "error" =>
                            $key .
                            " field should be a number greater than zero",
                    ];
                    return $this->errorResponse(
                        $data,
                        400,
                        ["Content-Type: application/json","Access-Control-Allow-Origin: *"]
                    );
                }
            } else {
                $data->$key = "";
            }
        }

        $newProduct = new ProductModel();
        $newProduct->setId(uniqid());
        $newProduct->setName($data->name);
        $newProduct->setTSKU($data->sku);
        $newProduct->setPrice($data->price);
        $newProduct->setType($data->type);
        $newProduct->setSize($data->size);
        $newProduct->setWeight($data->weight);
        $newProduct->setHeight($data->height);
        $newProduct->setWidth($data->width);
        $newProduct->setLength($data->length);
        $newProduct->saveProduct();
        $output = [
            "status" => true,
            "message" => "Product saved!",
            "code" => 201,
        ];
        $this->successResponse(
            $output,
            201,
            ["Content-Type: application/json", "HTTP/1.1 201 OK","Access-Control-Allow-Origin: *"],
        );
    }

    public function removeProducts()
    {
        $json = file_get_contents("php://input");
        $data = json_decode($json);
        $objectKeys = array_keys((array) $data);
        $newProduct = new ProductModel();
        $newProduct->removeMuliple($objectKeys);
        $response = ["message" => "Product removed!"];
        $this->sendOutput(
            json_encode($response),
            200,
            ["Content-Type: application/json", "HTTP/1.1 201 OK","Access-Control-Allow-Origin: *"],
        );
    }
}
?>
