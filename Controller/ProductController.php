<?php 
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
class ProductController  extends ResponseController{
  protected $connection;
  public function __construct()
  {
    $this->connection=new Database(); 
  }

  public function listProducts()
  {
    try {
      $productModel = new ProductModel();
      //$arrProducts = $productModel->getProducts();
      $arrProducts = array(
        (object) [
          "productId"=>2,
          "productName"=>'Product-1',
          "productCode"=>'PT10',
          "releaseDate"=>'March 18 2021',
          "description"=>'testing product',
          "price"=>23,
          "starRating"=>4.2,
          "imageUrl"=>'assets/images/h.png'
        ],
        (object) [
          "productId"=>3,
          "productName"=>'Product-12',
          "productCode"=>'PT101',
          "releaseDate"=>'March 18 2021',
          "description"=>'testing product',
          "price"=>24,
          "starRating"=>12,
          "imageUrl"=>'assets/images/h.png'
         ],
         (object) [
          "productId"=>4,
          "productName"=>'Product-13',
          "productCode"=>'PT101',
          "releaseDate" =>'March 18 2021',
          "description"=>'testing product',
          "price"=>25,
          "starRating"=>8,
          "imageUrl"=>'assets/images/h.png'
         ]
      );
      $this->sendOutput(json_encode(['data'=>$arrProducts]),array('Content-Type: application/json' ,'HTTP/1.1 200 OK'),200);
    } catch (Exception $e) {
      $strErrorDesc = $e->getMessage().'Something went wrong!';
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
      $this->sendOutput(json_encode(array('error' => $strErrorDesc)),array('Content-Type: application/json', $strErrorHeader),500);
    }
  }

  public function addProduct()
  { 
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $requestKeys = array_keys((array)$data);
    $required=["sku","name","price","type"];
    $optionalKeys=["size","weight","height","width","length","price"];
    foreach($required as $key){
      if(!in_array($key,$requestKeys) || empty($data->$key)){
        $data=["error"=>$key." field is required"];
        return $this->sendOutput(json_encode($data),array('Content-Type: application/json' ,'HTTP/1.1 400 OK'),400);
      }
    }
    foreach($optionalKeys as $key){
      if(in_array($key,$requestKeys)){
        if(!is_numeric($data->$key) || $data->$key<=0){
          $data=["error"=>$key." field should be a number greater than zero"];
          return $this->sendOutput(json_encode($data),array('Content-Type: application/json' ,'HTTP/1.1 400 OK'),400);
        }
      }else{
        $data->$key='';
      }
    }
    
    $newProduct= new ProductModel();
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
    $output=["message"=>"Product saved!"];
    $this->sendOutput(json_encode($output),array('Content-Type: application/json' ,'HTTP/1.1 201 OK'),201);
  }
  public function removeProducts()
  {
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $objectKeys = array_keys((array)$data);
    $newProduct= new ProductModel();
    $newProduct->removeMuliple($objectKeys);
    $response=["message"=>"Product removed!"];
    $this->sendOutput(json_encode($response),array('Content-Type: application/json' ,'HTTP/1.1 201 OK'),200);
  }
}
?>