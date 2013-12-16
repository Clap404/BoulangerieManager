<?php

class Produits_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function   affiche_all() {
        $sql = "select p.*, 
            (ifnull(pep.quantite_produit_produit, 0) - (
                ifnull(c.quantite_produit_commande, 0) +
                ifnull(v.quantite_produit_vente, 0))
            ) as disponibilite_produit
        from produit p
            left outer join produit_est_produit pep
                on pep.id_produit = p.id_produit
            left outer join (
                vente_comprend_produit
                    natural join vente) v
                on v.id_produit = p.id_produit
            left outer join (
                commande_contient_produit
                    natural join commande) c
                on c.id_produit = p.id_produit

        where (date(v.date_vente) = date('now')
            or v.date_vente is null)
        and (date(c.date_livraison) = date('now')
            or c.date_livraison is null)
        and (date(pep.date_production) = date('now')
            or pep.date_production is null)
        group by p.id_produit;";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function remove_produit($id) {
        $this->db->where("id_produit", $id);
        $this->db->delete();
    }
}

?>
