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
                    NATURAL LEFT JOIN vente_comprend_produit
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

    function delete_vente($id) {
        $sql = "DELETE FROM vente_comprend_produit
                WHERE id_vente = $id";
        $this->db->query($sql);
        $sql = "DELETE FROM vente WHERE id_vente = $id";
        $this->db->query($sql);
    }

    function modif_vente($id_vente, $prods) {
        $sql = "DELETE FROM vente_comprend_produit
                WHERE id_vente = $id_vente";

        $this->db->query($sql);
        foreach($prods as $prod) {
            if ($prod->quantite !== "0" || $prod->quantite !== 0) {
                $sql ="INSERT INTO vente_comprend_produit
                    VALUES ($prod->id, $id_vente, $prod->quantite);";
                $this->db->query($sql);
            }
        }
    }

    function ajoute_vente($prods) {
        $sql = "INSERT INTO vente VALUES (null, datetime('now'), 0, null);";
        $this->db->query($sql);
        $newId = $this->db->insert_id();
        foreach($prods as $prod) {
            if ($prod->quantite !== "0" || $prod->quantite !== 0) {
                $sql ="INSERT INTO vente_comprend_produit
                    VALUES ($prod->id, $newId, $prod->quantite);";
                $this->db->query($sql);
            }
        }
    }
}
