<?php
require_once '../classes/BasketMgr.php';
require_once '../classes/CustomerMgr.php';
require_once '../classes/OrderMgr.php';
require_once '../classes/Exceptions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    throw new Exception();
}

$data = json_decode(file_get_contents('php://input'), true);

$invalidFields = [];

if (isset($data['street']) && empty($data['street'])) {
    $invalidFields['street'] = "Inserisci la via";
} else {
  $street = $data['street'];
}

if (isset($data['houseNumber'])) {
    $houseNumber = $data['houseNumber'];
    if (empty($houseNumber)) {
        $invalidFields['houseNumber'] = "Inserisci il numero civico";
    } elseif (strlen($houseNumber) > 10) {
        $invalidFields['houseNumber'] = "Massimo 10 caratteri";
    }
}

if (isset($data['postalCode'])) {
    $postalCode = $data['postalCode'];
    if (empty($postalCode)) {
        $invalidFields['postalCode'] = "Inserisci il codice postale";
    } elseif (strlen($postalCode) > 10) {
        $invalidFields['postalCode'] = "Massimo 10 caratteri";
    }
}

if (isset($data['city']) && empty($data['city'])) {
    $invalidFields['city'] = "Inserisci la città";
} else {
  $city = $data['city'];
}

if (isset($data['province']) && empty($data['province'])) {
    $invalidFields['province'] = "Inserisci la provincia";
} else {
  $province = $data['province'];
}

if (isset($data['country']) && empty($data['country'])) {
    $invalidFields['country'] = "Inserisci il paese";
} else {
  $country = $data['country'];
}

try{
    $customer = CustomerMgr::getCurrentCustomer();
    if(is_null($customer)) {
        throw new CustomerNotAuthenticatedException();
    }

    $address = $customer->addAddress($street, $houseNumber, $postalCode, $city, $province, $country);

    $basket = BasketMgr::getCurrentBasket();

    $order = OrderMgr::placeOrder($basket, $address);

    $response = array('success' => true, 'orderNo' => $order->id);
} catch(Exception $ex) {
    $response = array('success' => false);
}


header('Content-Type: application/json');
echo json_encode($response);
