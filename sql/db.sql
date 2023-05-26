CREATE DATABASE hw1;
USE hw1;

CREATE TABLE Categories (
  id INT PRIMARY KEY AUTO_INCREMENT,
  cod VARCHAR(255) NOT NULL UNIQUE,
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
