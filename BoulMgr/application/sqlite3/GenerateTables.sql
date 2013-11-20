-- Create tables, remove them if they already exist --

-- ##### DROP TABLES ##### --

DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Adresse;
DROP TABLE IF EXISTS Ville;
DROP TABLE IF EXISTS Type_voie;
DROP TABLE IF EXISTS Commande;
DROP TABLE IF EXISTS Fournisseur;
DROP TABLE IF EXISTS Matiere_premiere;
DROP TABLE IF EXISTS Produit;
DROP TABLE IF EXISTS Categorie;
DROP TABLE IF EXISTS Telephone;
DROP TABLE IF EXISTS Vendu_par;
DROP TABLE IF EXISTS A_un;
DROP TABLE IF EXISTS Dispose;
DROP TABLE IF EXISTS A_une;
DROP TABLE IF EXISTS Contient;
DROP TABLE IF EXISTS Passe_une;
DROP TABLE IF EXISTS Au;
DROP TABLE IF EXISTS Livre_depuis;
DROP TABLE IF EXISTS Est_compose_de;
DROP TABLE IF EXISTS A_pour_categorie;
DROP TABLE IF EXISTS Est_livree_le;
DROP TABLE IF EXISTS Est_passee_le;
DROP TABLE IF EXISTS Perte;

-- ##### MAIN TABLES ##### -- 

-- Client --
CREATE TABLE Client(
    id_client INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nom_client TEXT,
    prenom_client TEXT
);

-- Adresse -- 
CREATE TABLE Adresse(
    id_adresse INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    num_voie NUMBER,
    id_type_voie INTEGER,
    nom_voie TEXT,
    code_postal NUMBER, 
    id_ville INTEGER
);

-- Ville -- 
CREATE TABLE Ville(
    id_ville INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nom_ville TEXT
);

-- Type_voie --
CREATE TABLE Type_voie(
    id_type_voie INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    lib_type_voie TEXT
);

-- Commande -- 
CREATE TABLE Commande(
    id_commande INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    prix_total_commande NUMBER
);

-- Fournisseur -- 
CREATE TABLE Fournisseur(
    id_fournisseur INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nom_fournisseur TEXT
);

-- Matières Premières -- 
CREATE TABLE Matiere_premiere(
    id_matiere_premiere INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nom_matiere_premiere TEXT,
    disponibilite_matiere_premiere NUMBER
);

-- Produit --
CREATE TABLE Produit(
    id_produit INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nom_produit TEXT,
    prix_unitaire NUMBER,
    disponibilite_produit NUMBER,
    temps_preparation_produit NUMBER
);

-- Categorie --
CREATE TABLE Categorie(
    id_categorie INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    lib_categorie TEXT
);

-- Telephone --
CREATE TABLE Telephone(
    id_telephone INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    numero_telephone TEXT
);

-- ##### RELATION TABLES ##### --

-- Vendu_par (Fournisseur, Matiere_premiere) --
CREATE TABLE Vendu_par(
    id_matiere_premiere INTEGER,
    id_fournisseur INTEGER,
    prix NUMBER,
    PRIMARY KEY(id_matiere_premiere, id_fournisseur),
    FOREIGN KEY(id_matiere_premiere) REFERENCES Matiere_premiere(id_matiere_premiere),
    FOREIGN KEY(id_fournisseur) REFERENCES Fournisseur(id_fournisseur)
);

-- A_un (Fournisseur, Telephone) --
CREATE TABLE A_un(
    id_fournisseur INTEGER,
    id_telephone INTEGER,
    PRIMARY KEY(id_fournisseur, id_telephone),
    FOREIGN KEY(id_fournisseur) REFERENCES Fournisseur(id_fournisseur),
    FOREIGN KEY(id_telephone) REFERENCES Telephone(id_telephone)
);

-- Dispose (Client, Telephone) --
CREATE TABLE Dispose(
    id_client INTEGER,
    id_telephone INTEGER,
    PRIMARY KEY(id_client, id_telephone),
    FOREIGN KEY(id_client) REFERENCES Client(id_client),
    FOREIGN KEY(id_telephone) REFERENCES Telephone(id_telephone)
);

-- A_une (Client, Adresse) --
CREATE TABLE A_une(
    id_client INTEGER,
    id_adresse INTEGER,
    PRIMARY KEY(id_client, id_adresse),
    FOREIGN KEY(id_client) REFERENCES Client(id_client),
    FOREIGN KEY(id_adresse) REFERENCES Adresse(id_adresse)
);

-- Passe_une (Client, Commande) --
CREATE TABLE Passe_une(
    id_client INTEGER,
    id_commande INTEGER,
    PRIMARY KEY(id_client, id_commande),
    FOREIGN KEY(id_client) REFERENCES Client(id_client),
    FOREIGN KEY(id_commande) REFERENCES Commande(id_commande)
);

-- Au (Commande, Adresse) --
CREATE TABLE Au(
    id_commande INTEGER,
    id_adresse INTEGER,
    PRIMARY KEY(id_commande, id_adresse),
    FOREIGN KEY(id_commande) REFERENCES Commande(id_commande),
    FOREIGN KEY(id_adresse) REFERENCES Adresse(id_adresse)
);

-- Livre_depuis (Fournisseur, Adresse) --
CREATE TABLE Livre_depuis(
    id_fournisseur INTEGER,
    id_adresse INTEGER,
    PRIMARY KEY(id_fournisseur, id_adresse),
    FOREIGN KEY(id_fournisseur) REFERENCES Fournisseur(id_fournisseur),
    FOREIGN KEY(id_adresse) REFERENCES Adresse(id_adresse)
);

-- Est_compose_de (Produit, Matiere_premiere) --
CREATE TABLE Est_compose_de(
    id_produit INTEGER,
    id_matiere_premiere INTEGER,
    PRIMARY KEY(id_produit, id_matiere_premiere),
    FOREIGN KEY(id_produit) REFERENCES Produit(id_produit),
    FOREIGN KEY(id_matiere_premiere) REFERENCES Matiere_premiere(id_matiere_premiere)
);

-- Contient (Commande, Produit)
CREATE TABLE Contient(
    id_commande INTEGER,
    id_produit INTEGER,
    PRIMARY KEY(id_commande, id_produit),
    FOREIGN KEY(id_commande) REFERENCES Commande(id_commande),
    FOREIGN KEY(id_produit) REFERENCES Produit(id_produit)
);

-- A_pour_categorie (Produit, Categorie)
CREATE TABLE A_pour_categorie(
    id_produit INTEGER,
    id_categorie INTEGER,
    PRIMARY KEY(id_produit, id_categorie),
    FOREIGN KEY(id_produit) REFERENCES Produit(id_produit),
    FOREIGN KEY(id_categorie) REFERENCES Categorie(id_categorie)
);

-- Est_livree_le (Commande, date)
CREATE TABLE Est_livree_le(
    id_commande INTEGER,
    date_livraison TEXT,
    PRIMARY KEY(id_commande, date_livraison)
);

-- Est_passe_le (Commande, date)
CREATE TABLE Est_passee_le(
    id_commande INTEGER,
    date_enregistrement TEXT,
    PRIMARY KEY(id_commande, date_enregistrement)
);

-- Perte (Produit, date)
CREATE TABLE Perte(
    id_produit INTEGER,
    date_perte TEXT,
    PRIMARY KEY(id_produit, date_perte)
);
