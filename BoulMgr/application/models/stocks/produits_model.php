<?php

class Produits_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function affiche_all() {
        $query = $this->db->get('Produit');
        return $query->result_array();
    }
}

?>
