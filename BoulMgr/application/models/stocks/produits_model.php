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
                                WHERE date_production
                                    BETWEEN date('now') AND date('now', '+1 day'))
                            NATURAL LEFT JOIN (
                                SELECT ccp.*
                                FROM commande_contient_produit ccp
                                    NATURAL JOIN commande
                                WHERE date_livraison
                                    BETWEEN date('now') AND date('now', '+1 day'))
                            NATURAL LEFT JOIN (
                                SELECT vcp.*
                                FROM vente_comprend_produit vcp
                                    NATURAL JOIN vente
                                WHERE date_vente
                                    BETWEEN date('now') AND date('now', '+1 day'))
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
}

?>
