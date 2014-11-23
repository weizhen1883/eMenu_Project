DROP DATABASE IF EXISTS cuisineDB;
CREATE DATABASE IF NOT EXISTS cuisineDB;
USE cuisineDB;

CREATE TABLE IF NOT EXISTS cuisineType (
	typeID TINYINT UNSIGNED NOT NULL, 
	typeName varchar(25) NOT NULL,
	tableName varchar(25) NOT NULL
);

CREATE TABLE IF NOT EXISTS cuisinelist (
	cuisineName varchar(25) NOT NULL,
	cuisineImage varchar(25) NOT NULL,
	description varchar(25) NOT NULL,
	cuisineMaterial varchar(25) NOT NULL
);

CREATE TABLE IF NOT EXISTS cuisineImage (
	imageName varchar(25) NOT NULL;
	image blob NOT NULL;
	imageType varchar(50) NOT NULL;
)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS cuisineTypeSampleTB (
	cuisineName varchar(25) NOT NULL,
	cuisinePrice DOUBLE(8,2) UNSIGNED NOT NULL
);

INSERT INTO cuisineType VALUES (1, 'Appetizer', 'AppetizerTB');
CREATE TABLE IF NOT EXISTS AppetizerTB LIKE cuisineTypeSampleTB;
INSERT INTO cuisinelist VALUES ('Fries', 'FriesImage', 'FriesDescriotion', 'potatos');
INSERT INTO AppetizerTB VALUES ('Fries', 2.99);