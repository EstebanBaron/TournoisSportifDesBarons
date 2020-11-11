DROP TABLE IF EXISTS organisateur CASCADE; 
DROP TABLE IF EXISTS evenement CASCADE; 
DROP TABLE IF EXISTS tournois CASCADE; 
DROP TABLE IF EXISTS terrain CASCADE; 
DROP TABLE IF EXISTS dispose CASCADE;
DROP TABLE IF EXISTS equipe CASCADE;
DROP TABLE IF EXISTS joueur CASCADE; 

CREATE TABLE organisateur (
    --ici mettre l'identifiant en clé primaire ???? On s'en sert pour trouver les evenements par organisateurs
    --numOrganisateur integer CONSTRAINT organisateur_PK PRIMARY KEY,
    identifiant VARCHAR(20) CONSTRAINT organisateur_PK PRIMARY KEY,--NOT NULL,
    motDePasse VARCHAR(50) NOT NULL,
    nom VARCHAR(20),
    prenom VARCHAR(20)
);

CREATE TABLE evenement (
    numEvenement integer CONSTRAINT evenement_PK PRIMARY KEY,
    nom VARCHAR(40),
    lieu VARCHAR(20),
    dateEvenement DATE,
    typeJeu integer CHECK(typeJeu BETWEEN 1 AND 15),
    idOrga VARCHAR(20) NOT NULL,
    CONSTRAINT evenement_FK FOREIGN KEY (idOrga) REFERENCES organisateur(identifiant) ON DELETE CASCADE
    --numOrga integer NOT NULL,
    --CONSTRAINT evenement_FK FOREIGN KEY (numOrga) REFERENCES organisateur(numOrganisateur) ON DELETE CASCADE
);

CREATE TABLE tournois (
    numTournois integer CONSTRAINT tournois_PK PRIMARY KEY,
    nom VARCHAR(40) NOT NULL,
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