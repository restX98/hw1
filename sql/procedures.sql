USE hw1;

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

DELIMITER //
CREATE PROCEDURE AddAddressToCustomer(
  IN street VARCHAR(255),
  IN houseNumber VARCHAR(10),
  IN postalCode VARCHAR(10),
  IN city VARCHAR(255),
  IN province VARCHAR(255),
  IN country VARCHAR(255),
  IN customerID INT
)
BEGIN
  INSERT INTO Addresses (street, houseNumber, postalCode, city, province, country, customer)
  VALUES (street, houseNumber, postalCode, city, province, country, customerID);

  SELECT LAST_INSERT_ID() AS ID;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GetCustomerAddresses(
  IN customerID INT
)
BEGIN
  SELECT * FROM Addresses WHERE customer = customerID;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE CreateCategory(
  IN p_name VARCHAR(255)
)
BEGIN
  INSERT INTO Categories (name)
  VALUES (p_name);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE UpdateCategory(
  IN p_categoryId INT,
  IN p_newName VARCHAR(255)
)
BEGIN
  UPDATE Categories SET name = p_newName WHERE id = p_categoryId;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE RemoveCategory(
  IN p_categoryId INT
)
BEGIN
  DELETE FROM Categories WHERE id = p_categoryId;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE CreateProduct(
  IN p_cod VARCHAR(50),
  IN p_name VARCHAR(255),
  IN p_price DECIMAL(10,2),
  IN p_category INT
)
BEGIN
  INSERT INTO Products (cod, name, price, category)
  VALUES (p_cod, p_name, p_price, p_category);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE RemoveProduct(
  IN p_product_id INT
)
BEGIN
  DELETE FROM Products WHERE id = p_product_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE UpdateProduct(
  IN p_product_id INT,
  IN p_cod VARCHAR(50),
  IN p_name VARCHAR(255),
  IN p_price DECIMAL(10,2),
  IN p_category INT
)
BEGIN
  UPDATE Products
  SET cod = p_cod, name = p_name, price = p_price, category = p_category
  WHERE id = p_product_id;
END //
DELIMITER ;