<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}database.php");

class Product{
    private $table;

    public $id;
    public $name;
    public $image;
    public $price;
    public $description;
    public $interaction_count;

    public function __construct(){
        $this -> table = 'products';
    }

    public function validate_params($params){
        return(!empty($params));
    }

    public function add_product(){
        global $database;

        $this->name = trim(htmlspecialchars(strip_tags($this->name)));
        $this->image = trim(htmlspecialchars(strip_tags($this->image)));
        $this->price = trim(htmlspecialchars(strip_tags($this->price)));
        $this->description = trim(htmlspecialchars(strip_tags($this->description)));

        $sql = "INSERT INTO $this->table (name, image, price, description) VALUES(
        '".$database->escape_value($this->name)."',
        '".$database->escape_value($this->image)."',
        '".$database->escape_value($this->price)."',
        '".$database->escape_value($this->description)."'
        ) ";

        $result = $database->query($sql);

        if($result)
            return true;
        else
            return false;
    }

    public function get_products(){
        global $database;

        $sql = "SELECT * FROM $this->table";
        $result = $database->query($sql);

        if($result)
            return $database->fetch_array($result);
        else
            return false;
    }

    public function delete() {
        global $database;
            
            $sql = "DELETE FROM $this->table WHERE id = '".$database->escape_value($this->id)."' LIMIT 1";
            $result = $database->query($sql);
    
            if($result)
                return true;
            else
                return false;



    }

}

$product = new Product();