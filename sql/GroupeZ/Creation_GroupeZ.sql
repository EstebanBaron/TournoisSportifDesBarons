-- 21804587 BARON Esteban
-- 21808379 LEBARON Julien

CREATE TABLE organisateur (
    identifiant VARCHAR(20) CONSTRAINT organisateur_PK PRIMARY KEY,
    motDePasse VARCHAR(50) NOT NULL
);

CREATE TABLE evenement (
    numEvenement integer CONSTRAINT evenement_PK PRIMARY KEY,
    nom VARCHAR(40),
    lieu VARCHAR(50),
    dateEvenement DATE,
    idOrga VARCHAR(20) NOT NULL,
    CONSTRAINT evenement_FK FOREIGN KEY (idOrga) REFERENCES organisateur(identifiant) ON DELETE CASCADE
);

CREATE TABLE tournois (
    numTournois integer CONSTRAINT tournois_PK PRIMARY KEY,
    nom VARCHAR(40) NOT NULL,
    classement VARCHAR,
    typeJeu integer CHECK(typeJeu BETWEEN 1 AND 15),
    numEvenement integer NOT NULL,
    CONSTRAINT tournois_FK FOREIGN KEY (numEvenement) REFERENCES evenement(numEvenement) ON DELETE CASCADE
);

CREATE TABLE terrain (
    numTerrain integer CONSTRAINT terrain_PK PRIMARY KEY,
    sport VARCHAR(10) NOT NULL CHECK(sport IN ('Football', 'Rugby', 'Basketball', 'Volley', 'Petanque', 'Tennis'))
);

CREATE TABLE dispose (
    numEvenement integer NOT NULL,  
    CONSTRAINT disposeEvenement_FK FOREIGN KEY (numEvenement) REFERENCES evenement(numEvenement) ON DELETE CASCADE,
    numTerrain integer NOT NULL,
    CONSTRAINT disposeTerrain_FK FOREIGN KEY (numTerrain) REFERENCES terrain(numTerrain) ON DELETE CASCADE,
    CONSTRAINT dispose_PK PRIMARY KEY (numEvenement, numTerrain)
);

CREATE TABLE equipe (
    numEquipe integer CONSTRAINT equipe_PK PRIMARY KEY,
    nom VARCHAR(30) NOT NULL,
    club VARCHAR(30),
    numTournois integer NOT NULL,
    CONSTRAINT equipe_FK FOREIGN KEY (numTournois) REFERENCES tournois(numTournois) ON DELETE CASCADE
);

CREATE TABLE joueur (
    numJoueur integer CONSTRAINT joueur_PK PRIMARY KEY,
    nom VARCHAR(20),
    prenom VARCHAR(20),
    niveau integer NOT NULL CHECK(niveau BETWEEN 1 AND 7),
    numEquipe integer NOT NULL,
    CONSTRAINT joueur_FK FOREIGN KEY (numEquipe) REFERENCES equipe(numEquipe) ON DELETE CASCADE
);






-- TRIGGERS --
--verifie si la taille de classement ne dépasse pas 495 caractères
CREATE OR REPLACE FUNCTION verifieTailleClassement() RETURNS TRIGGER AS $verifieTailleClassement$
BEGIN
    IF LENGTH(NEW.classement) > 495 THEN
        NEW.classement := NULL;
        RAISE NOTICE 'Taille du classement depassee, la taille max est de 495 caracteres (nombre equipe max(16) * nombre caracteres max pour le nom d une equipe(30)). Mise a NULL du classement';
    END IF;
    RETURN NEW;
END;

$verifieTailleClassement$ LANGUAGE plpgsql;

CREATE TRIGGER secure_Tailleclassement BEFORE UPDATE OR INSERT ON tournois
    FOR EACH ROW EXECUTE PROCEDURE verifieTailleClassement();



--enleve les caractères interdit (' ','_','-') présents dans le nom d'équipe
CREATE OR REPLACE FUNCTION enleveCaracteresInterditsNomEquipe() RETURNS TRIGGER AS $enleveCaracteresInterditsNomEquipe$
DECLARE 
nomEquipe VARCHAR(30); 
BEGIN
    WHILE NEW.nom LIKE '% %' OR NEW.nom LIKE '%\_%' OR NEW.nom LIKE '%-%' LOOP
        IF NEW.nom LIKE '% %' THEN
            SELECT regexp_replace(NEW.nom, ' ', '') INTO nomEquipe;
            NEW.nom := nomEquipe;
        END IF;
        IF NEW.nom LIKE '%\_%' THEN
            SELECT regexp_replace(NEW.nom, '_', '') INTO nomEquipe;
            NEW.nom := nomEquipe;
        END IF;
        IF NEW.nom LIKE '%-%' THEN
            SELECT regexp_replace(NEW.nom, '-', '') INTO nomEquipe;
            NEW.nom := nomEquipe;
        END IF;
    END LOOP;
    RETURN NEW;
END;

$enleveCaracteresInterditsNomEquipe$ LANGUAGE plpgsql;

CREATE TRIGGER secure_NomEquipe BEFORE INSERT ON equipe
    FOR EACH ROW EXECUTE PROCEDURE enleveCaracteresInterditsNomEquipe();




-- INSERTION
--Insertions organisateur
INSERT INTO organisateur VALUES ('Test', '0cbc6611f5540bd0809a388dc95a615b');
INSERT INTO organisateur VALUES ('Test2', '0cbc6611f5540bd0809a388dc95a615b');


--Insertions événement 
INSERT INTO evenement VALUES (01, 'Tournois sportif', 'Montpellier', '2020-12-20', 'Test');
INSERT INTO evenement VALUES (02, 'Rolland Garos', 'Paris', '2020-12-16', 'Test');
INSERT INTO evenement VALUES (03, 'ESL tournament', 'Londres', '2020-12-25', 'Test2');

--Insertion tournois
INSERT INTO tournois VALUES (01, 'Principal', NULL, 3, 01);
INSERT INTO tournois VALUES (02, 'Consolante', NULL, 3, 01);
INSERT INTO tournois VALUES (03, 'Les Champions', 'RogerFedererTeam,NadalTeam', 1, 02);
INSERT INTO tournois VALUES (04, 'Galactik', NULL, 1, 03);



--Insertion terrain
INSERT INTO terrain VALUES (01, 'Volley');
INSERT INTO terrain VALUES (02, 'Volley');
INSERT INTO terrain VALUES (03, 'Volley');
INSERT INTO terrain VALUES (04, 'Volley');
INSERT INTO terrain VALUES (05, 'Volley');
INSERT INTO terrain VALUES (06, 'Tennis');
INSERT INTO terrain VALUES (07, 'Tennis');
INSERT INTO terrain VALUES (08, 'Tennis');
INSERT INTO terrain VALUES (09, 'Tennis');


--Insertion dispose
INSERT INTO dispose VALUES (01, 01);
INSERT INTO dispose VALUES (01, 02);
INSERT INTO dispose VALUES (01, 03);
INSERT INTO dispose VALUES (01, 04);
INSERT INTO dispose VALUES (01, 05);
INSERT INTO dispose VALUES (02, 06);
INSERT INTO dispose VALUES (03, 07);
INSERT INTO dispose VALUES (03, 08);
INSERT INTO dispose VALUES (03, 09);


--Insertion équipe
INSERT INTO equipe VALUES (01, 'A', 'fcA', 01);
INSERT INTO equipe VALUES (02, 'B', 'BClub', 01);
INSERT INTO equipe VALUES (03, 'C', NULL, 01);
INSERT INTO equipe VALUES (04, 'D', NULL, 01);
INSERT INTO equipe VALUES (05, 'E', NULL, 01);
INSERT INTO equipe VALUES (06, 'F', NULL, 01);
INSERT INTO equipe VALUES (07, 'G', NULL, 01);
INSERT INTO equipe VALUES (08, 'RogerFedererTeam', NULL, 03);
INSERT INTO equipe VALUES (09, 'NadalTeam', 'EspagneClub', 03);
INSERT INTO equipe VALUES (10, 'Equipe1', NULL, 04);
INSERT INTO equipe VALUES (11, 'Equipe2', NULL, 04);
INSERT INTO equipe VALUES (12, 'Equipe3', NULL, 04);
INSERT INTO equipe VALUES (13, 'Equipe4', NULL, 04);
INSERT INTO equipe VALUES (14, 'Equipe5', NULL, 04);
INSERT INTO equipe VALUES (15, 'Equipe6', NULL, 04);
INSERT INTO equipe VALUES (16, 'Equipe7', NULL, 04);



--Insertion joueur
INSERT INTO joueur VALUES (01, 'nomj1', 'prenomj1', 7, 01);
INSERT INTO joueur VALUES (02, 'nomj2', 'prenomj2', 6, 01);
INSERT INTO joueur VALUES (03, 'nomj3', 'prenomj3', 6, 01);
INSERT INTO joueur VALUES (04, 'nomj4', 'prenomj4', 7, 02);
INSERT INTO joueur VALUES (05, 'nomj5', 'prenomj5', 6, 02);
INSERT INTO joueur VALUES (06, 'nomj6', 'prenomj6', 6, 02);
INSERT INTO joueur VALUES (07, 'nomj7', 'prenomj7', 7, 03);
INSERT INTO joueur VALUES (08, 'nomj8', 'prenomj8', 6, 03);
INSERT INTO joueur VALUES (09, 'nomj9', 'prenomj9', 6, 03);
INSERT INTO joueur VALUES (10, 'nomj10', 'prenomj10', 7, 04);
INSERT INTO joueur VALUES (11, 'nomj11', 'prenomj11', 6, 04);
INSERT INTO joueur VALUES (12, 'nomj12', 'prenomj12', 6, 04);
INSERT INTO joueur VALUES (13, 'nomj13', 'prenomj13', 7, 05);
INSERT INTO joueur VALUES (14, 'nomj14', 'prenomj14', 6, 05);
INSERT INTO joueur VALUES (15, 'nomj15', 'prenomj15', 6, 05);
INSERT INTO joueur VALUES (16, 'nomj16', 'prenomj16', 7, 06);
INSERT INTO joueur VALUES (17, 'nomj17', 'prenomj17', 6, 06);
INSERT INTO joueur VALUES (18, 'nomj18', 'prenomj18', 6, 06);
INSERT INTO joueur VALUES (19, 'nomj19', 'prenomj19', 7, 07);
INSERT INTO joueur VALUES (21, 'nomj20', 'prenomj20', 6, 07);
INSERT INTO joueur VALUES (22, 'nomj21', 'prenomj21', 6, 07);
INSERT INTO joueur VALUES (23, 'Federer', 'Roger', 7, 08);
INSERT INTO joueur VALUES (24, 'Nadal', 'Rafael', 7, 09);
INSERT INTO joueur VALUES (25, 'Akalni', 'Lolita', 1, 10);
INSERT INTO joueur VALUES (26, 'Provo', 'Edward', 2, 11);
INSERT INTO joueur VALUES (27, 'Falou', 'Edmun', 3, 12);
INSERT INTO joueur VALUES (28, 'Quaski', 'Manuel', 4, 13);
INSERT INTO joueur VALUES (29, 'Erandi', 'Frank', 5, 14);
INSERT INTO joueur VALUES (30, 'Rautil', 'Matilde', 6, 15);