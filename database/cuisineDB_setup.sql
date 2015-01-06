DROP DATABASE IF EXISTS cuisineDB;
CREATE DATABASE IF NOT EXISTS cuisineDB;
USE cuisineDB;

CREATE TABLE IF NOT EXISTS cuisineType (
	typeID TINYINT UNSIGNED NOT NULL, 
	typeName_inEnglish varchar(25) NOT NULL,
	typeName_inChinese varchar(25) NOT NULL,
	tableName varchar(25) NOT NULL
)CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS cuisinelist (
	cuisineName_inEnglish varchar(50) NOT NULL,
	cuisineName_inChinese varchar(50) NOT NULL,
	cuisineImage varchar(50) NOT NULL,
	description_inEnglish varchar(50) NOT NULL,
	description_inChinese varchar(50) NOT NULL,
	cuisineMaterial varchar(25) NOT NULL,
	suggestPrice DOUBLE(8,2) UNSIGNED NOT NULL,
	grossProfit TINYINT UNSIGNED NOT NULL DEFAULT 50
)CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS cuisineTypeSampleTB (
	cuisineName_inEnglish varchar(50) NOT NULL,
	cuisineName_inChinese varchar(50) NOT NULL,
	cuisinePrice DOUBLE(8,2) UNSIGNED NOT NULL
)CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS SpecialListTB LIKE cuisineTypeSampleTB;

CREATE TABLE IF NOT EXISTS cuisineMaterialSample (
	cuisineName_inEnglish varchar(50) NOT NULL,
	cuisineName_inChinese varchar(50) NOT NULL,
	cuisinePrice DOUBLE(8,2) UNSIGNED NOT NULL
)CHARACTER SET = utf8;

INSERT INTO cuisineType VALUES (1, 'Appetizer', '前菜', 'AppetizerTB');
CREATE TABLE IF NOT EXISTS AppetizerTB LIKE cuisineTypeSampleTB;
INSERT INTO cuisinelist (cuisineName_inEnglish,cuisineName_inChinese,cuisineImage,description_inEnglish,description_inChinese,cuisineMaterial,suggestPrice) VALUES ('Fries', '薯条', 'Fries.jpg', 'Fries.txt', '薯条.txt', 'FriesMaterial', 1.99);

INSERT INTO AppetizerTB VALUES ('Fries', '薯条', 2.99);