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

    function liste_telephone($telephone) {
        $sql = "SELECT * FROM telephone
            WHERE telephone.numero_telephone LIKE ? ;";

        $query = $this->db->query($sql, array($telephone."%"));
        return $query->result_array();
    }

    function existe_ville($ville) {
        $sql = "SELECT * FROM ville
            WHERE ville.nom_ville = ? ;";

        $query = $this->db->query($sql, array($ville));
        return $query->result_array();
    }

    function existe_nom_rue($rue) {
        $sql = "SELECT DISTINCT adresse.nom_voie_adresse FROM adresse
            WHERE adresse.nom_voie_adresse = ? ;";

        $query = $this->db->query($sql, array($rue));
        return $query->result_array();
    }

    function existe_type_rue($type) {
        $sql = "SELECT * FROM type_voie
            WHERE type_voie.nom_type_voie = ? ;";

        $query = $this->db->query($sql, array($type));
        return $query->result_array();
    }

    function existe_telephone($telephone) {
        $sql = "SELECT * FROM telephone
            WHERE telephone.numero_telephone = ? ;";

        $query = $this->db->query($sql, array($telephone));
        return $query->result_array();
    }

    function existe_ville_with_postal($ville, $postal) {
        $sql = "SELECT COUNT(*) as exist FROM ville
            WHERE ville.nom_ville = ?
            AND ville.code_postal = ? ;";

        $query = $this->db->query($sql, array($ville, $postal));
        return $query->result_array()[0]["exist"];
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

    function adresse_existe($rue, $numero, $id_ville, $id_type_voie) {
        $sql = "SELECT A.id_adresse FROM adresse A
        WHERE A.numero_voie_adresse = ?
        AND A.nom_voie_adresse = ?
        AND A.id_ville = ?
        AND A.id_type_voie = ? ;";

        $query = $this->db->query($sql, array($numero, $rue, $id_ville, $id_type_voie));
        return $query->result_array();
    }
    
    function add_type_voie($type) {
        $sql = "INSERT INTO type_voie
            VALUES (NULL, ?) ;";

        return $this->db->query($sql, array($type));   
    }

    function add_ville($ville, $code_postal) {
        $sql = "INSERT INTO ville
            VALUES (NULL, ?, ?) ;";

        return $this->db->query($sql, array($ville, $code_postal));
    }

    function add_adresse($numero, $nom_voie, $id_vile, $id_type_rue, $description_adresse) {
        $sql = "INSERT INTO adresse
            VALUES (NULL, ?, ?, ?, ?, ?) ;";

        return $this->db->query($sql, array($numero, $nom_voie, $description_adresse, $id_vile, $id_type_rue));
    }

    function add_telephone($telephone, $description_telephone) {
        $sql = "INSERT INTO telephone VALUES( NULL, ?, ?);";
        return $this->db->query($sql, array($telephone, $description_telephone));
    }

    function rm_if_orphaned_telephone($telephone) {
        $sql = "DELETE from telephone
            where (
                select count(*) from fournisseur_joignable_telephone where id_telephone = ?) = 0
            and (
                select count(*) from client_joignable_telephone where id_telephone = ?) = 0
            and telephone.id_telephone = ?
            ;";
        return $this->db->query($sql, array($telephone, $telephone, $telephone));
    }
}
