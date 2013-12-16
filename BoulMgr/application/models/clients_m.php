<?php
class Clients_m extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    function liste_clients(){
        $sql = "SELECT client.*, ville.nom_ville, telephone.numero_telephone 
                FROM client
                    natural join ville
                    natural join telephone
                    natural join adresse
                    natural join client_joignable_telephone
                    natural join client_habite_adresse
                GROUP BY id_telephone, id_client ;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function infos_client($id_client){
        $query = $this->db->get_where("client", array("id_client" => $id_client));
        return $query->row_array();
    }

    function adresses_client($id_client){
        $sql = "SELECT numero_voie_adresse, nom_type_voie, nom_voie_adresse,
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

}