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
CREATE PROCEDURE GetCustomerByLogin(
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
CREATE PROCEDURE GetCustomerByID(
  IN ID INT
)
BEGIN
  DECLARE existingID INT;

  SELECT COUNT(*) INTO existingID FROM Customers C WHERE C.ID = ID;

  IF existingID = 0 THEN
    SIGNAL SQLSTATE '45003' SET MESSAGE_TEXT = 'Customer doesn''t exist';
  ELSE
    SELECT * FROM Customers C WHERE C.ID = ID;
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
CREATE PROCEDURE GetCategories()
BEGIN
  SELECT * FROM Categories;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE CreateCategory(
  IN p_name VARCHAR(255),
  IN p_cod VARCHAR(255)
)
BEGIN
  INSERT INTO Categories (name, cod)
  VALUES (p_name, p_cod);
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

DELIMITER //
CREATE PROCEDURE GetProduct(
  IN p_productCode VARCHAR(50)
)
BEGIN
  SELECT Products.*, Categories.name AS categoryName, Categories.cod AS categoryCod
  FROM Products
  INNER JOIN Categories ON Products.category = Categories.id
  WHERE Products.cod = p_productCode;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GetProductsByCategory(
  IN categoryCod VARCHAR(255)
)
BEGIN
  IF categoryCod IS NULL THEN
    SELECT Products.*, Categories.name AS categoryName, Categories.cod AS categoryCod
    FROM Products INNER JOIN Categories ON Products.category = Categories.id;
  ELSE
    SELECT Products.*, Categories.name AS categoryName, Categories.cod AS categoryCod
    FROM Products INNER JOIN Categories ON Products.category = Categories.id
    WHERE category = (SELECT id FROM Categories WHERE cod = categoryCod);
  END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE CreateCartItemsContainer(
  IN customerId INT
)
BEGIN
  DECLARE customerCount INT;
  
  SELECT COUNT(*) INTO customerCount
  FROM Customers
  WHERE ID = customerId;
  
  IF customerCount = 0 THEN
    SIGNAL SQLSTATE '45005' SET MESSAGE_TEXT = 'Customer does not exist';
  ELSE
    SELECT *
    FROM ItemsContainers
    WHERE customer = customerId AND status = 'cart'
    INTO @containerId, @customerId, @status, @address;
    
    IF @containerId IS NULL THEN
      INSERT INTO ItemsContainers (customer, status)
      VALUES (customerId, 'cart');
      
      SELECT LAST_INSERT_ID() AS containerId, customerId;
    ELSE
      SELECT @containerId AS containerId, @customerId AS customerId, @status AS status, @address as addressId;
    END IF;
  END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE AddProductToCart(
  IN containerId INT,
  IN productCod VARCHAR(50)
)
BEGIN
  DECLARE containerStatus ENUM('cart', 'created', 'shipped');
  DECLARE lineItemCount INT;
  DECLARE productId INT;
  
  SELECT status INTO containerStatus
  FROM ItemsContainers
  WHERE ID = containerId;

  IF containerStatus <> 'cart' THEN
    SIGNAL SQLSTATE '45006' SET MESSAGE_TEXT = 'This ItemsContainer is locked';
  ELSE
    SELECT id INTO productId
    FROM Products
    WHERE cod = productCod;
    
    IF productId IS NOT NULL THEN
      SELECT COUNT(*) INTO lineItemCount
      FROM Items
      WHERE product = productId AND container = containerId;
      
      IF lineItemCount > 0 THEN
        UPDATE Items
        SET quantity = quantity + 1
        WHERE product = productId AND container = containerId;
      ELSE
        INSERT INTO Items (product, quantity, container)
        VALUES (productId, 1, containerId);
      END IF;
    ELSE
      SIGNAL SQLSTATE '45007' SET MESSAGE_TEXT = 'Product does not exist';
    END IF;
  END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE RemoveProductFromCart(
  IN containerId INT,
  IN productCod VARCHAR(50)
)
BEGIN
  DECLARE containerStatus ENUM('cart', 'created', 'shipped');
  DECLARE lineItemCount INT;
  DECLARE productId INT;

  SELECT status INTO containerStatus
  FROM ItemsContainers
  WHERE ID = containerId;

  IF containerStatus <> 'cart' THEN
    SIGNAL SQLSTATE '45006' SET MESSAGE_TEXT = 'This ItemsContainer is locked';
  ELSE
    SELECT id INTO productId
    FROM Products
    WHERE cod = productCod;

    IF productId IS NOT NULL THEN
      SELECT COUNT(*) INTO lineItemCount
      FROM Items
      WHERE product = productId AND container = containerId;

      IF lineItemCount > 0 THEN
        DELETE FROM Items
        WHERE product = productId AND container = containerId;
      ELSE
        SIGNAL SQLSTATE '45008' SET MESSAGE_TEXT = 'Product does not exist in the cart';
      END IF;
    ELSE
      SIGNAL SQLSTATE '45007' SET MESSAGE_TEXT = 'Product does not exist';
    END IF;
  END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GetItemsContainer(
  IN containerId INT
)
BEGIN
  SELECT i.ID AS lineItemId, p.name AS productName, p.price AS productPrice, p.cod AS productCode, c.id AS categoryId, c.name AS categoryName, c.cod AS categoryCode, i.quantity
  FROM Items i
  INNER JOIN Products p ON i.product = p.ID
  INNER JOIN Categories c ON p.category = c.id
  WHERE i.container = containerId;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE PlaceOrder(
  IN containerId INT,
  IN addressId INT
)
BEGIN
  DECLARE itemCount INT;
  DECLARE containerStatus ENUM('cart', 'created', 'shipped');
  
  SELECT COUNT(*) INTO itemCount
  FROM ItemsContainers
  WHERE ID = containerId;
  
  IF itemCount = 0 THEN
    SIGNAL SQLSTATE '45008' SET MESSAGE_TEXT = 'ItemsContainer does not exist';
  ELSE
    SELECT status INTO containerStatus
    FROM ItemsContainers
    WHERE ID = containerId;
    
    IF containerStatus <> 'cart' THEN
      SIGNAL SQLSTATE '45009' SET MESSAGE_TEXT = 'ItemsContainer is not in cart state';
    ELSE
      SELECT COUNT(*) INTO itemCount
      FROM Addresses
      WHERE ID = addressId;
      
      IF itemCount = 0 THEN
        SIGNAL SQLSTATE '45010' SET MESSAGE_TEXT = 'Address does not exist';
      ELSE
        UPDATE ItemsContainers
        SET status = 'created', address = addressId
        WHERE ID = containerId;
        
        SELECT *
        FROM ItemsContainers
        WHERE ID = containerId;
      END IF;
    END IF;
  END IF;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE AddProductToWishlist(
  IN p_customerId INT,
  IN p_productId INT
)
BEGIN
  DECLARE v_wishlistId INT;
  
  SELECT ID INTO v_wishlistId
  FROM Wishlists
  WHERE customer = p_customerId;
  
  IF v_wishlistId IS NULL THEN
    INSERT INTO Wishlists (customer) VALUES (p_customerId);
    SET v_wishlistId = LAST_INSERT_ID();
  END IF;
  
  IF EXISTS (
    SELECT *
    FROM WishlistProduct
    WHERE wishlist = v_wishlistId AND product = p_productId
  ) THEN
    SIGNAL SQLSTATE '45004' SET MESSAGE_TEXT = 'Product already exists in wishlist.';
  ELSE
    INSERT INTO WishlistProduct (wishlist, product)
    VALUES (v_wishlistId, p_productId);
  END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GetWishlistProducts(
  IN customerID INT
)
BEGIN
  SELECT Products.*, Categories.name AS categoryName, Categories.cod AS categoryCod
  FROM Products
  INNER JOIN WishlistProduct ON Products.id = WishlistProduct.product
  INNER JOIN Categories ON Products.category = Categories.id
  INNER JOIN Wishlists ON WishlistProduct.wishlist = Wishlists.ID
  WHERE Wishlists.customer = customerID;
END //
DELIMITER ;

