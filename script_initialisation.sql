CREATE TABLE Film(
   idFilm SERIAL,
   dateSortie DATE,
   boxOffice BIGINT,
   dureeMinutesFilm SMALLINT,
   voFilm CHAR(2),
   PRIMARY KEY(idFilm)
);

CREATE TABLE Genre(
   codeGenre CHAR(8),
   nomGenre VARCHAR(50),
   PRIMARY KEY(codeGenre)
);

CREATE TABLE Personnalite(
   idPersonalite SERIAL,
   nomPerso VARCHAR(100),
   prenomPerso VARCHAR(100),
   dateNaissance VARCHAR(50),
   nationalitePerso VARCHAR(50),
   PRIMARY KEY(idPersonalite)
);

CREATE TABLE Production(
   codeProd CHAR(8),
   nomProd VARCHAR(100),
   nationaliteProd VARCHAR(60),
   PRIMARY KEY(codeProd)
);

CREATE TABLE Utilisateur(
   idUser SERIAL,
   imageProfil TEXT,
   sexeUser CHAR(1),
   isAdmin BOOLEAN,
   mailUser VARCHAR(320),
   motDePasse VARCHAR(64),
   pseudoUser VARCHAR(32),
   PRIMARY KEY(idUser)
);

CREATE TABLE Critique(
   idCrit SERIAL,
   noteCrit SMALLINT,
   texteCrit TEXT,
   idFilm SERIAL NOT NULL,
   idUser SERIAL NOT NULL,
   PRIMARY KEY(idCrit),
   UNIQUE(idFilm),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(idUser) REFERENCES Utilisateur(idUser)
);

CREATE TABLE Commentaire(
   idCom SERIAL,
   texteCom TEXT,
   dateCom TIMESTAMP,
   idUser SERIAL NOT NULL,
   idCrit SERIAL NOT NULL,
   PRIMARY KEY(idCom),
   FOREIGN KEY(idUser) REFERENCES Utilisateur(idUser),
   FOREIGN KEY(idCrit) REFERENCES Critique(idCrit)
);

CREATE TABLE Qualifier(
   idFilm SERIAL,
   codeGenre CHAR(8),
   PRIMARY KEY(idFilm, codeGenre),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(codeGenre) REFERENCES Genre(codeGenre)
);

CREATE TABLE Produire(
   idFilm SERIAL,
   codeProd CHAR(8),
   PRIMARY KEY(idFilm, codeProd),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(codeProd) REFERENCES Production(codeProd)
);

CREATE TABLE Jouer(
   idFilm SERIAL,
   idPersonalite SERIAL,
   PRIMARY KEY(idFilm, idPersonalite),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(idPersonalite) REFERENCES Personnalite(idPersonalite)
);

CREATE TABLE Realise(
   idFilm SERIAL,
   idPersonalite SERIAL,
   PRIMARY KEY(idFilm, idPersonalite),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(idPersonalite) REFERENCES Personnalite(idPersonalite)
);

CREATE TABLE FilmVisionne(
   idFilm SERIAL,
   idUser SERIAL,
   PRIMARY KEY(idFilm, idUser),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(idUser) REFERENCES Utilisateur(idUser)
);

CREATE TABLE critiqueUtile(
   idUser SERIAL,
   idCrit SERIAL,
   boolCrit BOOLEAN,
   PRIMARY KEY(idUser, idCrit),
   FOREIGN KEY(idUser) REFERENCES Utilisateur(idUser),
   FOREIGN KEY(idCrit) REFERENCES Critique(idCrit)
);
