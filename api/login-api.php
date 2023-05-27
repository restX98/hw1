<?php
require_once '../classes/CustomerMgr.php';
require_once '../classes/Session.php';
require_once '../classes/Exceptions.php';


$data = $data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = $data['password'];

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

header('Content-Type: application/json');
echo json_encode($response);
