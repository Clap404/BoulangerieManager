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

-- ##### DEFAULT VALUE ##### --

-- Data in table Type_voie --
INSERT INTO Type_voie VALUES(null, "rue");
INSERT INTO Type_voie VALUES(null, "avenue");
INSERT INTO Type_voie VALUES(null, "chemin");
INSERT INTO Type_voie VALUES(null, "boulevard");
INSERT INTO Type_voie VALUES(null, "place");
INSERT INTO Type_voie VALUES(null, "esplanade");
INSERT INTO Type_voie VALUES(null, "impasse");
INSERT INTO Type_voie VALUES(null, "route");
INSERT INTO Type_voie VALUES(null, "allée");
INSERT INTO Type_voie VALUES(null, "square");

-- Data in table Ville --
INSERT INTO Ville VALUES(null,"Paris");
INSERT INTO Ville VALUES(null,"Marseille");
INSERT INTO Ville VALUES(null,"Lyon");
INSERT INTO Ville VALUES(null,"Toulouse");
INSERT INTO Ville VALUES(null,"Nice");
INSERT INTO Ville VALUES(null,"Nantes");
INSERT INTO Ville VALUES(null,"Strasbourg");
INSERT INTO Ville VALUES(null,"Montpellier");
INSERT INTO Ville VALUES(null,"Bordeaux");
INSERT INTO Ville VALUES(null,"Lille");
INSERT INTO Ville VALUES(null,"Rennes");
INSERT INTO Ville VALUES(null,"Reims");
INSERT INTO Ville VALUES(null,"Le Havre");
INSERT INTO Ville VALUES(null,"St Etienne");
INSERT INTO Ville VALUES(null,"Toulon");
INSERT INTO Ville VALUES(null,"Grenoble");
INSERT INTO Ville VALUES(null,"Angers");
INSERT INTO Ville VALUES(null,"Dijon");
INSERT INTO Ville VALUES(null,"Brest");
INSERT INTO Ville VALUES(null,"Le Mans");
INSERT INTO Ville VALUES(null,"Nîmes");
INSERT INTO Ville VALUES(null,"Aix-en-Provence");
INSERT INTO Ville VALUES(null,"Clermont-Ferrant");
INSERT INTO Ville VALUES(null,"Tours");
INSERT INTO Ville VALUES(null,"St Denis");
INSERT INTO Ville VALUES(null,"Limoges");
INSERT INTO Ville VALUES(null,"Villeurbanne");
INSERT INTO Ville VALUES(null,"Amiens");
INSERT INTO Ville VALUES(null,"Besançon");
INSERT INTO Ville VALUES(null,"Metz");
INSERT INTO Ville VALUES(null,"Perpignan");
INSERT INTO Ville VALUES(null,"Orléans");
INSERT INTO Ville VALUES(null,"Caen");
INSERT INTO Ville VALUES(null,"Mulhouse");
INSERT INTO Ville VALUES(null,"Boulogne-Billancourt");
INSERT INTO Ville VALUES(null,"Rouen");
INSERT INTO Ville VALUES(null,"Nancy");
INSERT INTO Ville VALUES(null,"Argenteuil");
INSERT INTO Ville VALUES(null,"Montreuil");
INSERT INTO Ville VALUES(null,"St Paul");
INSERT INTO Ville VALUES(null,"St Denis");
INSERT INTO Ville VALUES(null,"Roubaix");
INSERT INTO Ville VALUES(null,"Avignon");
INSERT INTO Ville VALUES(null,"Turoing");
INSERT INTO Ville VALUES(null,"Fort-de-France(Martinique)");
INSERT INTO Ville VALUES(null,"Poitiers");
INSERT INTO Ville VALUES(null,"Nanterre");
INSERT INTO Ville VALUES(null,"Créteil");
INSERT INTO Ville VALUES(null,"Verseilles");
INSERT INTO Ville VALUES(null,"Pau");
INSERT INTO Ville VALUES(null,"Courbevoie");
INSERT INTO Ville VALUES(null,"Vitry-sur-Seine");
INSERT INTO Ville VALUES(null,"Asnieres-sur-Seine");
INSERT INTO Ville VALUES(null,"Colombes");
INSERT INTO Ville VALUES(null,"Aulnay-sous-Bois");
INSERT INTO Ville VALUES(null,"Rueil-Malmaison");
INSERT INTO Ville VALUES(null,"Antibes");
INSERT INTO Ville VALUES(null,"La Rochelle");
INSERT INTO Ville VALUES(null,"St-Maur-des-Fossés");
INSERT INTO Ville VALUES(null,"Calais");
INSERT INTO Ville VALUES(null,"Champigny-sur-Marne");
INSERT INTO Ville VALUES(null,"St Pierre");
INSERT INTO Ville VALUES(null,"Aubervilliers");
INSERT INTO Ville VALUES(null,"Béziers");
INSERT INTO Ville VALUES(null,"Bourges");
INSERT INTO Ville VALUES(null,"Cannnes");
INSERT INTO Ville VALUES(null,"St Nazaire");
INSERT INTO Ville VALUES(null,"Dunkerque");
INSERT INTO Ville VALUES(null,"Quimper");
INSERT INTO Ville VALUES(null,"Valence");
INSERT INTO Ville VALUES(null,"Colmar");
INSERT INTO Ville VALUES(null,"Drancy");
INSERT INTO Ville VALUES(null,"Mérignac");
INSERT INTO Ville VALUES(null,"Ajaccio");
INSERT INTO Ville VALUES(null,"Levallois-Perret");
INSERT INTO Ville VALUES(null,"Troyes");
INSERT INTO Ville VALUES(null,"Les Abymes");
INSERT INTO Ville VALUES(null,"Neuilly-sur-Seine");
INSERT INTO Ville VALUES(null,"Issy-Les-Moulineaux");
INSERT INTO Ville VALUES(null,"Villeneuve-d'Ascq");
INSERT INTO Ville VALUES(null,"Noisy-Le-Grand");
INSERT INTO Ville VALUES(null,"Antony");
INSERT INTO Ville VALUES(null,"Niort");
INSERT INTO Ville VALUES(null,"Lorient");
INSERT INTO Ville VALUES(null,"La Seyne sur mer");
INSERT INTO Ville VALUES(null,"Chambery");
INSERT INTO Ville VALUES(null,"Cayenne(Guyane)");
INSERT INTO Ville VALUES(null,"St Quentin");
INSERT INTO Ville VALUES(null,"Pessac");
INSERT INTO Ville VALUES(null,"Sarcelles");
INSERT INTO Ville VALUES(null,"Cergy");
INSERT INTO Ville VALUES(null,"Clichy");
INSERT INTO Ville VALUES(null,"Beauvais");
INSERT INTO Ville VALUES(null,"Cholet	");
INSERT INTO Ville VALUES(null,"Hyrès");
INSERT INTO Ville VALUES(null,"Vénissieux");
INSERT INTO Ville VALUES(null,"Ivry-sur-Seine");
INSERT INTO Ville VALUES(null,"Montauban");
INSERT INTO Ville VALUES(null,"Vannes");
INSERT INTO Ville VALUES(null,"Charleville-Mézières");
INSERT INTO Ville VALUES(null,"Pantin");
INSERT INTO Ville VALUES(null,"Laval");
INSERT INTO Ville VALUES(null,"Maisons-Alfort");
INSERT INTO Ville VALUES(null,"Bondy");
INSERT INTO Ville VALUES(null,"Evry");
INSERT INTO Ville VALUES(null,"Evreux");
INSERT INTO Ville VALUES(null,"Arles");
INSERT INTO Ville VALUES(null,"Annecy");
INSERT INTO Ville VALUES(null,"Fréjus");
INSERT INTO Ville VALUES(null,"Fontenay-sous-Bois");
INSERT INTO Ville VALUES(null,"Saint-André(Réunion)");
INSERT INTO Ville VALUES(null,"Sartouville");
INSERT INTO Ville VALUES(null,"Narbonne");
INSERT INTO Ville VALUES(null,"Epinay-sur-Seine");
INSERT INTO Ville VALUES(null,"Belfort");
INSERT INTO Ville VALUES(null,"Brive-la-Gaillarde");
INSERT INTO Ville VALUES(null,"Sevran");
INSERT INTO Ville VALUES(null,"Saint-Malo");
INSERT INTO Ville VALUES(null,"Albi");
INSERT INTO Ville VALUES(null,"Clamart");
INSERT INTO Ville VALUES(null,"Blois");
INSERT INTO Ville VALUES(null,"Meaux");
INSERT INTO Ville VALUES(null,"Villejuif");
INSERT INTO Ville VALUES(null,"Saint-Louis(Réunion)");
INSERT INTO Ville VALUES(null,"Grasse");
INSERT INTO Ville VALUES(null,"Chateauroux");
INSERT INTO Ville VALUES(null,"La");
INSERT INTO Ville VALUES(null,"Chelles");
INSERT INTO Ville VALUES(null,"Cagnes-sur-Mer");
INSERT INTO Ville VALUES(null,"Le Tampon");
INSERT INTO Ville VALUES(null,"Saint-Brieuc");
INSERT INTO Ville VALUES(null,"Chalon-sur-Saône");
INSERT INTO Ville VALUES(null,"Carcassonne");
INSERT INTO Ville VALUES(null,"Bobigny");
INSERT INTO Ville VALUES(null,"Vincennes");
INSERT INTO Ville VALUES(null,"Chalons-en-Champagne");
INSERT INTO Ville VALUES(null,"Martigues");
INSERT INTO Ville VALUES(null,"Le Blanc-Mesnil");
INSERT INTO Ville VALUES(null,"Tarbes");
INSERT INTO Ville VALUES(null,"Bayonne");
INSERT INTO Ville VALUES(null,"Meudon");
INSERT INTO Ville VALUES(null,"Montrouge");
INSERT INTO Ville VALUES(null,"Angouleme");
INSERT INTO Ville VALUES(null,"Aubagne");
INSERT INTO Ville VALUES(null,"Boulogne-sur-Mer");
INSERT INTO Ville VALUES(null,"Castres");
INSERT INTO Ville VALUES(null,"Génnevilliers");
INSERT INTO Ville VALUES(null,"Saint-Herblain");
INSERT INTO Ville VALUES(null,"Suresnes");
INSERT INTO Ville VALUES(null,"Bastia");
INSERT INTO Ville VALUES(null,"Douai");
INSERT INTO Ville VALUES(null,"Compiègne");
INSERT INTO Ville VALUES(null,"Sète");
INSERT INTO Ville VALUES(null,"Arras");
INSERT INTO Ville VALUES(null,"Valenciennes");
INSERT INTO Ville VALUES(null,"Saint-Ouen");
INSERT INTO Ville VALUES(null,"Puteaux");
INSERT INTO Ville VALUES(null,"Wattrelos");
INSERT INTO Ville VALUES(null,"Istres");
INSERT INTO Ville VALUES(null,"Saint-Germain-en-Laye");
INSERT INTO Ville VALUES(null,"Alfortville");
INSERT INTO Ville VALUES(null,"Mantes-la-Jolie");
INSERT INTO Ville VALUES(null,"Bourg-en-Bresse");
INSERT INTO Ville VALUES(null,"Cherbourg");
INSERT INTO Ville VALUES(null,"Talence");
INSERT INTO Ville VALUES(null,"Le Cannet");
INSERT INTO Ville VALUES(null,"Thionville");
INSERT INTO Ville VALUES(null,"Caluire-et-Cuire");
INSERT INTO Ville VALUES(null,"Livry-Garan");
INSERT INTO Ville VALUES(null,"Corbeil-Essonnes");
INSERT INTO Ville VALUES(null,"Chartes");
INSERT INTO Ville VALUES(null,"Rosny-sous-Bois");
INSERT INTO Ville VALUES(null,"Montluçon");
INSERT INTO Ville VALUES(null,"Saint-Priest");
INSERT INTO Ville VALUES(null,"Arès");
INSERT INTO Ville VALUES(null,"Salon-de-Provence");
INSERT INTO Ville VALUES(null,"Vaulx-en-Velin");
INSERT INTO Ville VALUES(null,"Massy");
INSERT INTO Ville VALUES(null,"Nevers");
INSERT INTO Ville VALUES(null,"Garges-lès-Gonesse");
INSERT INTO Ville VALUES(null,"Auxerre");
INSERT INTO Ville VALUES(null,"Marcq-en-Baroeuf");
INSERT INTO Ville VALUES(null,"Bron");
INSERT INTO Ville VALUES(null,"Bagneux");
INSERT INTO Ville VALUES(null,"Gap");
INSERT INTO Ville VALUES(null,"Anglet");
INSERT INTO Ville VALUES(null,"Noisy-le-Sec");
INSERT INTO Ville VALUES(null,"Melun");
INSERT INTO Ville VALUES(null,"Rezé");
INSERT INTO Ville VALUES(null,"Draguignan");
INSERT INTO Ville VALUES(null,"Le Port");
INSERT INTO Ville VALUES(null,"Roanne");
INSERT INTO Ville VALUES(null,"Vitrolles");
INSERT INTO Ville VALUES(null,"Savigny-sur-Orge");
INSERT INTO Ville VALUES(null,"La Courneuve");
INSERT INTO Ville VALUES(null,"Jouè-lès-Tours");
INSERT INTO Ville VALUES(null,"Choisy-le-Roi");
INSERT INTO Ville VALUES(null,"Saint-Chamond");
INSERT INTO Ville VALUES(null,"Poissy");
