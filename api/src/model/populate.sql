USE examgenerator;
START TRANSACTION;
SET time_zone='+00:00';

DELETE FROM user;
DELETE FROM connection;
DELETE FROM account;




INSERT INTO account (mail, password) VALUES
	('nox.fly@gmail.com', '$2y$10$.2e4/qJjfDRsxeKZ5Tc18uqzpHuV.crNf4MzAkaiFgAsZ6MBGJmjO'), -- password : test

INSERT INTO user (id_account, firstname, lastname) VALUES
	(2, 'Nox', 'Fly');


COMMIT;