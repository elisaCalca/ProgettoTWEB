--AMAZING_SHOP_DATABASE

--MYSQL FOLDER:
Applications/XAMPP/xamppfiles/bin
./mysql -u root

--COMANDO PER GENERARE IL BACKUP DEL DATABASE su Windows:
mysqldump -u root -p amazingdb > C:\MySQLBackup\amazingdb_20220208.

--query per reimpostare la password
-- UPDATE Users SET Password = (SELECT Password FROM Users WHERE Email = 'elisa.calca95@gmail.com');

DROP DATABASE IF EXISTS amazingdb;

CREATE DATABASE amazingdb;
use amazingdb;

--ROLES table
CREATE TABLE Roles (
	ID varchar(36) NOT NULL,
	Name varchar(50) NOT NULL,
	PRIMARY KEY (ID),
	UNIQUE (Name)
);

INSERT INTO Roles (ID, Name) VALUES
(UUID(), 'Compratore'),
(UUID(), 'Compratore e venditore');

--USERS table
CREATE TABLE Users (
	ID varchar(36) NOT NULL,
	Name varchar(255) NOT NULL,
	Surname varchar(255) NOT NULL,
	Email varchar(255) NOT NULL,
	RoleID varchar(36),
	Password varchar(255) NOT NULL,
	PRIMARY KEY (ID),
	UNIQUE (Email),
	FOREIGN KEY (RoleID) REFERENCES Roles(ID) ON DELETE CASCADE
);

--IMAGES table
CREATE TABLE Images (
	ID varchar(36) NOT NULL,
	ImageData LONGTEXT NOT NULL,
	PRIMARY KEY (ID)
);
ALTER TABLE Images ADD COLUMN DateInsertion DATETIME NOT NULL;

--PRODUCTS table
CREATE TABLE Products (
	ID varchar(36) NOT NULL,
	Name varchar(255) NOT NULL,
	Description varchar(255) NOT NULL,
	Price decimal(6,2) NOT NULL,
	UserIDSeller varchar(36),
	ImageID varchar(36),
	PRIMARY KEY (ID),
	FOREIGN KEY (UserIDSeller) REFERENCES Users(ID) ON DELETE CASCADE,
	FOREIGN KEY (ImageID) REFERENCES Images(ID) ON DELETE SET NULL
);

--SHOPPING_BAGS table
CREATE TABLE Shopping_Bags (
	UserID varchar(36),
	ProductId varchar(36),
	Qty int NOT NULL,
	PRIMARY KEY (UserID, ProductId, Qty),
	FOREIGN KEY (UserID) REFERENCES Users(ID) ON DELETE CASCADE,
	FOREIGN KEY (ProductId) REFERENCES Products(ID) ON DELETE CASCADE
);

--TRIGGERS FOR UUID GENERATION
CREATE TRIGGER insert_userid 
BEFORE INSERT ON Users
FOR EACH ROW 
SET NEW.ID = UUID(); 

CREATE TRIGGER insert_productid
BEFORE INSERT ON Products
FOR EACH ROW 
SET NEW.ID = UUID(); 

CREATE TRIGGER insert_imageid
BEFORE INSERT ON Images
FOR EACH ROW 
SET NEW.ID = UUID(); 
