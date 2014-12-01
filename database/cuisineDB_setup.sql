DROP DATABASE IF EXISTS cuisineDB;
CREATE DATABASE IF NOT EXISTS cuisineDB;
USE cuisineDB;

CREATE TABLE IF NOT EXISTS cuisineType (
	typeID TINYINT UNSIGNED NOT NULL, 
	typeName varchar(25) NOT NULL,
	tableName varchar(25) NOT NULL
);

CREATE TABLE IF NOT EXISTS cuisinelist (
	cuisineName varchar(50) NOT NULL,
	cuisineImage varchar(50) NOT NULL,
	description varchar(50) NOT NULL,
	cuisineMaterial varchar(25) NOT NULL
);

CREATE TABLE IF NOT EXISTS cuisineTypeSampleTB (
	cuisineName varchar(50) NOT NULL,
	cuisinePrice DOUBLE(8,2) UNSIGNED NOT NULL
);

CREATE TABLE IF NOT EXISTS SpecialListTB LIKE cuisineTypeSampleTB;

CREATE TABLE IF NOT EXISTS cuisineMaterialSample (
	cuisineName varchar(50) NOT NULL,
	cuisinePrice DOUBLE(8,2) UNSIGNED NOT NULL
);

INSERT INTO cuisineType VALUES (1, 'Appetizer', 'AppetizerTB');
CREATE TABLE IF NOT EXISTS AppetizerTB LIKE cuisineTypeSampleTB;
INSERT INTO cuisinelist VALUES ('Fries', 'Fries.jpg', 'Fries.txt', 'FriesMaterial');
INSERT INTO AppetizerTB VALUES ('Fries', 2.99);