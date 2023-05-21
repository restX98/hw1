<?php
class DatabaseMgr {
    private $connection;

    public function __construct() {
        $configFilePath = 'config/db.ini';
        $config = parse_ini_file($configFilePath);

        $host = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $database = $config['database'];

        $this->connection = mysqli_connect($host, $username, $password, $database);
    }

    public function __destruct() {
        mysqli_close($this->connection);
    }

    public function createCustomer($firstName, $lastName, $email, $psw, $phoneNumber) {
        $firstName = mysqli_real_escape_string($this->connection, $firstName);
        $lastName = mysqli_real_escape_string($this->connection, $lastName);
        $email = mysqli_real_escape_string($this->connection, $email);
        $psw = mysqli_real_escape_string($this->connection, $psw);
        $psw = password_hash($psw, PASSWORD_BCRYPT);
        $phoneNumber = mysqli_real_escape_string($this->connection, $phoneNumber);

        $query = "CALL CreateCustomer('$firstName', '$lastName', '$email', '$psw', '$phoneNumber')";
        
        $result = mysqli_query($this->connection, $query);
        $customer = mysqli_fetch_object($result);
        
        mysqli_free_result($result);

        return $customer;
    }

    public function getCustomer($email) {
        $email = mysqli_real_escape_string($this->connection, $email);

        $query = "CALL GetCustomer('$email')";

        $result = mysqli_query($this->connection, $query);

        $customer = mysqli_fetch_object($result);
        
        mysqli_free_result($result);

        return $customer;
    }

    public function addAddressToCustomer($street, $houseNumber, $postalCode, $city, $province, $country, $customerID) {
        $street = mysqli_real_escape_string($this->connection, $street);
        $houseNumber = mysqli_real_escape_string($this->connection, $houseNumber);
        $postalCode = mysqli_real_escape_string($this->connection, $postalCode);
        $city = mysqli_real_escape_string($this->connection, $city);
        $province = mysqli_real_escape_string($this->connection, $province);
        $country = mysqli_real_escape_string($this->connection, $country);
        
        $query = "CALL AddAddressToCustomer('$street', '$houseNumber', '$postalCode', '$city', '$province', '$country', '$customerID')";

        $result = mysqli_query($this->connection, $query);
        $addressId = mysqli_fetch_row($result);

        mysqli_free_result($result);
        
        return $addressId[0];
    }

    public function getCustomerAddresses($customerID) {
        $query = "CALL GetCustomerAddresses('$customerID')";

        $result = mysqli_query($this->connection, $query);
        $addresses = Array();

        while ($row = mysqli_fetch_object($result)) {
            $addresses[] = $row;
        }

        mysqli_free_result($result);

        return $addresses;
    }

    public function createCategory($categoryName) {
        $query = "CALL CreateCategory('$categoryName')";

        $result = mysqli_query($this->connection, $query);
    }

    public function updateCategory($id, $categoryName) {
        $query = "CALL UpdateCategory('$id', '$categoryName')";

        $result = mysqli_query($this->connection, $query);
    }

    public function removeCategory($id) {
        $query = "CALL RemoveCategory('$id')";

        $result = mysqli_query($this->connection, $query);
    }

    public function createProduct($cod, $name, $price, $category) {
        $cod = mysqli_real_escape_string($this->connection, $cod);
        $name = mysqli_real_escape_string($this->connection, $name);
        $price = mysqli_real_escape_string($this->connection, $price);
        $category = mysqli_real_escape_string($this->connection, $category);

        $query = "CALL CreateProduct('$cod', '$name', '$price', '$category')";

        $result = mysqli_query($this->connection, $query);
    }

    public function updateProduct($id, $cod, $name, $price, $category) {
        $cod = mysqli_real_escape_string($this->connection, $cod);
        $name = mysqli_real_escape_string($this->connection, $name);
        $price = mysqli_real_escape_string($this->connection, $price);
        $category = mysqli_real_escape_string($this->connection, $category);

        $query = "CALL UpdateProduct('$id', '$cod', '$name', '$price', '$category')";

        $result = mysqli_query($this->connection, $query);
    }

    public function removeProduct($id) {
        $query = "CALL RemoveProduct('$id')";

        $result = mysqli_query($this->connection, $query);
    }
}

?>