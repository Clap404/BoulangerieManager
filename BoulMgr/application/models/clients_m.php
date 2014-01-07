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
        $sql = "SELECT numero_telephone, description_telephone, id_telephone
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

    function get_commandes_client($id_client) {
        $this->db->where('id_client', $id_client);
        $this->db->select('id_commande,prix_total, strftime("%d/%m/%Y", date_commande) as date_commande, strftime("%d/%m/%Y", date_livraison) as date_livraison, adresse.nom_voie_adresse, adresse.numero_voie_adresse, ville.nom_ville, ville.code_postal, type_voie.nom_type_voie');
        $this->db->from('commande');
        $this->db->join('adresse','adresse.id_adresse = commande.id_adresse');
        $this->db->join('ville', 'ville.id_ville = adresse.id_ville');
        $this->db->join('type_voie', 'type_voie.id_type_voie = adresse.id_type_voie');
        $this->db->order_by('date_commande');
        $query = $this->db->get();
        return $query->result_array();
    }

    function rm_joignable($id_telephone, $id_client) {

        $sql = "SELECT COUNT(*) as count FROM client_joignable_telephone
            WHERE id_client = ? ;";
        $query = $this->db->query($sql, array($id_client));

        if ($query->result_array()[0]["count"] > 1 ){

            $sql = "DELETE FROM client_joignable_telephone
                WHERE id_client = ?
                AND id_telephone = ? ;";
            $this->db->query($sql, array($id_client, $id_telephone));

            return 1;
        }
        return 0;
    }

    function rm_habite($id_client, $id_adresse) {
        $sql = "SELECT COUNT(*) AS count FROM client_habite_adresse
            WHERE id_client = ? ;";
        $query = $this->db->query($sql, array($id_client));

        if ($query->result_array()[0]["count"] > 1 ){
        
            $sql = "DELETE FROM client_habite_adresse
                WHERE id_client = ?
                AND id_adresse = ? ;";
            $this->db->query($sql, array( $id_client, $id_adresse));
            return 1;
        }
        return 0;
    }

    function modif_nom($id_client, $nom_client, $prenom_client) {
        $sql = "UPDATE client
            SET nom_client = ?, prenom_client = ?
            WHERE id_client = ? ;";
        return $this->db->query($sql, array($nom_client, $prenom_client, $id_client));
    }
}
