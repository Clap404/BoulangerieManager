<?php
class Fournisseurs_m extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    function liste_fournisseurs(){
        $sql = "SELECT F.id_fournisseur, F.nom_fournisseur, V.nom_ville, T.numero_telephone 
            FROM Fournisseur F, Ville V, Telephone T, Adresse AD, Fournisseur_joignable J, Livre_depuis LD
            WHERE F.id_fournisseur = LD.id_fournisseur
            AND LD.id_adresse = AD.id_adresse
            AND AD.id_ville = V.id_ville
            AND F.id_fournisseur = J.id_fournisseur
            AND T.id_telephone = J.id_telephone
            GROUP BY T.id_telephone
            ;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function infos_fournisseur($id_fournisseur){
        $sql = "SELECT F.id_fournisseur, F.nom_fournisseur
            FROM Fournisseur F
            WHERE F.id_fournisseur = ?
            ;";
        $query = $this->db->query($sql, array($id_fournisseur));
        return $query->result();
    }

    function adresses_fournisseur($id_fournisseur){
        $sql = "SELECT AD.num_voie, TV.lib_type_voie, AD.nom_voie, V.code_postal, V.nom_ville, AD.description_adresse
            FROM Fournisseur F, Ville V, Adresse AD, Livre_depuis LD, Type_voie TV
            WHERE F.id_fournisseur = LD.id_fournisseur
            AND LD.id_adresse = AD.id_adresse
            AND AD.id_ville = V.id_ville
            AND TV.id_type_voie = AD.id_type_voie
            AND F.id_fournisseur = ?
            ;";
        $query = $this->db->query($sql, array($id_fournisseur));
        return $query->result();
    }

    function telephones_fournisseur($id_fournisseur){
        $sql = "SELECT T.numero_telephone, T.description_telephone
            FROM Fournisseur F, Telephone T, Fournisseur_joignable J
            WHERE F.id_fournisseur = J.id_fournisseur
            AND T.id_telephone = J.id_telephone
            AND F.id_fournisseur = ?
            ;";
        $query = $this->db->query($sql, array($id_fournisseur));
        return $query->result();
    }

    function matieres_premieres($id_fournisseur){
        $sql = "SELECT M.id_matiere_premiere, M.nom_matiere_premiere, VP.prix
            FROM Fournisseur F, Vendu_par VP, Matiere_premiere M
            WHERE F.id_fournisseur = VP.id_fournisseur
            AND VP.id_matiere_premiere = M.id_matiere_premiere
            AND F.id_fournisseur = ?
            ;";
        $query = $this->db->query($sql, array($id_fournisseur));
        return $query->result();
    }

}