<?php
abstract class Products{
  protected $id;
  protected $sku;
  protected $name;
  protected $price;
  protected $type;
  protected $size;
  protected $weight;
  protected $height;
  protected $width;
  protected $length;

  public function setId($id)
  {
    $this->id=$id; 
  }

  public function setName($productName)
  {
    $this->name=$productName;
  }
  public function setTSKU($sku)
  {
    $this->sku=$sku;
  }
  public function setPrice($price)
  {
    $this->price=$price;
  }
  public function setType($type)
  {
    $this->type=$type;
  }
  public function setSize($size)
  {
    $this->size=$size;
  }
  public function setWeight($weight)
  {
    $this->weight=$weight;
  }
  public function setHeight($height)
  {
    $this->height=$height;
  }
  public function setWidth($width)
  {
    $this->width=$width;
  }
  public function setLength($length)
  {
    $this->length=$length;
  }
} 
?>