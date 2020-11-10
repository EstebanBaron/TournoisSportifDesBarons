--Creation d'exemples pour la database

-- suppression des anciennes insertions
DELETE FROM joueur;
DELETE FROM equipe;
DELETE FROM dispose;
DELETE FROM terrain;
DELETE FROM tournois;
DELETE FROM evenement;
DELETE FROM organisateur;

--Insertion dans organisateur

INSERT INTO organisateur VALUES(0001, 'Pierro', 'mdpPierro', 'Pierre', 'Rouget');
INSERT INTO organisateur VALUES(0002, 'Anonymous', 'mdpAnonymous', NULL,NULL);

--Insertion dans evenement

INSERT INTO evenement VALUES(01, 'event regional', 'Montpellier', '2020-10-5', 3, 0001);
INSERT INTO evenement VALUES(02, 'compet pez', 'Pezenas', '2020-12-10', 6, 0002);

--Insertion dans tournois

INSERT INTO tournois VALUES(01, 'tournois 1', 01);
INSERT INTO tournois VALUES(02, 'tournois final', 01);
INSERT INTO tournois VALUES(03, 'tournois cadets', 02);

--Insertion dans terrain

INSERT INTO terrain VALUES(01, 'petanque');
INSERT INTO terrain VALUES(02, 'petanque');
INSERT INTO terrain VALUES(03, 'petanque');
INSERT INTO terrain VALUES(04, 'petanque');
INSERT INTO terrain VALUES(05, 'basket');

--Insertion dans dispose

INSERT INTO dispose VALUES(01,01);
INSERT INTO dispose VALUES(01,02);
INSERT INTO dispose VALUES(01,03);
INSERT INTO dispose VALUES(01,04);
INSERT INTO dispose VALUES(02,05);

--Insertion dans equipe

INSERT INTO equipe VALUES('Les papis', 'PPP', 01);
INSERT INTO equipe VALUES('NomEq1', 'nomClub1', 01);
INSERT INTO equipe VALUES('NomEq2', 'nomClub2', 01);
INSERT INTO equipe VALUES('NomEq3', 'nomClub3', 01);
INSERT INTO equipe VALUES('NomEq4', 'nomClub4', 01);
INSERT INTO equipe VALUES('NomEq5', 'nomClub5', 02);
INSERT INTO equipe VALUES('NomEq6', 'nomClub6', 02);
INSERT INTO equipe VALUES('equipeEste', 'Les meilleurs', 03);
INSERT INTO equipe VALUES('equipeNullos', 'Les Nullos', 03);

--Insertion dans joueur
INSERT INTO joueur VALUES(01, NULL, NULL, 7,'Les papis');
INSERT INTO joueur VALUES(02, NULL, NULL, 6, 'Les papis');
INSERT INTO joueur VALUES(03, NULL, NULL, 7, 'Les papis');
INSERT INTO joueur VALUES(04, NULL, NULL, 7, 'NomEq1');
INSERT INTO joueur VALUES(05, NULL, NULL, 7, 'NomEq1');
INSERT INTO joueur VALUES(06, NULL, NULL, 7, 'NomEq1');
INSERT INTO joueur VALUES(07, NULL, NULL, 6, 'NomEq2');
INSERT INTO joueur VALUES(08, NULL, NULL, 7, 'NomEq2');
INSERT INTO joueur VALUES(09, NULL, NULL, 6, 'NomEq2');
INSERT INTO joueur VALUES(10, NULL, NULL, 7, 'NomEq3');
INSERT INTO joueur VALUES(11, NULL, NULL, 7, 'NomEq3');
INSERT INTO joueur VALUES(12, NULL, NULL, 7, 'NomEq3');
INSERT INTO joueur VALUES(13, NULL, NULL, 6, 'NomEq4');
INSERT INTO joueur VALUES(14, NULL, NULL, 7, 'NomEq4');
INSERT INTO joueur VALUES(15, NULL, NULL, 7, 'NomEq4');
INSERT INTO joueur VALUES(16, NULL, NULL, 7, 'NomEq5');
INSERT INTO joueur VALUES(17, NULL, NULL, 7, 'NomEq5');
INSERT INTO joueur VALUES(18, NULL, NULL, 6, 'NomEq5');
INSERT INTO joueur VALUES(19, NULL, NULL, 6, 'NomEq6');
INSERT INTO joueur VALUES(20, NULL, NULL, 7, 'NomEq6');
INSERT INTO joueur VALUES(21, NULL, NULL, 7, 'NomEq6');

INSERT INTO joueur VALUES(22, 'BARON', 'Esteban', 7, 'equipeEste');
INSERT INTO joueur VALUES(23, NULL, NULL, 2, 'equipeEste');
INSERT INTO joueur VALUES(24, NULL, NULL, 2, 'equipeEste');
INSERT INTO joueur VALUES(25, NULL, NULL, 3, 'equipeEste');
INSERT INTO joueur VALUES(26, NULL, NULL, 3, 'equipeEste');
INSERT INTO joueur VALUES(27, NULL, NULL, 2, 'equipeEste');
INSERT INTO joueur VALUES(28, NULL, NULL, 1, 'equipeNullos');
INSERT INTO joueur VALUES(29, NULL, NULL, 1, 'equipeNullos');
INSERT INTO joueur VALUES(30, NULL, NULL, 1, 'equipeNullos');
INSERT INTO joueur VALUES(31, NULL, NULL, 1, 'equipeNullos');
INSERT INTO joueur VALUES(32, NULL, NULL, 1, 'equipeNullos');
INSERT INTO joueur VALUES(33, NULL, NULL, 1, 'equipeNullos');

--TEST DES CONTRAINTES

/* 

INSERT INTO terrain VALUES (01, '100m');

INSERT INTO evenement VALUES (05, 'oui', '2020-10-10', 15, 0001);
INSERT INTO evenement VALUES (05, 'oui', '2020-10-10', 0, 0001);

INSERT INTO joueur VALUES (50, NULL, NULL, 10, 'NomEq1');
INSERT INTO joueur VALUES (50, NULL, NULL, 0, 'NomEq1');


*/
