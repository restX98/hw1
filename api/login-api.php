<?php
require_once '../classes/CustomerMgr.php';
require_once '../classes/Session.php';
require_once '../classes/Exceptions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    throw new Exception();
}

$data = json_decode(file_get_contents('php://input'), true);

$invalidFields = [];

if(isset($data['email']) && empty($data['email'])) {
    $invalidFields['email'] = "Inserisci un indirizzo email";
} else if (isset($data['email']) && !preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,}$/',$data['email'])) {
    $invalidFields['email'] = "Inserisci un indirizzo email valido";
} else {
    $email = $data['email'];
}

if (isset($data['password']) && empty($data['password'])) {
    $invalidFields['password'] = "Inserisci una password";
} else {
    $password = $data['password'];
}

if (!empty($invalidFields)) {
    $response = array('success' => false, 'errorFields' => $invalidFields);
} else {
    try{
        $customerMgr = new CustomerMgr();
        $customer = $customerMgr::authenticateCustomer($email, $password);
        if ($customer) {
            $response = array('success' => true);
        }
    } catch(InvalidEmailException $ex) {
        $response = array('success' => false, 'mailError' => true);
    } catch(InvalidPasswordException $ex) {
        $response = array('success' => false, 'passwordError' => true);
    }
}

header('Content-Type: application/json');
echo json_encode($response);
