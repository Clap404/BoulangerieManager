<?php
class Adresses_m extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    function liste_ville($ville) {
        $sql = "SELECT * FROM ville
            WHERE ville.nom_ville LIKE ? ;";

        $query = $this->db->query($sql, array($ville."%"));
        return $query->result_array();
    }

    function ville_by_postal($postal) {
        $sql = "SELECT ville.nom_ville FROM ville
            WHERE ville.code_postal = ? ;";

        $query = $this->db->query($sql, array($postal));
        return $query->result_array();
    }

    function postal_by_ville($ville) {
        $sql = "SELECT ville.code_postal FROM ville
            WHERE ville.nom_ville = ? ;";

        $query = $this->db->query($sql, array($ville));
        return $query->result_array();
    }

    function liste_nom_rue($rue) {
        $sql = "SELECT DISTINCT adresse.nom_voie_adresse FROM adresse
            WHERE adresse.nom_voie_adresse LIKE ? ;";

        $query = $this->db->query($sql, array($rue."%"));
        return $query->result_array();
    }

    function liste_type_rue($type) {
        $sql = "SELECT * FROM type_voie
            WHERE type_voie.nom_type_voie LIKE ? ;";

        $query = $this->db->query($sql, array($type."%"));
        return $query->result_array();
    }
}
