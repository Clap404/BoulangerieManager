<?php
class Commande_m extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function liste_commandes() {
        $sql = "SELECT *,
                    (case
                        when date(date_livraison) < date('now')
                        then 'Y' else 'N' end) as finished
                FROM commande
                    NATURAL LEFT JOIN client
                    NATURAL LEFT JOIN commande_contient_produit
                GROUP BY commande.id_commande
                ORDER BY commande.date_livraison;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function liste_single_commande($id_commande) {
        $sql = "SELECT *
                FROM commande
                    NATURAL JOIN adresse
                    NATURAL JOIN client
                WHERE id_commande = $id_commande";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function liste_produits_pour($id_commande) {
        $sql = "SELECT p.*, id_produit, quantite_produit_commande
                FROM commande
                    NATURAL JOIN commande_contient_produit
                    NATURAL JOIN produit p
                WHERE id_commande = $id_commande";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_client_for_commande($id_commande) {
        $sql = "SELECT id_client
                FROM commande
                WHERE id_commande = $id_commande ;";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function get_adresse_for_commande($id_commande) {
        $sql = "SELECT id_adresse
                FROM commande
                WHERE id_commande = $id_commande ;";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function get_date_for_commande($id_commande) {
        $sql = "SELECT date_livraison
                FROM commande
                WHERE id_commande = $id_commande ;";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function delete_commande($id) {
        $sql = "DELETE FROM commande_contient_produit
                WHERE id_commande = $id";
        $this->db->query($sql);
        $sql = "DELETE FROM commande WHERE id_commande = $id";
        $this->db->query($sql);
    }

    function modif_commande($id_commande, $commande) {
        $sql = "DELETE FROM commande_contient_produit
                WHERE id_commande = $id_commande";
        $this->db->query($sql);
        $sql = "UPDATE commande
                SET id_client = $commande->client,
                    id_adresse = $commande->adresse,
                    date_livraison = $commande->date
                WHERE id_commande = $id_commande ;";
        $this->db->query($sql);
        foreach($commande->commande as $prod) {
            if ($prod->quantite !== "0" || $prod->quantite !== 0) {
                $sql ="INSERT INTO commande_contient_produit
                    VALUES ($id_commande, $prod->id, $prod->quantite);";
                $this->db->query($sql);
            }
        }
    }

    function ajoute_commande($commande) {
        $sql = "INSERT INTO commande
                VALUES (null, 0, datetime('now'), datetime('$commande->date'),
                        $commande->client, $commande->adresse);";
        $res = $this->db->query($sql);
        $newId = $this->db->insert_id();
        foreach($commande->commande as $prod) {
            if ($prod->quantite !== "0" || $prod->quantite !== 0) {
                $sql = "INSERT INTO commande_contient_produit
                        VALUES ($newId, $prod->id, $prod->quantite);";
                $this->db->query($sql);
            }
        }
    }
}
