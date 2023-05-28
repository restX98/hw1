<?php
require_once '../classes/CustomerMgr.php';
require_once '../classes/Session.php';
require_once '../classes/Exceptions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    throw new Exception();
}

$data = json_decode(file_get_contents('php://input'), true);

$invalidFields = [];

if (isset($data['firstName']) && empty($data['firstName'])) {
    $invalidFields['firstName'] = "Inserisci il tuo nome";
} else {
    $firstName = $data['firstName'];
}

if (isset($data['lastName']) && empty($data['lastName'])) {
    $invalidFields['lastName'] = "Inserisci il tuo cognome";
} else {
    $lastName = $data['lastName'];
}

if(isset($data['email']) && empty($data['email'])) {
    $invalidFields['email'] = "Inserisci un indirizzo email";
} else if (isset($data['email']) && !preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,}$/',$data['email'])) {
    $invalidFields['email'] = "Inserisci un indirizzo email valido";
} else {
    $email = $data['email'];
}

if (isset($data['phone']) && empty($data['phone'])) {
    $invalidFields['phone'] = "Inserisci il tuo numero di telefono";
} else {
    $phone = $data['phone'];
}

if (isset($data['password']) && empty($data['password'])) {
    $invalidFields['password'] = "Inserisci una password";
} else {
    $password = $data['password'];
}

if (isset($data['confirmPassword']) && empty($data['confirmPassword'])) {
    $invalidFields['confirmPassword'] = "Inserisci la password di conferma";
} else if($data['password'] !== $data['confirmPassword']) {
    $invalidFields['confirmPassword'] = "Le password non corrispondono";
}

if (!empty($invalidFields)) {
    $response = array('success' => false, 'errorFields' => $invalidFields);
} else {
    try{
        $customerMgr = new CustomerMgr();
        $customer = $customerMgr::createCustomer(
            $firstName,
            $lastName,
            $email,
            $password,
            $phone
        );
        $response = array('success' => true);
    } catch(EmailExistsException $ex) {
        $response = array('success' => false, 'emailExists' => true);
    } catch(PhoneExistsException $ex) {
        $response = array('success' => false, 'phoneExists' => true);
    }
}

header('Content-Type: application/json');
echo json_encode($response);
