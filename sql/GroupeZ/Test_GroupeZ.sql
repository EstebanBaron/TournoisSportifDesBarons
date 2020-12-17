
--Insertions organisateur
INSERT INTO organisateur VALUES ('Test', '0cbc6611f5540bd0809a388dc95a615b');


--Insertions événement 
INSERT INTO evenement VALUES (01, 'Tournois sportif', 'Montpellier', '2020-12-20', 'Test');
INSERT INTO evenement VALUES (02, 'Rolland Garos', 'Paris', '2020-12-20', 'Test');


--Insertion tournois
INSERT INTO tournois VALUES (01, 'Principal', NULL, 3, 01);
INSERT INTO tournois VALUES (02, 'Consolante', NULL, 3, 01);
INSERT INTO tournois VALUES (03, 'Les Champions', 'RogerFedererTeam,NadalTeam', 3, 02);



--Insertion terrain
INSERT INTO terrain VALUES (01,'Volley');
INSERT INTO terrain VALUES (02,'Volley');
INSERT INTO terrain VALUES (03,'Volley');
INSERT INTO terrain VALUES (04,'Volley');
INSERT INTO terrain VALUES (05,'Volley');
INSERT INTO terrain VALUES (06,'Tennis');


--Insertion dispose
INSERT INTO dispose VALUES (01,01);
INSERT INTO dispose VALUES (01,02);
INSERT INTO dispose VALUES (01,03);
INSERT INTO dispose VALUES (01,04);
INSERT INTO dispose VALUES (01,05);
INSERT INTO dispose VALUES (02,06);



--Insertion équipe
INSERT INTO equipe VALUES ('A', 'fcA', 01);
INSERT INTO equipe VALUES ('B', 'BClub', 01);
INSERT INTO equipe VALUES ('C', NULL, 01);
INSERT INTO equipe VALUES ('D', NULL, 01);
INSERT INTO equipe VALUES ('E', NULL, 01);
INSERT INTO equipe VALUES ('F', NULL, 01);
INSERT INTO equipe VALUES ('G', NULL, 01);
INSERT INTO equipe VALUES ('RogerFedererTeam', NULL, 02);
INSERT INTO equipe VALUES ('NadalTeam', 'EspagneClub', 02);


--Insertion joueur
INSERT INTO joueur VALUES (01, 'nomj1', 'prenomj1', 7,'A');
INSERT INTO joueur VALUES (02, 'nomj2', 'prenomj2', 6, 'A');
INSERT INTO joueur VALUES (03, 'nomj3', 'prenomj3', 6, 'A');
INSERT INTO joueur VALUES (04, 'nomj4', 'prenomj4', 7,'B');
INSERT INTO joueur VALUES (05, 'nomj5', 'prenomj5', 6, 'B');
INSERT INTO joueur VALUES (06, 'nomj6', 'prenomj6', 6, 'B');
INSERT INTO joueur VALUES (07, 'nomj7', 'prenomj7', 7,'C');
INSERT INTO joueur VALUES (08, 'nomj8', 'prenomj8', 6, 'C');
INSERT INTO joueur VALUES (09, 'nomj9', 'prenomj9', 6, 'C');
INSERT INTO joueur VALUES (10, 'nomj10', 'prenomj10', 7,'D');
INSERT INTO joueur VALUES (11, 'nomj11', 'prenomj11', 6, 'D');
INSERT INTO joueur VALUES (12, 'nomj12', 'prenomj12', 6, 'D');
INSERT INTO joueur VALUES (13, 'nomj13', 'prenomj13', 7,'E');
INSERT INTO joueur VALUES (14, 'nomj14', 'prenomj14', 6, 'E');
INSERT INTO joueur VALUES (15, 'nomj15', 'prenomj15', 6, 'E');
INSERT INTO joueur VALUES (16, 'nomj16', 'prenomj16', 7,'F');
INSERT INTO joueur VALUES (17, 'nomj17', 'prenomj17', 6, 'F');
INSERT INTO joueur VALUES (18, 'nomj18', 'prenomj18', 6, 'F');
INSERT INTO joueur VALUES (19, 'nomj19', 'prenomj19', 7,'G');
INSERT INTO joueur VALUES (21, 'nomj20', 'prenomj20', 6, 'G');
INSERT INTO joueur VALUES (22, 'nomj21', 'prenomj21', 6, 'G');
INSERT INTO joueur VALUES (23, 'Federer', 'Roger', 7,'RogerFedererTeam');
INSERT INTO joueur VALUES (24, 'Nadal', 'Rafael', 7, 'NadalTeam');

--TEST DES CONTRAINTES

/*
INSERT INTO terrain VALUES (01, '100m');

INSERT INTO evenement VALUES (05, 'oui', '2020-10-10', 15, 0001);
INSERT INTO evenement VALUES (05, 'oui', '2020-10-10', 0, 0001);

INSERT INTO joueur VALUES (50, NULL, NULL, 10, 'Galatix');
INSERT INTO joueur VALUES (50, NULL, NULL, 0, 'Galatix');


*/

--TEST DES TRIGGERS

/*
INSERT INTO tournois VALUES(03, 'tournois3','EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE',5, 01);



*/ 