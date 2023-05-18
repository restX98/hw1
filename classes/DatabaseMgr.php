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
}

?>