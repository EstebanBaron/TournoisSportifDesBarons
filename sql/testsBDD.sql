--Creation d'exemples pour la database

-- suppression des anciennes insertions
DELETE FROM joueur;
DELETE FROM equipe;
DELETE FROM terrain;
DELETE FROM tournois;
DELETE FROM evenement;
DELETE FROM organisateur;

--Insertion dans organisateur

-- INSERT INTO organisateur VALUES(0001, 'Pierro', 'mdpPierro', 'Pierre', 'Rouget');
-- INSERT INTO organisateur VALUES(0002, 'Anonymous', 'mdpAnonymous', NULL,NULL);

INSERT INTO organisateur VALUES('Esteban', '87c0e0174cb359e4e01c356a56e4e8d1');
INSERT INTO organisateur VALUES('Julien', 'a64cd8062eaa4562c0ba463f2ee7c828');

--Insertion dans evenement

INSERT INTO evenement VALUES(01, 'event regional 1', 'Montpellier', '2020-11-9', 'Esteban');
INSERT INTO evenement VALUES(02, 'event regional 2', 'Montpellier', '2020-11-10', 'Esteban');
INSERT INTO evenement VALUES(03, 'event regional 3', 'Montpellier', '2020-11-11', 'Esteban');
INSERT INTO evenement VALUES(04, 'competition pez', 'Pezenas', '2020-12-10', 'Julien');

--Insertion dans tournois

INSERT INTO tournois VALUES(01, 'Frontignan Club tournament', NULL, 4, 01);
INSERT INTO tournois VALUES(05, 'Championnat du monde de Galatik Football', NULL, 5, 01);

INSERT INTO tournois VALUES(02, 'ESL tournament', 'DonaldTrumpTeam,Invincibles', 4, 02);    
INSERT INTO tournois VALUES(06, 'Classico Club tournament', NULL, 2, 02); 

INSERT INTO tournois VALUES(03, 'El paris', 'GauffreAuxNutella,LesHeros', 3, 03);
INSERT INTO tournois VALUES(07, 'Donald Trump tournament', 'trump1,trump2,trump3,trump4,trump5,trump6,trump7', 10, 03);

INSERT INTO tournois VALUES(04, 'Les grands club', NULL, 5, 04);
INSERT INTO tournois VALUES(08, 'Le tournois des chèvres', NULL, 4, 04);

--Insertion dans terrain

INSERT INTO terrain VALUES(01, 'Petanque',01);
INSERT INTO terrain VALUES(02, 'Petanque',02);
INSERT INTO terrain VALUES(03, 'Petanque',03);
INSERT INTO terrain VALUES(04, 'Petanque',04);
INSERT INTO terrain VALUES(05, 'Basketball',04);

--Insertion dans equipe

INSERT INTO equipe VALUES('Barcelone', 'fcBarcelone', 01);
INSERT INTO equipe VALUES('Galatix', 'galaxieAndromede', 01);
INSERT INTO equipe VALUES('EquipoMax', 'maxClub', 01);
INSERT INTO equipe VALUES('LesCaribous', 'laForet', 01);
INSERT INTO equipe VALUES('LesEspionsRusses', 'russieFC', 01);
INSERT INTO equipe VALUES('DonaldTrumpTeam', 'trumpFC', 02);
INSERT INTO equipe VALUES('Invincibles', NULL, 02);
INSERT INTO equipe VALUES('LesHeros', 'olympe', 03);
INSERT INTO equipe VALUES('GauffreAuxNutella', 'epicerie', 03);
INSERT INTO equipe VALUES('equipeMTP', 'MTP' , 04);
INSERT INTO equipe VALUES('equipePSG', 'PSG', 04);

--Insertion dans joueur
INSERT INTO joueur VALUES(01, NULL, NULL, 7,'Barcelone');
INSERT INTO joueur VALUES(02, NULL, NULL, 6, 'Barcelone');
INSERT INTO joueur VALUES(03, NULL, NULL, 6, 'Barcelone');
INSERT INTO joueur VALUES(34, NULL, NULL, 1, 'Barcelone');
INSERT INTO joueur VALUES(04, NULL, NULL, 7, 'Galatix');
INSERT INTO joueur VALUES(05, NULL, NULL, 7, 'Galatix');
INSERT INTO joueur VALUES(06, NULL, NULL, 7, 'Galatix');
INSERT INTO joueur VALUES(43, NULL, NULL, 5, 'Galatix');
INSERT INTO joueur VALUES(07, NULL, NULL, 6, 'EquipoMax');
INSERT INTO joueur VALUES(08, NULL, NULL, 7, 'EquipoMax');
INSERT INTO joueur VALUES(09, NULL, NULL, 6, 'EquipoMax');
INSERT INTO joueur VALUES(44, NULL, NULL, 6, 'EquipoMax');
INSERT INTO joueur VALUES(10, NULL, NULL, 7, 'DonaldTrumpTeam');
INSERT INTO joueur VALUES(11, NULL, NULL, 7, 'DonaldTrumpTeam');
INSERT INTO joueur VALUES(12, NULL, NULL, 7, 'DonaldTrumpTeam');
INSERT INTO joueur VALUES(45, NULL, NULL, 4, 'DonaldTrumpTeam');
INSERT INTO joueur VALUES(13, NULL, NULL, 6, 'Invincibles');
INSERT INTO joueur VALUES(14, NULL, NULL, 7, 'Invincibles');
INSERT INTO joueur VALUES(15, NULL, NULL, 7, 'Invincibles');
INSERT INTO joueur VALUES(46, NULL, NULL, 3, 'Invincibles');
INSERT INTO joueur VALUES(16, NULL, NULL, 7, 'LesHeros');
INSERT INTO joueur VALUES(17, NULL, NULL, 7, 'LesHeros');
INSERT INTO joueur VALUES(18, NULL, NULL, 6, 'LesHeros');
INSERT INTO joueur VALUES(19, NULL, NULL, 6, 'GauffreAuxNutella');
INSERT INTO joueur VALUES(20, NULL, NULL, 7, 'GauffreAuxNutella');
INSERT INTO joueur VALUES(21, NULL, NULL, 7, 'GauffreAuxNutella');

INSERT INTO joueur VALUES(22, 'BARON', 'Esteban', 7, 'equipeMTP');
INSERT INTO joueur VALUES(23, NULL, NULL, 2, 'equipeMTP');
INSERT INTO joueur VALUES(24, NULL, NULL, 2, 'equipeMTP');
INSERT INTO joueur VALUES(25, NULL, NULL, 3, 'equipeMTP');
INSERT INTO joueur VALUES(26, NULL, NULL, 3, 'equipeMTP');
INSERT INTO joueur VALUES(27, NULL, NULL, 2, 'equipeMTP');
INSERT INTO joueur VALUES(29, NULL, NULL, 1, 'equipePSG');
INSERT INTO joueur VALUES(30, NULL, NULL, 1, 'equipePSG');
INSERT INTO joueur VALUES(31, NULL, NULL, 1, 'equipePSG');
INSERT INTO joueur VALUES(32, NULL, NULL, 1, 'equipePSG');
INSERT INTO joueur VALUES(33, NULL, NULL, 1, 'equipePSG');

INSERT INTO joueur VALUES(35, NULL, NULL, 7, 'LesCaribous');
INSERT INTO joueur VALUES(36, NULL, NULL, 7, 'LesCaribous');
INSERT INTO joueur VALUES(37, NULL, NULL, 7, 'LesCaribous');
INSERT INTO joueur VALUES(38, NULL, NULL, 7, 'LesCaribous');
INSERT INTO joueur VALUES(39, NULL, NULL, 7, 'LesEspionsRusses');
INSERT INTO joueur VALUES(40, NULL, NULL, 7, 'LesEspionsRusses');
INSERT INTO joueur VALUES(41, NULL, NULL, 7, 'LesEspionsRusses');
INSERT INTO joueur VALUES(42, NULL, NULL, 7, 'LesEspionsRusses');

--TEST DES CONTRAINTES


-- INSERT INTO tournois VALUES(50, 'tournois 50','EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE',5, 01);
-- INSERT INTO equipe VALUES('Nom Eq_120-2', 'nomC', 03);
 /*

INSERT INTO terrain VALUES (01, '100m');

INSERT INTO evenement VALUES (05, 'oui', '2020-10-10', 15, 0001);
INSERT INTO evenement VALUES (05, 'oui', '2020-10-10', 0, 0001);

INSERT INTO joueur VALUES (50, NULL, NULL, 10, 'Galatix');
INSERT INTO joueur VALUES (50, NULL, NULL, 0, 'Galatix');


*/
