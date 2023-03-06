SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS examgenerator;

USE examgenerator;

--
-- Base de données : `examgenerator`
--

-- --------------------------------------------------------

--
-- Structure de la table `university`
--

DROP TABLE IF EXISTS `university`;
CREATE TABLE IF NOT EXISTS `university` (
	`id`			int 			NOT NULL		AUTO_INCREMENT,
	`name` 			varchar(64) 	NOT NULL		UNIQUE,
	`domain` 		varchar(16) 	NOT NULL		UNIQUE,
	`created_at`	TIMESTAMP		DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) CHARSET=utf8mb4;

--
-- Structure de la table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
	`id`			int 			NOT NULL		AUTO_INCREMENT,
	`id_univ`		int				NOT NULL,
	`mail`			varchar(64)		NOT NULL		UNIQUE,
	`password`		varchar(64)		NOT NULL,
	`created_at`	TIMESTAMP		DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_univ`) REFERENCES university(`id`) ON DELETE CASCADE
) CHARSET=utf8mb4;

DROP TABLE IF EXISTS `connection`;
CREATE TABLE IF NOT EXISTS `connection` (
	`id_account`	int				NOT NULL		UNIQUE,
	`token`			varchar(32)		NOT NULL		UNIQUE,
	`created_at`	timestamp		NOT NULL		DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(`id_account`, `token`),
	FOREIGN KEY(`id_account`) REFERENCES account(`id`) ON DELETE CASCADE
) CHARSET=utf8mb4;

--
-- Structure de la table `universityyear`
--

DROP TABLE IF EXISTS `universityyear`;
CREATE TABLE IF NOT EXISTS `universityyear` (
	`id`			int				NOT NULL		AUTO_INCREMENT 		UNIQUE,
	`id_univ`		int				NOT NULL,
	`year`			year			NOT NULL,
	PRIMARY KEY (`id_univ`, `year`),
	FOREIGN KEY (`id_univ`) REFERENCES university(`id`) ON DELETE CASCADE,
	UNIQUE (id_univ, year)
) CHARSET=utf8mb4;

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
	`id`			int				NOT NULL		AUTO_INCREMENT,
	`id_account`	int				NOT NULL		UNIQUE,
	`firstname`		varchar(32)		NOT NULL,
	`lastname`		varchar(32)		NOT NULL,
	`uuid`			varchar(16)		NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_account`) REFERENCES account(`id`) ON DELETE CASCADE
) CHARSET=utf8mb4;

--
-- Structure de la table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
	`id`			int				NOT NULL		AUTO_INCREMENT,
	`id_user`		int				NOT NULL		UNIQUE,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_user`) REFERENCES teacher(`id`) ON DELETE CASCADE
) CHARSET=utf8mb4;

--
-- Structure de la table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
	`id`			int				NOT NULL		AUTO_INCREMENT,
	`id_user`		int				NOT NULL		UNIQUE,
	`id_level`		int				DEFAULT			NULL,
	`id_year`		int				DEFAULT			NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_user`) REFERENCES user(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`id_year`) REFERENCES universityyear(`id`) ON DELETE CASCADE
) CHARSET=utf8mb4;

--
-- Structure de la table `universitycourse`
--

DROP TABLE IF EXISTS `universitycourse`;
CREATE TABLE IF NOT EXISTS `universitycourse` (
	`id`			int				NOT NULL		AUTO_INCREMENT,
	`id_univ`		int				NOT NULL,
	`name`			varchar(64)		NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_univ`) REFERENCES university(`id`) ON DELETE CASCADE,
	UNIQUE (`id_univ`, `name`)
) CHARSET=utf8mb4;

--
-- Structure de la table `level`
--

DROP TABLE IF EXISTS `level`;
CREATE TABLE IF NOT EXISTS `level` (
	`id`			int				NOT NULL		AUTO_INCREMENT,
	`id_universitycourse`			int				NOT NULL,
	`name`			varchar(16)		NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_universitycourse`) REFERENCES universitycourse(`id`) ON DELETE CASCADE,
	UNIQUE (`id_universitycourse`, `name`)
) CHARSET=utf8mb4;

--
-- Structure de la table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
	`id`			int				NOT NULL		AUTO_INCREMENT,
	`id_univ`		int				NOT NULL,
	`name`			varchar(64)		NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_univ`) REFERENCES university(`id`) ON DELETE CASCADE,
	UNIQUE (`id_univ`, `name`)
) CHARSET=utf8mb4;

--
-- Structure de la table `teacherteaching`
--

DROP TABLE IF EXISTS `teacherteaching`;
CREATE TABLE IF NOT EXISTS `teacherteaching` (
	`id_teacher`	int				NOT NULL,
	`id_course`		int				NOT NULL,
	`id_year`		int				NOT NULL,
	FOREIGN KEY (`id_teacher`) REFERENCES teacher(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`id_course`) REFERENCES course(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`id_year`) REFERENCES universityyear(`id`) ON DELETE CASCADE,
	UNIQUE (`id_teacher`, `id_course`, `id_year`)
) CHARSET=utf8mb4;

--
-- Structure de la table `courselevelyear`
--

DROP TABLE IF EXISTS `courselevelyear`;
CREATE TABLE IF NOT EXISTS `courselevelyear` (
	`id_level`		int				NOT NULL,
	`id_course`		int				NOT NULL,
	`id_year`		int				NOT NULL,
	FOREIGN KEY (`id_level`) REFERENCES level(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`id_course`) REFERENCES course(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`id_year`) REFERENCES universityyear(`id`) ON DELETE CASCADE,
	UNIQUE (`id_level`, `id_course`, `id_year`)
) CHARSET=utf8mb4;

--
-- Structure de la table `coursechapter`
--

DROP TABLE IF EXISTS `coursechapter`;
CREATE TABLE IF NOT EXISTS `coursechapter` (
	`id`			int				NOT NULL		AUTO_INCREMENT,
	`id_course`		int				NOT NULL,
	`label`			varchar(64)		NOT NULL,
	`position`		int				NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_course`) REFERENCES course(`id`) ON DELETE CASCADE,
	CHECK (`position` >= 0),
	UNIQUE (`id_course`, `label`)
) CHARSET=utf8mb4;

--
-- Structure de la table `exam`
--

DROP TABLE IF EXISTS `exam`;
CREATE TABLE IF NOT EXISTS `exam` (
	`id`			int				NOT NULL		AUTO_INCREMENT,
	`id_course`		int				NOT NULL,
	`name`			varchar(64)		NOT NULL,
	`coeff`			int				NOT NULL,
	`type`			ENUM('0','1','2')				NOT NULL,
	`id_year`		int				NOT NULL,
	`date_start`	timestamp		DEFAULT			NULL,
	`date_end`		timestamp		DEFAULT			NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_course`) REFERENCES course(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`id_year`) REFERENCES universityyear(`id`) ON DELETE CASCADE,
	CHECK (`coeff` >= 0)
	-- CC = 0
	-- CI = 1
	-- CF = 2
) CHARSET=utf8mb4;

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
	`id`			int				NOT NULL		AUTO_INCREMENT,
	`id_chapter`	int				NOT NULL,
	`state`			varchar(1500)	NOT NULL,
	`proposals`		varchar(512)	NOT NULL		DEFAULT '',
	`answers`		varchar(512)	NOT NULL		DEFAULT '',
	`type`			ENUM('0','1','2','3','4')		NOT NULL,
	`created_at`	TIMESTAMP		DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_chapter`) REFERENCES coursechapter(`id`) ON DELETE CASCADE
	-- 0 = text
	-- 1 = unique answer
	-- 2 = multiple answers
	-- 3 = unique negative answer
	-- 4 = multiple negative answers
) CHARSET=utf8mb4;

--
-- Structure de la table `examquestion`
--

DROP TABLE IF EXISTS `examquestion`;
CREATE TABLE IF NOT EXISTS `examquestion` (
	`id_exam`		int				NOT NULL,
	`id_question`	int				NOT NULL,
	`nb_points`		float			DEFAULT NULL,
	`neg_points`	float			DEFAULT NULL,
	FOREIGN KEY (`id_exam`) REFERENCES exam(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`id_question`) REFERENCES question(`id`) ON DELETE CASCADE,
	CHECK (`nb_points` >= 0),
	CHECK (`neg_points` <= 0),
	UNIQUE (`id_exam`, `id_question`)
) CHARSET=utf8mb4;

--
-- Structure de la table `examlevel`
--

DROP TABLE IF EXISTS `examlevel`;
CREATE TABLE IF NOT EXISTS `examlevel` (
	`id_level`		int				NOT NULL,
	`id_exam`		int				NOT NULL,
	FOREIGN KEY (`id_level`) REFERENCES level(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`id_exam`) REFERENCES exam(`id`) ON DELETE CASCADE,
	UNIQUE (`id_level`, `id_exam`)
) CHARSET=utf8mb4;

--
-- Structure de la table `answer`
--

DROP TABLE IF EXISTS `answer`;
CREATE TABLE IF NOT EXISTS `answer` (
	`id_student`	int				NOT NULL,
	`id_question`	int				NOT NULL,
	`id_exam`		int				NOT NULL,
	`points`		float			NOT NULL,
	`comment`		varchar(128)	NOT NULL,
	`answer`		varchar(512)	NOT NULL,
	FOREIGN KEY (`id_student`) REFERENCES student(`id`),
	FOREIGN KEY (`id_question`) REFERENCES question(`id`),
	FOREIGN KEY (`id_exam`) REFERENCES exam(`id`),
	CHECK (`points` >= 0),
	UNIQUE (`id_student`, `id_question`, `id_exam`)
);




COMMIT;