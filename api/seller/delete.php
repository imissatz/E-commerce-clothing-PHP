<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin; Content-Type, Accept");

include_once "../../models/product.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['name'])) {
        $product->id = $_POST['name'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Product ID is required'));
        die();
    }

    if ($product->delete()) {
        echo json_encode(['success' => 1, 'message' => 'Product deleted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => 0, 'message' => 'Failed to delete product']);
    }
} else {
    echo json_encode(array('success' => 0, 'message' => 'Invalid request method'));         

}