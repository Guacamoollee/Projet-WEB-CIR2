#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
DROP TABLE IF EXISTS est_inscrit;
DROP TABLE IF EXISTS factures;
DROP TABLE IF EXISTS trajets;
DROP TABLE IF EXISTS isen;

DROP TABLE IF EXISTS utilisateurs;

#------------------------------------------------------------
# Table: utilisateurs
#------------------------------------------------------------

CREATE TABLE utilisateurs(
        pseudo          Varchar (50) NOT NULL ,
        nom_utilisateur Varchar (50) NOT NULL ,
        telephone       Int NOT NULL ,
        hash_mdp        Varchar (200) NOT NULL
	,CONSTRAINT utilisateurs_PK PRIMARY KEY (pseudo)
)ENGINE=InnoDB;

INSERT INTO utilisateurs(pseudo,nom_utilisateur,telephone,hash_mdp) VALUES ('PereNoelDu29','Jean Michelle',0836656565,'123');
INSERT INTO utilisateurs(pseudo,nom_utilisateur,telephone,hash_mdp) VALUES ('PierrePaul','Pierre Le Caillou',0102030405,'123');
INSERT INTO utilisateurs(pseudo,nom_utilisateur,telephone,hash_mdp) VALUES ('JeanDupont','Jean Dupont',0987654321,'123');
INSERT INTO utilisateurs(pseudo,nom_utilisateur,telephone,hash_mdp) VALUES ('SamSam','Samuel Elard',0993377606,'123');





#------------------------------------------------------------
# Table: isen
#------------------------------------------------------------

DROP TABLE IF EXISTS isen;
CREATE TABLE isen(
        site_isen  Char (50) NOT NULL ,
        code_insee Int NOT NULL
	,CONSTRAINT isen_PK PRIMARY KEY (site_isen)

	,CONSTRAINT isen_ville_FK FOREIGN KEY (code_insee) REFERENCES ville(code_insee)
)ENGINE=InnoDB;

INSERT INTO isen(site_isen,code_insee) VALUES ('ISEN Brest',29019);
INSERT INTO isen(site_isen,code_insee) VALUES ('ISEN Nantes',44109);
INSERT INTO isen(site_isen,code_insee) VALUES ('ISEN Rennes',35238);
INSERT INTO isen(site_isen,code_insee) VALUES ('ISEN Caen',14118);

#------------------------------------------------------------
# Table: trajets
#------------------------------------------------------------

CREATE TABLE trajets(
        id_trajet           Int  Auto_increment  NOT NULL ,
        date_heure_depart   Datetime NOT NULL ,
        date_heure_arrivee  Datetime NOT NULL ,
        nb_places_max       Int NOT NULL ,
        nb_places_restantes Int NOT NULL ,
        prix                Float NOT NULL ,
        adresse             Varchar (200) ,
        depart_isen         Bool NOT NULL ,
        code_insee          Int NOT NULL ,
        site_isen           Char (50) NOT NULL ,
        pseudo              Varchar (50) NOT NULL
	,CONSTRAINT trajets_PK PRIMARY KEY (id_trajet)

	,CONSTRAINT trajets_ville_FK FOREIGN KEY (code_insee) REFERENCES ville(code_insee)
	,CONSTRAINT trajets_isen0_FK FOREIGN KEY (site_isen) REFERENCES isen(site_isen)
	,CONSTRAINT trajets_utilisateurs1_FK FOREIGN KEY (pseudo) REFERENCES utilisateurs(pseudo)
)ENGINE=InnoDB;

INSERT INTO trajets(date_heure_depart,date_heure_arrivee,nb_places_max,nb_places_restantes,prix,adresse,depart_isen,code_insee,site_isen,pseudo) VALUES ('2020-01-07 17:00:00','2020-01-07 18:00:00',3,3,5,'Rue de la Grange Dimière, 72260 Monhoudou',1,72202,'ISEN Brest','PierrePaul');
INSERT INTO trajets(date_heure_depart,date_heure_arrivee,nb_places_max,nb_places_restantes,prix,adresse,depart_isen,code_insee,site_isen,pseudo) VALUES ('2020-01-09 17:00:00','2020-01-09 18:00:00',3,3,5,'Rue de la Grange Dimière, 72260 Monhoudou',0,72202,'ISEN Brest','PierrePaul');


#------------------------------------------------------------
# Table: factures
#------------------------------------------------------------

CREATE TABLE factures(
        id_trajet  Int NOT NULL ,
        id_facture Int NOT NULL ,
        paye       Bool NOT NULL ,
        pseudo     Varchar (50) NOT NULL
	,CONSTRAINT factures_PK PRIMARY KEY (id_trajet,id_facture)

	,CONSTRAINT factures_trajets_FK FOREIGN KEY (id_trajet) REFERENCES trajets(id_trajet)
	,CONSTRAINT factures_utilisateurs0_FK FOREIGN KEY (pseudo) REFERENCES utilisateurs(pseudo)
)ENGINE=InnoDB;

INSERT INTO factures(id_trajet,id_facture,paye,pseudo) VALUES (1,1,1,'SamSam');


#------------------------------------------------------------
# Table: est_inscrit
#------------------------------------------------------------

CREATE TABLE est_inscrit(
        id_trajet   Int NOT NULL ,
        pseudo      Varchar (50) NOT NULL ,
        nb_inscrits Int NOT NULL
	,CONSTRAINT est_inscrit_PK PRIMARY KEY (id_trajet,pseudo)

	,CONSTRAINT est_inscrit_trajets_FK FOREIGN KEY (id_trajet) REFERENCES trajets(id_trajet)
	,CONSTRAINT est_inscrit_utilisateurs0_FK FOREIGN KEY (pseudo) REFERENCES utilisateurs(pseudo)
)ENGINE=InnoDB;

INSERT INTO est_inscrit(id_trajet,pseudo,nb_inscrits) VALUES (1,'SamSam',1);
