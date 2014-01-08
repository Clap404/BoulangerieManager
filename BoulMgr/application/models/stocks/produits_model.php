<?php

class Produits_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function affiche_all() {
        $sql = "SELECT *,
                (prod_ajd - (comm_ajd + vendu_ajd)) as disponibilite_produit
                FROM (
                    SELECT p1.*,
                        ifnull(sum(quantite_produit_produit), 0) as prod_ajd,
                        ifnull(sum(quantite_produit_commande), 0) as comm_ajd,
                        ifnull(sum(quantite_produit_vente), 0) as vendu_ajd
                    FROM produit p1 NATURAL LEFT JOIN
                        produit p2
                            NATURAL LEFT JOIN (
                                SELECT *
                                FROM produit_est_produit
                                WHERE date(date_production) = date('now'))
                            NATURAL LEFT JOIN (
                                SELECT ccp.*
                                FROM commande_contient_produit ccp
                                    NATURAL JOIN commande
                                WHERE date(date_livraison) = date('now'))
                            NATURAL LEFT JOIN (
                                SELECT vcp.*
                                FROM vente_comprend_produit vcp
                                    NATURAL JOIN vente
                                WHERE date(date_vente) = date('now'))
                    GROUP BY p1.id_produit);";


        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function remove_produit($id) {
        $this->db->where("id_produit", $id);
        $this->db->delete("produit");
    }

    function add_produit($donnees) {
        $this->db->insert("produit", $donnees);
    }

    function get_next_id() {
        $this->db->select_max('id_produit');
        $query = $this->db->get('produit');
        return $query->result_array();
    }

    function get_prod_by_id($id) {
        $this->db->where('id_produit', $id);
        $query = $this->db->get('produit');
        return $query->result_array();
    }

    function modif_produit($id, $donnees) {
        $this->db->where("id_produit", $id);
        $this->db->update("produit", $donnees);
    }

    function get_prod_for_select() {
        $this->db->select('id_produit, nom_produit');
        $query = $this->db->get('produit');
        return $query->result_array();
    }

    function add_production($donnees) {
        $this->db->insert('produit_est_produit', $donnees);
    }

    function get_production($id_produit, $date_prod) {
        $this->db->where('id_produit', $id_produit);
        $this->db->where('date_production', $date_prod);
        $query = $this->db->get('produit_est_produit');
        return $query->result_array();
    }

    function update_production($donnees, $qte_base) {
        $nqte = $donnees['quantite_produit_produit'] + $qte_base;

        $this->db->where('id_produit',$donnees['id_produit']);
        $this->db->where('date_production', $donnees['date_production']);
        $this->db->update('produit_est_produit', array('quantite_produit_produit' => $nqte));
    }

    function trending() {
        //retourne les 3 plus gros produits du jour de la semaine
        $sql = "SELECT id_produit, nom_produit, sum(qte) AS vendus
                FROM produit
                    NATURAL JOIN ( SELECT id_produit,
                            date_vente AS date,
                            quantite_produit_vente AS qte
                        FROM vente
                            NATURAL JOIN vente_comprend_produit
                        UNION

                        SELECT id_produit,
                            date_livraison AS date,
                            quantite_produit_commande AS qte
                        FROM commande
                            NATURAL JOIN commande_contient_produit )

                WHERE strftime('%w', date) = strftime('%w', 'now')
                GROUP BY id_produit
                ORDER BY sum(qte) DESC
                LIMIT 3;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function affiche_invendu_ago($ago) {
        $sql = "SELECT id_produit, nom_produit, date('now', '-".$ago." days') as date_invendu,
                (prod_ajd - (comm_ajd + vendu_ajd)) as quantite
                FROM (
                    SELECT p1.*,
                        ifnull(sum(quantite_produit_produit), 0) as prod_ajd,
                        ifnull(sum(quantite_produit_commande), 0) as comm_ajd,
                        ifnull(sum(quantite_produit_vente), 0) as vendu_ajd
                    FROM produit p1 NATURAL LEFT JOIN
                        produit p2
                            NATURAL LEFT JOIN (
                                SELECT *
                                FROM produit_est_produit
                                WHERE date(date_production) = date('now', '-".$ago." days'))
                            NATURAL LEFT JOIN (
                                SELECT ccp.*
                                FROM commande_contient_produit ccp
                                    NATURAL JOIN commande
                                WHERE date(date_livraison) = date('now', '-".$ago." days'))
                            NATURAL LEFT JOIN (
                                SELECT vcp.*
                                FROM vente_comprend_produit vcp
                                    NATURAL JOIN vente
                                WHERE date(date_vente) = date('now', '-".$ago." days'))
                    GROUP BY p1.id_produit)
                    WHERE (prod_ajd - (comm_ajd + vendu_ajd)) > 0;";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function affiche_somme_invendu_ago($ago) {
        $sql = "SELECT date('now', '-".$ago." days') as date_invendu, ifnull(sum(prod_ajd - (comm_ajd + vendu_ajd)),0) as sum_quantite
                FROM (
                    SELECT p1.*,
                        ifnull(sum(quantite_produit_produit), 0) as prod_ajd,
                        ifnull(sum(quantite_produit_commande), 0) as comm_ajd,
                        ifnull(sum(quantite_produit_vente), 0) as vendu_ajd
                    FROM produit p1 NATURAL LEFT JOIN
                        produit p2
                            NATURAL LEFT JOIN (
                                SELECT *
                                FROM produit_est_produit
                                WHERE date(date_production) = date('now', '-".$ago." days'))
                            NATURAL LEFT JOIN (
                                SELECT ccp.*
                                FROM commande_contient_produit ccp
                                    NATURAL JOIN commande
                                WHERE date(date_livraison) = date('now', '-".$ago." days'))
                            NATURAL LEFT JOIN (
                                SELECT vcp.*
                                FROM vente_comprend_produit vcp
                                    NATURAL JOIN vente
                                WHERE date(date_vente) = date('now', '-".$ago." days'))
                    GROUP BY p1.id_produit)
                    WHERE (prod_ajd - (comm_ajd + vendu_ajd)) > 0;";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function somme_vente_produit_annee(){
        $sql= " select nom_produit, sum(total_produit_vente) as somme_produit
                from
                (  select id_produit, nom_produit,
                (quantite_produit_vente * prix_produit) as total_produit_vente
                FROM vente_comprend_produit
                NATURAL JOIN produit
                NATURAL JOIN vente
                where date(date_vente) > '2014-01-01'
                )
                group by id_produit;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function somme_vente_produit_semaine(){
        $date_deb = strtotime("-1 week");
        $date_deb = date('Y/m/d', $date_deb);
        $sql= " select nom_produit, sum(total_produit_vente) as somme_produit
                from
                (  select id_produit, nom_produit,
                (quantite_produit_vente * prix_produit) as total_produit_vente
                FROM vente_comprend_produit
                NATURAL JOIN produit
                NATURAL JOIN vente
                where date_vente > '".$date_deb."'
                )
                group by id_produit;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function historique_vente_produits($year_beg){
        $sql= "select sum(total_produit_vente) as somme_produit, date(date_vente) as jour_vente
                from
                (  select id_produit, nom_produit,
                (quantite_produit_vente * prix_produit) as total_produit_vente, date_vente
                FROM vente_comprend_produit
                NATURAL JOIN produit
                NATURAL JOIN vente
                where date(date_vente) >= '".$year_beg."-01-01'
                AND date(date_vente) <= '".$year_beg."-12-31'
                )
                group by jour_vente
                order by jour_vente;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function total_vente_per_year(){
        $sql= "select sum(total_produit_vente) as somme_produit, strftime('%Y', date_vente) as year_vente
                from
                (  select id_produit, nom_produit,
                (quantite_produit_vente * prix_produit) as total_produit_vente, date_vente
                FROM vente_comprend_produit
                NATURAL JOIN produit
                NATURAL JOIN vente
                )
                group by year_vente
                order by year_vente;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}

?>
