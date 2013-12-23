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

    function delete_vente($id) {
        $sql = "DELETE FROM vente_comprend_produit
                WHERE id_vente = $id";
        $this->db->query($sql);
        $sql = "DELETE FROM vente WHERE id_vente = $id";
        $this->db->query($sql);
        return 1;
    }

    function ajoute_vente($id, $prods) {
        /*
         * BUG :
         * Nouvelle vente
         * ajoute 1 croissant et 1 pain au chocolat
         * Modifier
         * enleve 1 croissant
         * -> prix : 0.0 et les produits sont pas supprimés
         */
        if (count($prods) === 0) {
            return $this->delete_vente($id);
        }

        $this->db->trans_start();
        if ($id === 'null') {
            $newId = '(SELECT MAX(id_vente) from vente)';
        } else {
            $newId = $id;
            $sql = "DELETE FROM vente_comprend_produit
                    WHERE id_vente = $id;";
            $this->db->query($sql);
        }
        
        $sql = "INSERT OR REPLACE INTO vente VALUES ($id, datetime('now'), 0, null);";
        $this->db->query($sql);
        foreach($prods as $prod) {
            if ($prod->quantite !== "0" || $prod->quantite !== 0) {
                $sql ="INSERT INTO vente_comprend_produit
                    VALUES ($prod->id, $newId, $prod->quantite);";
                $this->db->query($sql);
            }
        }

        $res = $this->db->trans_status();
        $this->db->trans_complete();
        return $res;
    }

}
