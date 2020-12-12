DROP TABLE IF EXISTS organisateur CASCADE; 
DROP TABLE IF EXISTS evenement CASCADE; 
DROP TABLE IF EXISTS tournois CASCADE; 
DROP TABLE IF EXISTS terrain CASCADE; 
DROP TABLE IF EXISTS equipe CASCADE;
DROP TABLE IF EXISTS joueur CASCADE; 

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
    sport VARCHAR(10) NOT NULL CHECK(sport IN ('Football', 'Rugby', 'Basketball', 'Volley', 'Petanque', 'Tennis')),
    numEvenement integer NOT NULL,
    CONSTRAINT terrain_FK FOREIGN KEY (numEvenement) REFERENCES evenement(numEvenement) ON DELETE CASCADE
);

CREATE TABLE equipe (
    nom VARCHAR(30) CONSTRAINT equipe_PK PRIMARY KEY,
    club VARCHAR(30),
    numTournois integer NOT NULL,
    CONSTRAINT equipe_FK FOREIGN KEY (numTournois) REFERENCES tournois(numTournois) ON DELETE CASCADE
);

CREATE TABLE joueur (
    numJoueur integer CONSTRAINT joueur_PK PRIMARY KEY,
    nom VARCHAR(20),
    prenom VARCHAR(20),
    niveau integer NOT NULL CHECK(niveau BETWEEN 1 AND 7),
    nomEquipe VARCHAR(30) NOT NULL,
    CONSTRAINT joueur_FK FOREIGN KEY (nomEquipe) REFERENCES equipe(nom) ON DELETE CASCADE
);


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



--enleve les espaces présents dans le nom d'équipe
CREATE OR REPLACE FUNCTION enleveEspaceNomEquipe() RETURNS TRIGGER AS $enleveEspaceNomEquipe$
DECLARE 
nomEquipe VARCHAR(30); 
BEGIN
    WHILE NEW.nom LIKE '% %' LOOP
        SELECT regexp_replace(NEW.nom, ' ', '') INTO nomEquipe;
        NEW.nom := nomEquipe;
    END LOOP;
    RETURN NEW;
END;

$enleveEspaceNomEquipe$ LANGUAGE plpgsql;

CREATE TRIGGER secure_NomEquipe BEFORE INSERT ON equipe
    FOR EACH ROW EXECUTE PROCEDURE enleveEspaceNomEquipe();
