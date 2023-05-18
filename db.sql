CREATE DATABASE hw1;
USE hw1;

CREATE TABLE Categories (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL UNIQUE
)Engine="InnoDB";

CREATE TABLE Products (
  id INT PRIMARY KEY AUTO_INCREMENT,
  cod VARCHAR(50) UNIQUE,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  category INT NOT NULL,

  INDEX idx_category(category),

  FOREIGN KEY (category) REFERENCES Categories(ID)
)Engine="InnoDB";

CREATE TABLE Customers (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  firstName VARCHAR(50) NOT NULL,
  lastName VARCHAR(50) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  psw VARCHAR(255) NOT NULL,
  phoneNumber VARCHAR(20) UNIQUE NOT NULL
)Engine="InnoDB";

CREATE TABLE ItemsContainers (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  customer INT NOT NULL,
  creationDate DATETIME NOT NULL,
  status ENUM('cart', 'created', 'shipped') NOT NULL DEFAULT 'cart',

  INDEX idx_customer(customer),

  FOREIGN KEY (customer) REFERENCES Customers(ID)
)Engine="InnoDB";

CREATE TABLE Items (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  product INT NOT NULL,
  quantity INT NOT NULL,
  container INT NOT NULL,

  INDEX idx_product(product),
  INDEX idx_container(container),

  FOREIGN KEY (product) REFERENCES Products(ID),
  FOREIGN KEY (container) REFERENCES ItemsContainers(ID)
)Engine="InnoDB";

CREATE TABLE Addresses (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  street VARCHAR(255) NOT NULL,
  houseNumber VARCHAR(10) NOT NULL,
  postalCode VARCHAR(10) NOT NULL,
  city VARCHAR(255) NOT NULL,
  province VARCHAR(255) NOT NULL,
  country VARCHAR(255) NOT NULL,
  customer INT NOT NULL,

  INDEX idx_customer(customer),
  
  FOREIGN KEY (customer) REFERENCES Customers(ID)
)Engine="InnoDB";

CREATE TABLE Wishlists (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  customer INT NOT NULL,

  INDEX idx_customer(customer),

  FOREIGN KEY (customer) REFERENCES Customers(ID)
)Engine="InnoDB";

CREATE TABLE WishlistProduct (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  wishlist INT NOT NULL,
  product INT NOT NULL,

  INDEX idx_wishlist(wishlist),
  INDEX idx_product(product),

  FOREIGN KEY (wishlist) REFERENCES Wishlists(ID),
  FOREIGN KEY (product) REFERENCES Products(ID)
)Engine="InnoDB";

DELIMITER //
CREATE PROCEDURE CreateCustomer(
    IN firstName VARCHAR(50),
    IN lastName VARCHAR(50),
    IN email VARCHAR(100),
    IN psw VARCHAR(255),
    IN phoneNumber VARCHAR(20)
)
BEGIN
  DECLARE existingEmail INT;
  DECLARE existingPhone INT;
  
  SELECT COUNT(*) INTO existingEmail FROM Customers C WHERE C.email = email;
  SELECT COUNT(*) INTO existingPhone FROM Customers C WHERE C.phoneNumber = phoneNumber;
  
  IF existingEmail > 0 THEN
    SIGNAL SQLSTATE '45001'
      SET MESSAGE_TEXT = 'Email exists';
  END IF;

  IF existingPhone > 0 THEN
    SIGNAL SQLSTATE '45002'
      SET MESSAGE_TEXT = 'Phone Number exists';
  END IF;
  
  INSERT INTO Customers (firstName, lastName, email, psw, phoneNumber)
  VALUES (firstName, lastName, email, psw, phoneNumber);
  
  SELECT * FROM Customers C WHERE C.ID = LAST_INSERT_ID();
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE GetCustomer(
  IN email VARCHAR(100)
)
BEGIN
  DECLARE existingEmail INT;

  SELECT COUNT(*) INTO existingEmail FROM Customers C WHERE C.email = email;

  IF existingEmail = 0 THEN
    SIGNAL SQLSTATE '45003' SET MESSAGE_TEXT = 'Customer doesn''t exist';
  ELSE
    SELECT * FROM Customers C WHERE C.email = email;
  END IF;
END //
DELIMITER ;
