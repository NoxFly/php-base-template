SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS mydatabase;

USE mydatabase;

--
-- Base de données : `mydatabase`
--

-- --------------------------------------------------------

--
-- Structure of the table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
	`id`			int 			NOT NULL		AUTO_INCREMENT,
	`mail`			varchar(64)		NOT NULL		UNIQUE,
	`password`		varchar(64)		NOT NULL,
	`created_at`	TIMESTAMP		DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) CHARSET=utf8mb4;

--
-- Structure of the table `connection`
--

DROP TABLE IF EXISTS `connection`;
CREATE TABLE IF NOT EXISTS `connection` (
	`id_account`	int				NOT NULL		UNIQUE,
	`token`			varchar(32)		NOT NULL		UNIQUE,
	`created_at`	timestamp		NOT NULL		DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(`id_account`, `token`),
	FOREIGN KEY(`id_account`) REFERENCES account(`id`) ON DELETE CASCADE
) CHARSET=utf8mb4;

--
-- Structure of the table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
	`id`			int				NOT NULL		AUTO_INCREMENT,
	`id_account`	int				NOT NULL		UNIQUE,
	`firstname`		varchar(32)		NOT NULL,
	`lastname`		varchar(32)		NOT NULL
	PRIMARY KEY (`id`)
) CHARSET=utf8mb4;


COMMIT;