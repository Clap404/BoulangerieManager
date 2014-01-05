/*
    Les tables ayant des valeurs de test sont marquées par "OK" et
    ne sont pas indentées.
*/

drop table if exists telephone; /* OK */
drop table if exists adresse; /* OK */
drop table if exists produit; /* OK */
    drop table if exists commande;
    drop table if exists commande_matiere_premiere;
drop table if exists client; /* OK */
drop table if exists fournisseur; /* OK */
    drop table if exists categorie;
drop table if exists matiere_premiere; /* OK */
drop table if exists ville; /* OK */
drop table if exists vente; /* OK */
drop table if exists unite; /* OK */
drop table if exists type_voie; /* OK */
drop table if exists fournisseur_joignable_telephone; /* OK */
    drop table if exists produit_est_compose_de_matiere_premiere;
drop table if exists matiere_premiere_vendue_par_fournisseur; /* OK */
    drop table if exists produit_a_pour_categorie;
    drop table if exists commande_contient_produit;
drop table if exists client_joignable_telephone; /* OK */
drop table if exists fournisseur_livre_depuis_adresse; /* OK */
drop table if exists client_habite_adresse; /* OK */
    drop table if exists produit_est_produit;
drop table if exists vente_comprend_produit; /* OK */


create table telephone(
    id_telephone
        integer primary key autoincrement not null,
    /* A AJOUTER DANS LE MCD OU SUPPRIMER */
    numero_telephone
        text not null,
    description_telephone
        text
);

create table adresse(
    id_adresse
        integer primary key autoincrement not null,
    numero_voie_adresse
        integer not null,
    nom_voie_adresse
        text not null,

    /* A AJOUTER DANS LE MCD OU SUPPRIMER */
    description_adresse
        text,


    id_ville
        integer not null
        references ville(id_ville)
        on delete cascade on update cascade,
    id_type_voie
        integer not null
        references type_voie(id_type_voie)
        on delete cascade on update cascade
);

create table produit(
    id_produit
        integer primary key autoincrement not null,
    nom_produit
        text not null,
    prix_produit
        real not null,
    temps_preparation_produit
        integer not null
);

create table commande(
    id_commande
        integer primary key autoincrement not null,
    /* A AJOUTER DANS LE MCD OU SUPPRIMER */
    prix_total
        real
        default 0,
    date_commande
        text not null,
    date_livraison
        text,
    id_client
        integer not null
        references client(id_client)
        on delete cascade on update cascade,
    id_adresse
        text not null
        references adresse(id_adresse)
        on delete cascade on update cascade
);

/* TABLE A AJOUTER DANS LE MCD */
create table commande_matiere_premiere(
    id_commande_matiere_premiere
        integer primary key autoincrement not null,
    date_commande_matiere_premiere
        text not null,
    quantite_matiere_premiere
        real not null,
    prix_unite_matiere_premiere
        real not null,
    id_matiere_premiere
        integer not null
        references matiere_premiere(id_matiere_premiere)
        on delete cascade on update cascade,
    id_fournisseur
        integer not null
        references fournisseur(id_fournisseur)
        on delete cascade on update cascade
);

create table client(
    id_client
        integer primary key autoincrement not null,
    nom_client
        text not null,
    prenom_client
        text not null
);

create table fournisseur(
    id_fournisseur
        integer primary key autoincrement not null,
    nom_fournisseur
        text not null
);

create table categorie(
    id_categorie
        integer primary key autoincrement not null,
    nom_categorie
        text not null
);

create table matiere_premiere(
    id_matiere_premiere
        integer primary key autoincrement not null,
    nom_matiere_premiere
        text not null,
    id_unite
        integer not null
        references unite(id_unite)
);

create table ville(
    id_ville
        integer primary key autoincrement not null,
    nom_ville
        text not null,
    code_postal
        integer not null
);

create table vente(
    id_vente
        integer primary key autoincrement not null,
    date_vente
        text not null,
    /* A AJOUTER DANS LE MCD OU SUPPRIMER */
    prix_vente
        real
        default 0,
    id_client
        integer
        default null
        references client(id_client)
);

create table unite(
    id_unite
        integer primary key autoincrement not null,
    nom_unite
        text not null,
    /* A AJOUTER DANS LE MCD OU SUPPRIMER */
    abbreviation_unite
        text not null
);

create table type_voie(
    id_type_voie
        integer primary key autoincrement not null,
    nom_type_voie
        text not null
);

create table fournisseur_joignable_telephone(
    id_fournisseur
        integer not null
        references fournisseur(id_fournisseur),
    id_telephone
        integer not null
        references telephone(id_telephone),
    primary key (id_fournisseur, id_telephone)
);

create table produit_est_compose_de_matiere_premiere(
    id_matiere_premiere
        integer not null
        references matiere_premiere(id_matiere_premiere),
    id_produit
        integer not null
        references produit(id_produit),
    quantite_matiere_premiere_produit
        real not null,
    primary key (id_matiere_premiere, id_produit)
);

create table matiere_premiere_vendue_par_fournisseur(
    id_matiere_premiere
        integer not null
        references matiere_premiere(id_matiere_premiere),
    id_fournisseur
        integer not null
        references fournisseur(id_fournisseur),
    prix
        real not null,
    primary key (id_matiere_premiere, id_fournisseur)
);

create table produit_a_pour_categorie(
    id_categorie
        integer not null
        references categorie(id_categorie),
    id_produit
        integer not null
        references produit(id_produit),
    primary key (id_produit, id_categorie)
);

create table commande_contient_produit(
    id_commande
        integer not null
        references commande(id_commande),
    id_produit
        integer not null
        references produit(id_produit),
    quantite_produit_commande
        integer not null,
    primary key (id_commande,id_produit)
);

create table client_joignable_telephone(
    id_client
        integer not null
        references client(id_client),
    id_telephone
        integer not null
        references telephone(id_telephone),
    primary key (id_client,id_telephone)
);

create table fournisseur_livre_depuis_adresse(
    id_fournisseur
        integer not null
        references fournisseur(id_fournisseur),
    id_adresse
        integer not null
        references adresse(id_adresse),
    primary key (id_fournisseur,id_adresse)
);

create table client_habite_adresse(
    id_client
        integer not null
        references client(id_client),
    id_adresse
        integer not null
        references adresse(id_adresse),
    primary key (id_client,id_adresse)
);

create table produit_est_produit(
    id_produit
        integer not null
        references produit(id_produit),
    date_production
        text not null,
    quantite_produit_produit
        integer not null,
    primary key (id_produit, date_production)
);

create table vente_comprend_produit(
    id_produit
        integer not null
        references produit(id_produit),
    id_vente
        integer not null
        references vente(id_vente),
    /* A AJOUTER DANS LE MCD OU SUPPRIMER */
    quantite_produit_vente
        integer not null,
    primary key (id_produit,id_vente)
);

--- TRIGGERS ---

-- Update du prix d'une vente quand on lui ajoute / supprime / modifie un produit associé
create trigger insertVentePrix
    after insert
    on vente_comprend_produit
begin
    update vente
    set prix_vente = (
        select sum(prix_produit * quantite_produit_vente)
        from vente_comprend_produit
            natural join produit
        where id_vente = new.id_vente
    )
    where id_vente = new.id_vente;
end;


create trigger updateVentePrix
    after update
    on vente_comprend_produit
begin
    update vente
    set prix_vente = (
        select sum(prix_produit * quantite_produit_vente)
        from vente_comprend_produit
            natural join produit
        where id_vente = old.id_vente
    )
    where id_vente = old.id_vente;
end;


create trigger deleteVentePrix
    after delete
    on vente_comprend_produit
begin
    update vente
    set prix_vente = (
        select sum(prix_produit * quantite_produit_vente)
        from vente_comprend_produit
            natural join produit
        where id_vente = old.id_vente
    )
    where id_vente = old.id_vente;
end;

-- Update du prix d'une commande quand on lui ajoute / supprime / modifie un produit associé

create trigger insertCommandePrix
    after insert
    on commande_contient_produit
begin
    update commande
    set prix_total = (
        select sum(prix_produit * quantite_produit_commande)
        from commande_contient_produit
            natural join produit
        where id_commande = new.id_commande
    )
    where id_commande = new.id_commande;
end;


create trigger updateCommandePrix
    after update
    on commande_contient_produit
begin
    update commande
    set prix_total = (
        select sum(prix_produit * quantite_produit_commande)
        from commande_contient_produit
            natural join produit
        where id_commande = old.id_commande
    )
    where id_commande = old.id_commande;
end;


create trigger deleteCommandePrix
    after delete
    on commande_contient_produit
begin
    update commande
    set prix_total = (
        select sum(prix_produit * quantite_produit_commande)
        from commande_contient_produit
            natural join produit
        where id_commande = old.id_commande
    )
    where id_commande = old.id_commande;
end;

