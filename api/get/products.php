<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin; Content-Type, Accept'); //Handle pre-flight request

include_once '../../models/product.php';

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    try{
        echo json_encode(['success'=>1, 'products'=>$product->get_products()]);
    }
    catch(Exception $e){
        echo json_encode(['success'=>0, 'message'=>$e->getMessage()]);
    }
}
    