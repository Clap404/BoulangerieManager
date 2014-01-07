<?php

Class Stats_m extends CI_model {

    function __construct()
    {
    parent::__construct();
    $this->load->database();
    }

  function somme_vente_produit(){
        $sql= " select nom_produit, sum(total_produit_vente) as somme_produit
                from
                (  select id_produit, nom_produit, 
                (quantite_produit_vente * prix_produit) as total_produit_vente 
                FROM vente_comprend_produit
                NATURAL JOIN produit 
                NATURAL JOIN vente 
                )
                group by id_produit;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}