<?php
require_once 'DatabaseMgr.php';
require_once 'Customer.php';

class CustomerMgr {
    private $databaseManager;

    public function __construct() {
        $this->databaseManager = new DatabaseMgr();
    }

    public function createCustomer($firstName, $lastName, $email, $psw, $phoneNumber) {
        $newCustomer = $this->databaseManager->createCustomer($firstName, $lastName, $email, $psw, $phoneNumber);
        return new Customer(
            $newCustomer->ID,
            $newCustomer->firstName,
            $newCustomer->lastName,
            $newCustomer->email,
            $newCustomer->phoneNumber
        );
    }

    public function authenticateCustomer($email, $psw) {
        $customerRow = $this->databaseManager->getCustomer($email);
        if(password_verify($psw, $customerRow->psw)){
            $_SESSION["sessionId"] = $customerRow->ID;
            return new Customer(
                $customerRow->ID,
                $customerRow->firstName,
                $customerRow->lastName,
                $customerRow->email,
                $customerRow->phoneNumber
            );
        } else {
            return null;
        }
    }
}

?>