<?php
namespace MyApp\Models;
use Exception;
use MyApp\Abstract\Products;
use MyApp\Database\Database;

class ProductModel extends Products
{
    protected $db;
    protected $fieldList = [];
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProducts()
    {
        return $this->db->select("SELECT * FROM products");
    }

    public function saveProduct()
    {
        $this->fieldList["id"] = $this->id;
        $this->fieldList["sku"] = $this->sku;
        $this->fieldList["name"] = $this->name;
        $this->fieldList["price"] = $this->price;
        $this->fieldList["type"] = $this->type;
        $this->fieldList["size"] = $this->size;
        $this->fieldList["weight"] = $this->weight;
        $this->fieldList["height"] = $this->height;
        $this->fieldList["width"] = $this->width;
        $this->fieldList["length"] = $this->length;
        $this->db->insert($this->fieldList, "products");
    }
    public function removeMuliple($keys)
    {
        try {
            foreach ($keys as $item) {
                $where = null;
                $where .= "id='$item'";
                $this->db->delete($where, "products");
            }
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>
