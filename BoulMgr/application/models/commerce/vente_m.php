<?php
class Vente_m extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function liste_ventes() {
        $sql = "SELECT *
                FROM vente
                    NATURAL JOIN vente_comprend_produit
                GROUP BY vente.id_vente
                ORDER BY vente.date_vente DESC;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function liste_produits_pour($id_vente) {
        $sql = "SELECT id_produit, quantite_produit_vente
                FROM vente
                    NATURAL JOIN vente_comprend_produit
                WHERE id_vente = $id_vente";
        $query = $this->db->query($sql);
        return $query->result();

    }

}