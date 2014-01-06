<?php
class Fournisseurs_m extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    function liste_fournisseurs(){
        $sql = "SELECT fournisseur.*, GROUP_CONCAT( DISTINCT ville.nom_ville ) AS nom_ville, GROUP_CONCAT( DISTINCT telephone.numero_telephone ) AS numero_telephone 
                FROM fournisseur 
                    natural join adresse
                    natural join ville
                    natural join fournisseur_joignable_telephone
                    natural join telephone
                    natural join fournisseur_livre_depuis_adresse
                GROUP BY id_fournisseur ;";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function infos_fournisseur($id_fournisseur){
        $query = $this->db->get_where("fournisseur", array('id_fournisseur' => $id_fournisseur));
        return $query->row_array();
    }

    function adresses_fournisseur($id_fournisseur){
        $sql = "SELECT numero_voie_adresse, nom_type_voie, nom_voie_adresse,
                    description_adresse, code_postal, nom_ville
                FROM fournisseur
                    natural join fournisseur_livre_depuis_adresse
                    natural join adresse
                    natural join ville
                    natural join type_voie
                WHERE id_fournisseur = ? ;";
        $query = $this->db->query($sql, array($id_fournisseur));
        return $query->result();
    }

    function telephones_fournisseur($id_fournisseur){
        $sql = "SELECT numero_telephone, description_telephone
                FROM telephone
                    natural join fournisseur_joignable_telephone
                    natural join fournisseur
                WHERE id_fournisseur = ? ;";
        $query = $this->db->query($sql, array($id_fournisseur));
        return $query->result();
    }

    function matieres_premieres($id_fournisseur){
        $sql = "SELECT id_matiere_premiere, nom_matiere_premiere, prix
                FROM matiere_premiere
                    natural join matiere_premiere_vendue_par_fournisseur
                    natural join fournisseur
                WHERE id_fournisseur = ? ;";
        $query = $this->db->query($sql, array($id_fournisseur));
        return $query->result();
    }

    function add_fournisseur($nom_fournisseur){
        $sql = "INSERT INTO fournisseur VALUES( NULL, ?);";
        return $this->db->query($sql, array($nom_fournisseur));
    }

    function add_joignable($id_fournisseur, $id_telephone) {
        $sql = "INSERT INTO fournisseur_joignable_telephone VALUES( NULL, ?, ?);";
        return $this->db->query($sql, array($id_fournisseur, $id_telephone));
    }

    function add_livre($id_fournisseur, $id_adresse) {
        $sql = "INSERT INTO fournisseur_livre_depuis_adresse VALUES( NULL, ?, ?);";
        return $this->db->query($sql, array($id_fournisseur, $id_adresse));
    }
}
