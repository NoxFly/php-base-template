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

INSERT INTO universitycourse (id_univ, name) VALUES
	(1, 'Informatique et Mobilité'),
	(1, 'Miage');

INSERT INTO level (id_universitycourse, name) VALUES
	(1, 'L1'),
	(1, 'L2'),
	(1, 'L3'),
	(1, 'M1'),
	(1, 'M2'),
	(2, 'L1'),
	(2, 'L2'),
	(2, 'L3'),
	(2, 'M1'),
	(2, 'M2');

INSERT INTO student (id_user, id_level, id_year) VALUES
	(1, 4, 5),
	(2, 4, 5),
	(3, 4, 5),
	(4, 4, 4),
	(5, 3, 5);

INSERT INTO teacher (id_user) VALUES
	(6),
	(7);

INSERT INTO course (id_univ, name) VALUES
	(1, 'Architecture N-tiers'),
	(1, 'Synchronisation et communication avancée dans les systèmes'),
	(1, 'Java pour les nuls');

INSERT INTO courselevelyear (id_level, id_course, id_year) VALUES
	(4, 1, 5),
	(4, 2, 5),
	(3, 3, 5),
	(4, 1, 4),
	(4, 2, 4),
	(3, 3, 4);

INSERT INTO teacherteaching (id_teacher, id_course, id_year) VALUES
	(1, 1, 5),
	(2, 2, 5),
	(1, 1, 4);

INSERT INTO coursechapter (id_course, label, position) VALUES
	(1, 'chapitre 1', 0),
	(1, 'chapitre 2', 1),
	(1, 'chapitre 3', 2),
	(1, 'chapitre 4', 3),
	(1, 'chapitre 5', 4),
	(1, 'chapitre 6', 5),
	(2, 'chapitre 1', 0),
	(2, 'chapitre 2', 1),
	(2, 'chapitre 3', 2);

INSERT INTO exam (id_course, name, coeff, type, id_year, date_start, date_end) VALUES
	(1, 'controle continu 1', 		1, '0', 5, '2022-10-05 10:15:00', '2022-10-05 12:15:00'),
	(1, 'controle continu 2', 		1, '0', 5, '2022-12-20 10:15:00', '2022-12-20 12:15:00'),
	(1, 'controle intermédiaire 1', 2, '1', 5, '2023-01-23 10:15:00', '2023-02-07 12:15:00'),
	(1, 'controle intermédiaire 2', 2, '1', 5, '2023-02-20 10:15:00', '2023-03-20 12:15:00'),
	(1, 'controle final 1', 		3, '2', 5, '2023-03-07 10:15:00', '2023-03-10 12:15:00'),
	(1, 'controle final 9 3/4',		5, '2', 5, '2023-05-20 10:15:00', '2023-05-20 12:15:00'),
	--
	(2, 'controle continu 1', 		1, '0', 5, '2022-10-05 10:15:00', '2022-10-05 12:15:00'),
	(2, 'controle continu 2', 		1, '0', 5, '2022-12-20 10:15:00', '2022-12-20 12:15:00'),
	(2, 'controle intermédiaire 1', 2, '1', 5, '2023-01-23 10:15:00', '2023-02-07 12:15:00'),
	(2, 'controle intermédiaire 2', 2, '1', 5, '2023-02-20 10:15:00', '2023-03-20 12:15:00'),
	(2, 'controle final 1', 		3, '2', 5, '2023-03-07 10:15:00', '2023-03-10 12:15:00'),
	(2, 'controle final 2', 		5, '2', 5, '2023-05-20 10:15:00', '2023-05-20 12:15:00'),
	--
	(1, 'controle continu 1', 		1, '0', 4, '2021-10-05 10:15:00', '2021-10-05 12:15:00'),
	(1, 'controle continu 2', 		1, '0', 4, '2021-12-20 10:15:00', '2021-12-20 12:15:00'),
	(1, 'controle intermédiaire 1', 2, '1', 4, '2022-01-23 10:15:00', '2022-02-07 12:15:00'),
	(1, 'controle intermédiaire 2', 2, '1', 4, '2022-02-20 10:15:00', '2022-03-20 12:15:00'),
	(1, 'controle final 1', 		3, '2', 4, '2022-03-07 10:15:00', '2022-03-10 12:15:00'),
	(1, 'controle final 2', 		5, '2', 4, '2022-05-20 10:15:00', '2022-05-20 12:15:00'),
	--
	(2, 'controle continu 1', 		1, '0', 4, '2021-10-05 10:15:00', '2021-10-05 12:15:00'),
	(2, 'controle continu 2', 		1, '0', 4, '2021-12-20 10:15:00', '2021-12-20 12:15:00'),
	(2, 'controle intermédiaire 1', 2, '1', 4, '2022-01-23 10:15:00', '2022-02-07 12:15:00'),
	(2, 'controle intermédiaire 2', 2, '1', 4, '2022-02-20 10:15:00', '2022-03-20 12:15:00'),
	(2, 'controle final 1', 		3, '2', 4, '2022-03-07 10:15:00', '2022-03-10 12:15:00'),
	(2, 'controle final 2', 		5, '2', 4, '2022-05-20 10:15:00', '2022-05-20 12:15:00');

INSERT INTO examlevel (id_level, id_exam) VALUES
	(4, 1),
	(3, 2),
	(4, 3),
	(3, 4),
	(4, 5),
	(3, 6),
	(4, 7),
	(3, 8),
	(4, 9),
	(3, 10),
	(4, 11),
	(3, 12),
	(4, 13),
	(3, 14),
	(4, 15),
	(3, 16),
	(4, 17),
	(3, 18),
	(4, 19),
	(3, 20),
	(4, 21),
	(3, 22),
	(4, 23),
	(3, 24);

INSERT INTO question (id_chapter, state, proposals, answers, type) VALUES
	(1, 'la question 1', 'les propositions de réponses', 'les vraies réponses', '0'),
	(1, 'la question 2', 'A;B;C;D', '0', '1'),
	(1, 'la question 3', 'A;B;C;D', '1;2', '2'),
	(2, 'la question 4', 'A;B;C;D', '1;3', '2'),
	(7, 'la question 1', 'aucun;sens', 'une réponse', '0');

INSERT INTO examquestion (nb_points, id_exam, id_question) VALUES
	(15, 1,  1),
	(2,  1,  2),
	(2,  1,  3),
	(1,  1,  4),
	--
	(15, 2,  1),
	(2,  2,  2),
	(2,  2,  3),
	(1,  2,  4),
	--
	(15, 3,  1),
	(2,  3,  2),
	(2,  3,  3),
	(1,  3,  4),
	--
	(15, 4,  1),
	(2,  4,  2),
	(2,  4,  3),
	(1,  4,  4),
	--
	(15, 5,  1),
	(2,  5,  2),
	(2,  5,  3),
	(1,  5,  4),
	--
	(15, 6,  1),
	(2,  6,  2),
	(2,  6,  3),
	(1,  6,  4),
	--
	(15, 7,  1),
	(2,  7,  2),
	(2,  7,  3),
	(1,  7,  4),
	--
	(15, 8,  1),
	(2,  8,  2),
	(2,  8,  3),
	(1,  8,  4),
	--
	(15, 9,  1),
	(2,  9,  2),
	(2,  9,  3),
	(1,  9,  4),
	--
	(15, 10,  1),
	(2,  10,  2),
	(2,  10,  3),
	(1,  10,  4),
	--
	(15, 11,  1),
	(2,  11,  2),
	(2,  11,  3),
	(1,  11,  4),
	--
	(15, 12,  1),
	(2,  12,  2),
	(2,  12,  3),
	(1,  12,  4),
	--
	(15, 13,  1),
	(2,  13,  2),
	(2,  13,  3),
	(1,  13,  4),
	--
	(15, 14,  1),
	(2,  14,  2),
	(2,  14,  3),
	(1,  14,  4),
	--
	(15, 15,  1),
	(2,  15,  2),
	(2,  15,  3),
	(1,  15,  4),
	--
	(15, 16,  1),
	(2,  16,  2),
	(2,  16,  3),
	(1,  16,  4),
	--
	(15, 17,  1),
	(2,  17,  2),
	(2,  17,  3),
	(1,  17,  4),
	--
	(15, 18,  1),
	(2,  18,  2),
	(2,  18,  3),
	(1,  18,  4),
	--
	(15, 19,  1),
	(2,  19,  2),
	(2,  19,  3),
	(1,  19,  4),
	--
	(15, 20,  1),
	(2,  20,  2),
	(2,  20,  3),
	(1,  20,  4),
	--
	(15, 21,  1),
	(2,  21,  2),
	(2,  21,  3),
	(1,  21,  4),
	--
	(15, 22,  1),
	(2,  22,  2),
	(2,  22,  3),
	(1,  22,  4),
	--
	(15, 23,  1),
	(2,  23,  2),
	(2,  23,  3),
	(1,  23,  4),
	--
	(15, 24,  1),
	(2,  24,  2),
	(2,  24,  3),
	(1,  24,  4);

COMMIT;