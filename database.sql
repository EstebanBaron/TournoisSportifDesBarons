DROP TABLE IF EXISTS organisateur CASCADE; 
DROP TABLE IF EXISTS evenement CASCADE; 
DROP TABLE IF EXISTS tournois CASCADE; 
DROP TABLE IF EXISTS terrain CASCADE; 
DROP TABLE IF EXISTS dispose CASCADE;
DROP TABLE IF EXISTS equipe CASCADE;
DROP TABLE IF EXISTS joueur CASCADE; 

CREATE TABLE organisateur (
    numOrganisateur integer CONSTRAINT organisateur_PK PRIMARY KEY,
    nomUtilisateur VARCHAR(20) NOT NULL,
    motDePasse VARCHAR(20) NOT NULL,
    nom VARCHAR(15),
    prenom VARCHAR(15)
);

CREATE TABLE evenement (
    numEvenement integer CONSTRAINT evenement_PK PRIMARY KEY,
    lieu VARCHAR(20),
    dateEvenement DATE,
    typeJeu integer CHECK(typeJeu BETWEEN 1 AND 11),
    numOrga integer NOT NULL,
    CONSTRAINT evenement_FK FOREIGN KEY (numOrga) REFERENCES organisateur(numOrganisateur) ON DELETE CASCADE
);

CREATE TABLE tournois (
    numTournois integer CONSTRAINT tournois_PK PRIMARY KEY,
    nom VARCHAR(15) NOT NULL,
    numEvenement integer NOT NULL,
    CONSTRAINT tournois_FK FOREIGN KEY (numEvenement) REFERENCES evenement(numEvenement) ON DELETE CASCADE
);

CREATE TABLE terrain (
    numTerrain integer CONSTRAINT terrain_PK PRIMARY KEY,
    sport VARCHAR(10) NOT NULL CHECK(sport IN ('foot', 'rugby', 'basket', 'volley', 'petanque', 'tennis'))
);

CREATE TABLE dispose (
    numEvenement integer NOT NULL,
    CONSTRAINT disposeEvenement_FK FOREIGN KEY (numEvenement) REFERENCES evenement(numEvenement),
    numTerrain integer NOT NULL,
    CONSTRAINT disposeTerrain_FK FOREIGN KEY (numTerrain) REFERENCES terrain(numTerrain),
    CONSTRAINT dispose_PK PRIMARY KEY (numEvenement, numTerrain)
);

CREATE TABLE equipe (
    nom VARCHAR(15) CONSTRAINT equipe_PK PRIMARY KEY,
    club VARCHAR(15),
    numTournois integer NOT NULL,
    CONSTRAINT equipe_FK FOREIGN KEY (numTournois) REFERENCES tournois(numTournois) ON DELETE CASCADE
);

CREATE TABLE joueur (
    numJoueur integer CONSTRAINT joueur_PK PRIMARY KEY,
    nom VARCHAR(15),
    prenom VARCHAR(15),
    niveau integer NOT NULL CHECK(niveau BETWEEN 1 AND 7),
    nomEquipe VARCHAR(15) NOT NULL,
    CONSTRAINT joueur_FK FOREIGN KEY (nomEquipe) REFERENCES equipe(nom) ON DELETE CASCADE
);