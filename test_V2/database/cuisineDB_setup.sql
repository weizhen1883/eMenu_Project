DROP DATABASE IF EXISTS cuisineDB_v2;
CREATE DATABASE IF NOT EXISTS cuisineDB_v2;
USE cuisineDB_v2;

CREATE TABLE IF NOT EXISTS systemSettings (
	user varchar(50) NOT NULL,
	systemLanguage varchar(5) NOT NULL
)CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS cuisineType (
	typeID TINYINT UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, 
	sortOrder TINYINT UNSIGNED NOT NULL,
	typeName_en varchar(25) NOT NULL,
	typeName_ch varchar(25) NOT NULL,
	PRIMARY KEY (typeID)
)CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS cuisineList (
	cuisineID INT UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
	cuisineName_en varchar(50) NOT NULL,
	cuisineName_ch varchar(50) NOT NULL,
	description_en varchar(50) NOT NULL,
	description_ch varchar(50) NOT NULL,
	cuisineImage varchar(50) NOT NULL,
	typeID TINYINT UNSIGNED ZEROFILL,
	dailySpecial BOOLEAN NOT NULL, 
	retailPrice DOUBLE(8,2) UNSIGNED NOT NULL,
	specialPrice DOUBLE(8,2) UNSIGNED,
	PRIMARY KEY (cuisineID)
)CHARACTER SET = utf8;

INSERT INTO cuisineType (sortOrder,typeName_en,typeName_ch) VALUES (1, 'Appetizer', '前菜');
INSERT INTO cuisineType (sortOrder,typeName_en,typeName_ch) VALUES (2, 'Beef&Lamp', '牛羊类');
INSERT INTO cuisineType (sortOrder,typeName_en,typeName_ch) VALUES (3, 'Seafood', '海鲜类');
INSERT INTO cuisineList (cuisineName_en,cuisineName_ch,description_en,description_ch,cuisineImage,typeID,dailySpecial,retailPrice,specialPrice) VALUES ('Fries', '薯条', 'Fries.txt', '薯条.txt', 'Fries.jpg', 1, 1, 1.99, 0.99);
INSERT INTO cuisineList (cuisineName_en,cuisineName_ch,description_en,description_ch,cuisineImage,typeID,dailySpecial,retailPrice,specialPrice) VALUES ('Fries2', '薯条2', 'Fries.txt', '薯条.txt', 'Fries.jpg', 2, 0, 2.99, 1.99);
INSERT INTO systemSettings (user,systemLanguage) VALUES ('admin', 'en');