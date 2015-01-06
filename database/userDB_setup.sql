DROP DATABASE IF EXISTS userDB;
CREATE DATABASE IF NOT EXISTS userDB;
USE userDB;

CREATE TABLE IF NOT EXISTS userInfo (
	username varchar(10) NOT NULL,
	password varchar(25) NOT NULL,
	lname varchar(10) NOT NULL,
	fname varchar(10) NOT NULL,
	nickname varchar(10) NOT NULL,
	DOB varchar(10) NOT NULL,
	IDnumber varchar(18) NOT NULL,
	position varchar(25) NOT NULL
)CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS positionPermission (
	position_inEnglish varchar(25) NOT NULL,
	position_inChinese varchar(25) NOT NULL,
	userEditable varchar(1) NOT NULL DEFAULT 'N',
	positionEditable varchar(1) NOT NULL DEFAULT 'N',
	menuEditable varchar(1) NOT NULL DEFAULT 'N',
	cuisineEditable varchar(1) NOT NULL DEFAULT 'N',
	orderSubmitable varchar(1) NOT NULL DEFAULT 'N',
	orderChangeable varchar(1) NOT NULL DEFAULT 'N'
)CHARACTER SET = utf8;

INSERT INTO positionPermission VALUES ('admin', '默认管理员', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');
INSERT INTO userInfo VALUES ('admin', 'admin', 'admin', 'admin', ' ', '1991-02-21', '320404199102214417', 'admin');