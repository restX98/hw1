<?php

class Customer {
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $psw;
    private $phoneNumber;

    public function __construct($id, $firstName, $lastName, $email, $phoneNumber) {
      $this->id = $id;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->email = $email;
      $this->phoneNumber = $phoneNumber;
    }
}
?>
