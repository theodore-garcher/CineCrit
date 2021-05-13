CREATE TABLE Film(
   idFilm SERIAL,
   titre VARCHAR(100),
   synopsis TEXT,
   dateSortie DATE,
   boxOffice BIGINT,
   dureeMinutesFilm SMALLINT,
   voFilm CHAR(2),
   PRIMARY KEY(idFilm)
);

CREATE TABLE Genre(
   codeGenre SERIAL,
   nomGenre VARCHAR(50),
   PRIMARY KEY(codeGenre)
);

CREATE TABLE Personnalite(
   idPersonalite SERIAL,
   nomPerso VARCHAR(100),
   prenomPerso VARCHAR(100),
   dateNaissance DATE,
   nationalitePerso CHAR(2),
   PRIMARY KEY(idPersonalite)
);

CREATE TABLE Production(
   codeProd SERIAL,
   nomProd VARCHAR(100),
   nationaliteProd CHAR(2),
   PRIMARY KEY(codeProd)
);

CREATE TABLE Utilisateur(
   idUser SERIAL,
   sexeUser CHAR(1),
   isAdmin BOOLEAN,
   mailUser VARCHAR(320),
   motDePasse VARCHAR(64),
   pseudoUser VARCHAR(32),
   PRIMARY KEY(idUser),
   UNIQUE(mailUser),
   UNIQUE(pseudoUser)
);

CREATE TABLE Critique(
   idCrit SERIAL,
   noteCrit SMALLINT,
   texteCrit TEXT,
   idFilm INTEGER NOT NULL,
   idUser INTEGER NOT NULL,
   PRIMARY KEY(idCrit),
   UNIQUE(idFilm),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(idUser) REFERENCES Utilisateur(idUser)
);

CREATE TABLE Commentaire(
   idCom SERIAL,
   texteCom TEXT,
   dateCom TIMESTAMP,
   idUser INTEGER NOT NULL,
   idCrit INTEGER NOT NULL,
   PRIMARY KEY(idCom),
   FOREIGN KEY(idUser) REFERENCES Utilisateur(idUser),
   FOREIGN KEY(idCrit) REFERENCES Critique(idCrit)
);

CREATE TABLE Qualifier(
   idFilm INTEGER,
   codeGenre INTEGER,
   PRIMARY KEY(idFilm, codeGenre),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(codeGenre) REFERENCES Genre(codeGenre)
);

CREATE TABLE Produire(
   idFilm INTEGER,
   codeProd INTEGER,
   PRIMARY KEY(idFilm, codeProd),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(codeProd) REFERENCES Production(codeProd)
);

CREATE TABLE Jouer(
   idFilm INTEGER,
   idPersonalite INTEGER,
   PRIMARY KEY(idFilm, idPersonalite),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(idPersonalite) REFERENCES Personnalite(idPersonalite)
);

CREATE TABLE Realise(
   idFilm INTEGER,
   idPersonalite INTEGER,
   PRIMARY KEY(idFilm, idPersonalite),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(idPersonalite) REFERENCES Personnalite(idPersonalite)
);

CREATE TABLE FilmVisionne(
   idFilm INTEGER,
   idUser INTEGER,
   PRIMARY KEY(idFilm, idUser),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(idUser) REFERENCES Utilisateur(idUser)
);

CREATE TABLE critiqueUtile(
   idUser INTEGER,
   idCrit INTEGER,
   boolCrit BOOLEAN,
   PRIMARY KEY(idUser, idCrit),
   FOREIGN KEY(idUser) REFERENCES Utilisateur(idUser),
   FOREIGN KEY(idCrit) REFERENCES Critique(idCrit)
);