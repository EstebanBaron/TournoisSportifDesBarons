--rajouter les relations pere-fils--;

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
    typeJeu integer CHECK(typeJeu BETWEEN 1 AND 11)
);

CREATE TABLE tournois (
    numTournois integer CONSTRAINT tournois_PK PRIMARY KEY,
    nom VARCHAR(15) NOT NULL
);

CREATE TABLE terrain (
    numTerrain integer CONSTRAINT terrain_PK PRIMARY KEY,
    sport VARCHAR(10) NOT NULL CHECK(IN ('foot', 'rugby', 'basket', 'volley', 'petanque', 'tennis'))
);

CREATE TABLE equipe (
    nom VARCHAR(15) CONSTRAINT equipe_PK PRIMARY KEY,
    club VARCHAR(15)
);

CREATE TABLE joueur (
    numJoueur integer CONSTRAINT joueur_PK PRIMARY KEY,
    nom VARCHAR(15),
    prenom VARCHAR(15),
    niveau integer NOT NULL CHECK(niveau BETWEEN 1 AND 7)
);