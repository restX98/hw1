<?php
require_once '../classes/BasketMgr.php';
require_once '../classes/Session.php';
require_once '../classes/Exceptions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    throw new Exception();
}

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['cod']) && empty($data['cod'])) {
    throw new Exception();
} else {
    $product = $data['cod'];
}

$currentBasket = BasketMgr::getCurrentBasket();

$currentBasket->addProduct($product);

$response = array('success' => true, 'totalQuantity' => $currentBasket->totalQuantity);

header('Content-Type: application/json');
echo json_encode($response);