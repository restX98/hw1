<?php

require_once 'DatabaseMgr.php';

class Address {
    public $id;
    public $street;
    public $houseNumber;
    public $postalCode;
    public $city;
    public $province;
    public $country;

    public function __construct($id, $street, $houseNumber, $postalCode, $city, $province, $country) {
        $this->id = $id;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->province = $province;
        $this->country = $country;
    }
}
?>
