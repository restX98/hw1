<?php
require_once 'DatabaseMgr.php';
require_once 'Customer.php';
require_once 'Session.php';
require_once 'Exceptions.php';

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
        $customerRow = $this->databaseManager->getCustomerByLogin($email);

        if (isset($customerRow['error']) && $customerRow['error'] === true) {
            if ($customerRow['mailError'] === true) {
                throw new InvalidEmailException("Email non valida.");
            } else {
                throw new Exception("Database error.");
            }
        }

        if(password_verify($psw, $customerRow['psw'])){
            Session::set("sessionId", $customerRow['ID']);
            return new Customer(
                $customerRow['ID'],
                $customerRow['firstName'],
                $customerRow['lastName'],
                $customerRow['email'],
                $customerRow['phoneNumber']
            );
        } else {
            throw new InvalidPasswordException("Password non valida.");
        }
    }

    public function getCurrentCustomer() {
        $id = Session::get("sessionId");
        if(isset($id)) {
            $customerRow = $this->databaseManager->getCustomerByID($id);
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