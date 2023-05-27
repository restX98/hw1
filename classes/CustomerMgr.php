<?php
require_once 'DatabaseMgr.php';
require_once 'Customer.php';
require_once 'Session.php';
require_once 'Exceptions.php';

class CustomerMgr {
    public static function createCustomer($firstName, $lastName, $email, $psw, $phoneNumber) {
        $databaseManager = new DatabaseMgr();

        $customerRow = $databaseManager->createCustomer($firstName, $lastName, $email, $psw, $phoneNumber);
        
        if (isset($customerRow['error']) && $customerRow['error'] === true) {
            if ($customerRow['customerExists'] === true) {
                throw new CustomerExistsException("Questa mail è già registrata.");
            } else {
                throw new Exception("Database error.");
            }
        }
        
        Session::set("sessionId", $customerRow['ID']);
        return new Customer(
            $customerRow['ID'],
            $customerRow['firstName'],
            $customerRow['lastName'],
            $customerRow['email'],
            $customerRow['phoneNumber']
        );
    }

    public static function authenticateCustomer($email, $psw) {
        $databaseManager = new DatabaseMgr();

        $customerRow = $databaseManager->getCustomerByLogin($email);
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

    public static function logoutCustomer() {
        $id = Session::get("sessionId");
        if(isset($id)) {
            Session::delete("sessionId");
        }
    }

    public static function getCurrentCustomer() {
        $databaseManager = new DatabaseMgr();
        $id = Session::get("sessionId");
        if(isset($id)) {
            $customerRow = $databaseManager->getCustomerByID($id);

            if(is_null($customerRow)) {
                Session::delete("sessionId");
                return null;
            }

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