<?php
class Clients_m extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    function liste_clients(){
        $sql = "SELECT F.id_client, F.nom_client, F.prenom_client, V.nom_ville, T.numero_telephone 
            FROM Client F, Ville V, Telephone T, Adresse AD, Client_joignable J, A_ete_livre AEL
            WHERE F.id_client = AEL.id_client
            AND AEL.id_adresse = AD.id_adresse
            AND AD.id_ville = V.id_ville
            AND F.id_client = J.id_client
            AND T.id_telephone = J.id_telephone
            GROUP BY T.id_telephone, F.id_client
            ;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function infos_client($id_client){
        $sql = "SELECT F.id_client, F.nom_client, F.prenom_client
            FROM Client F
            WHERE F.id_client = ?
            ;";
        $query = $this->db->query($sql, array($id_client));
        return $query->result();
    }

    function adresses_client($id_client){
        $sql = "SELECT AD.num_voie, TV.lib_type_voie, AD.nom_voie, V.code_postal, V.nom_ville, AD.description_adresse
            FROM Client F, Ville V, Adresse AD, A_ete_livre AEL, Type_voie TV
            WHERE F.id_client = AEL.id_client
            AND AEL.id_adresse = AD.id_adresse
            AND AD.id_ville = V.id_ville
            AND TV.id_type_voie = AD.id_type_voie
            AND F.id_client = ?
            ;";
        $query = $this->db->query($sql, array($id_client));
        return $query->result();
    }

    function telephones_client($id_client){
        $sql = "SELECT T.numero_telephone, T.description_telephone
            FROM Client F, Telephone T, Client_joignable J
            WHERE F.id_client = J.id_client
            AND T.id_telephone = J.id_telephone
            AND F.id_client = ?
            ;";
        $query = $this->db->query($sql, array($id_client));
        return $query->result();
    }

}