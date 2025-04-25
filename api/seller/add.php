<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin; Content-Type, Accept"); // Handle pre-flight request

include_once "../../models/product.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($product->validate_params($_POST['name'])){
        $product->name = $_POST['name'];
    }else{
        echo json_encode(array('success'=>0, 'message'=>'Name is required'));
        die();
    }

    $product_images_folder = "../../assets/product_images/";

    if(!is_dir($product_images_folder)){
        mkdir($product_images_folder, 0777, true);
    }

    if(isset($_FILES['image'])){

        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $parts = explode('.', $file_name);
        $extension = end($parts);

        $new_file_name = "product_" . $product->name . "." . $extension;

        move_uploaded_file($file_tmp, $product_images_folder . "/" . $new_file_name);

        $product->image = 'product_images/' . $new_file_name;
        
    }else{
        echo json_encode(array('success'=>0, 'message'=>'Failed to upload image'));
        die();
    }


    if($product->validate_params($_POST['price'])){
        $product->price = $_POST['price'];
    }else{
        echo json_encode(array('success'=>0, 'message'=>'Price is required'));
        die();
    }

    if($product->validate_params($_POST['description'])){
        $product->description = $_POST['description'];
    }else{
        echo json_encode(array('success'=>0, 'message'=>'Description is required'));
        die();
    }

    if($product->add_product()){
        echo json_encode(['success'=>1, 'message'=>'Product added successfully']);
    }else{
        http_response_code(500);
        echo json_encode(['success'=>0, 'message'=>'Internal Server Error']);
    }
}else{
    die(header("HTTP/1.0 405 Method Not Allowed"));
}

// UNDERSTAND THIS CODE 

// if($_SERVER['REQUEST_METHOD'] === 'POST'){
//     $data = json_decode(file_get_contents("php://input"));

//     $product = new Product();
//     $product->name = $data->name;
//     $product->image = $data->image;
//     $product->price = $data->price;
//     $product->description = $data->description;

//     if($product->validate_params($data)){
//         if($product->add_product()){
//             echo json_encode(array("message" => "Product added successfully"));
//         }else{
//             echo json_encode(array("message" => "Failed to add product"));
//         }
//     }else{
//         echo json_encode(array("message" => "Invalid parameters"));
//     }

// }