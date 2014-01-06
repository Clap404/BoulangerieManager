<?php
class Clients_m extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function all_clients() {
        $query = $this->db->get('client');
        return $query->result();

    }
    
    function liste_clients(){
        $sql = "SELECT client.*, GROUP_CONCAT( DISTINCT ville.nom_ville ) AS nom_ville, GROUP_CONCAT( DISTINCT telephone.numero_telephone ) AS numero_telephone
                FROM client
                    natural join ville
                    natural join telephone
                    natural join adresse
                    natural join client_joignable_telephone
                    natural join client_habite_adresse
                GROUP BY id_client
                ORDER BY nom_client ;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function infos_client($id_client){
        $query = $this->db->get_where("client", array("id_client" => $id_client));
        return $query->row_array();
    }

    function adresses_client($id_client){
        $sql = "SELECT id_adresse, numero_voie_adresse, nom_type_voie, nom_voie_adresse,
                    code_postal, nom_ville, description_adresse
                FROM client
                    natural join client_habite_adresse
                    natural join adresse
                    natural join ville
                    natural join type_voie
                WHERE id_client = ? ;";

        $query = $this->db->query($sql, array($id_client));
        return $query->result();
    }

    function telephones_client($id_client){
        $sql = "SELECT numero_telephone, description_telephone
                FROM Telephone
                    natural join client_joignable_telephone
                    natural join client
                WHERE id_client = ?;";
        $query = $this->db->query($sql, array($id_client));
        return $query->result();
    }

    function add_client($nom_client, $prenom_client){
        $sql = "INSERT INTO client VALUES( NULL, ?, ?);";
        return $this->db->query($sql, array($nom_client, $prenom_client));
    }

    function add_joignable($id_client, $id_telephone) {
        $sql = "INSERT INTO client_joignable_telephone VALUES( ?, ?);";
        return $this->db->query($sql, array($id_client, $id_telephone));
    }

    function add_habite($id_client, $id_adresse) {
        $sql = "INSERT INTO client_habite_adresse VALUES( ?, ?);";
        return $this->db->query($sql, array($id_client, $id_adresse));
    }
}
