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
                GROUP BY id_fournisseur
                ORDER BY nom_fournisseur ;";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function infos_fournisseur($id_fournisseur){
        $query = $this->db->get_where("fournisseur", array('id_fournisseur' => $id_fournisseur));
        return $query->row_array();
    }

    function adresses_fournisseur($id_fournisseur){
        $sql = "SELECT numero_voie_adresse, nom_type_voie, nom_voie_adresse,
                    description_adresse, code_postal, nom_ville, id_adresse
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
        $sql = "SELECT numero_telephone, description_telephone, id_telephone
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
        $sql = "INSERT INTO fournisseur_joignable_telephone VALUES( ?, ?);";
        return $this->db->query($sql, array($id_fournisseur, $id_telephone));
    }

    function add_livre($id_fournisseur, $id_adresse) {
        $sql = "INSERT INTO fournisseur_livre_depuis_adresse VALUES( ?, ?);";
        return $this->db->query($sql, array($id_fournisseur, $id_adresse));
    }

    function add_update_matprem($id_fournisseur, $id_matprem, $prix) {
        
        $sql = "UPDATE matiere_premiere_vendue_par_fournisseur
            SET prix = ?
            WHERE id_fournisseur = ?
            AND id_matiere_premiere = ? ;";
        $query = $this->db->query($sql, array($prix, $id_fournisseur, $id_matprem));
        $update_success = ( $query == 1 );

        if(!$update_success){
            return 1;
        }

        $sql = "SELECT COUNT(*) AS count FROM fournisseur WHERE id_fournisseur = ?;";
        $query = $this->db->query($sql, array($id_fournisseur));
        $fournisseur_exists = ( $query->result_array()[0]["count"] == 1 );

        $sql = "SELECT COUNT(*) AS count FROM matiere_premiere WHERE id_matiere_premiere = ?;";
        $query = $this->db->query($sql, array($id_matprem));
        $matiere_premiere_exists = ( $query->result_array()[0]["count"] == 1 );

        if( $fournisseur_exists && $matiere_premiere_exists ){
            $sql = "INSERT INTO matiere_premiere_vendue_par_fournisseur VALUES( ?, ?, ?);";
            return $this->db->query($sql, array($id_matprem, $id_fournisseur, $prix));
        }
        else
            return 0;
    }

    // function add_joignable_($id_fournisseur, $telephone) {

    //     $sql = "SELECT COUNT(*) AS count FROM telephone WHERE numero_telephone = ?;";
    //     $query = $this->db->query($sql, array($numero_telephone));
    //     $telephone_exists = ( $query->result_array()[0]["count"] >= 1 );

    //     $id_telephone = "" ;

    //     if($telephone_exists){
    //         $sql = "SELECT id_telephone FROM telephone WHERE numero_telephone = ?;";
    //         $query = $this->db->query($sql, array($telephone));
    //         $id_telephone = $query->result_array()[0]["id_telephone"];
    //     }
    //     else {
    //         $sql = "INSERT INTO telephone VALUES( NULL, ?);";
    //         $this->db->query($sql, array($telephone));
    //         $id_telephone = $this->db->insert_id();
    //     }

    //     $sql = "INSERT INTO fournisseur_joignable_telephone VALUES( ?, ?);";
    //     $this->db->query($sql, array($id_fournisseur, $id_telephone));

    //     return 1;
    // }

    function rm_matprem($id_matprem, $id_fournisseur) {
        $sql = "DELETE FROM matiere_premiere_vendue_par_fournisseur
            WHERE id_fournisseur = ?
            AND id_matiere_premiere = ? ;";
        return $this->db->query($sql, array( $id_fournisseur, $id_matprem));
    }

    function rm_joignable($id_telephone, $id_fournisseur) {

        $sql = "SELECT COUNT(*) as count FROM fournisseur_joignable_telephone
            WHERE id_fournisseur = ? ;";
        $query = $this->db->query($sql, array($id_fournisseur));

        if ($query->result_array()[0]["count"] > 1 ){

            $sql = "DELETE FROM fournisseur_joignable_telephone
                WHERE id_fournisseur = ?
                AND id_telephone = ? ;";
            $this->db->query($sql, array($id_fournisseur, $id_telephone));

            return 1;
        }
        return 0;
    }

    function rm_livre($id_fournisseur, $id_adresse) {
        $sql = "SELECT COUNT(*) AS count FROM fournisseur_livre_depuis_adresse
            WHERE id_fournisseur = ? ;";
        $query = $this->db->query($sql, array($id_fournisseur));

        if ($query->result_array()[0]["count"] > 1 ){
        
            $sql = "DELETE FROM fournisseur_livre_depuis_adresse
                WHERE id_fournisseur = ?
                AND id_adresse = ? ;";
            $this->db->query($sql, array( $id_fournisseur, $id_adresse));
            return 1;
        }
        return 0;
    }

    function modif_nom($id_fournisseur, $nom_fournisseur) {
        $sql = "UPDATE fournisseur
            SET nom_fournisseur = ?
            WHERE id_fournisseur = ? ;";
        return $this->db->query($sql, array($nom_fournisseur, $id_fournisseur));
    }
}
