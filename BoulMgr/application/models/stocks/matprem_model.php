<?php

class Matprem_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function print_all()
    {
        /* Select * from Matiere_premiere
         * inner join unite as u on u.id_unite = matiere_premiere.id_unite; */
        $this->db->select('*, (SELECT IFNULL(SUM(com.quantite_matiere_premiere),0) FROM commande_matiere_premiere com WHERE com.id_matiere_premiere=matiere_premiere.id_matiere_premiere) AS disponibilite_matiere_premiere');
        $this->db->join('unite', 'unite.id_unite = matiere_premiere.id_unite');
        $this->db->order_by("nom_matiere_premiere", "asc");
        $query = $this->db->get('Matiere_premiere');
        return $query->result_array();
    }

    function printByID($id)
    {
        /* Select * from Matiere_premiere
         * inner join unite as u on u.id_unite = matiere_premiere.id_unite;
         * where id_matiere_premiere = $id; */
        $this->db->select('*, (SELECT IFNULL(SUM(com.quantite_matiere_premiere),0) FROM commande_matiere_premiere com WHERE com.id_matiere_premiere=matiere_premiere.id_matiere_premiere) AS disponibilite_matiere_premiere');
        $this->db->join('unite', 'unite.id_unite = matiere_premiere.id_unite');
        $query = $this->db->get_where('Matiere_premiere', array('id_matiere_premiere' => $id));
        return $query->result_array();
    }

    function printFournisseurs($id)
    {
        /* Select id_fournisseur, nom_fournisseur, prix
         * from matiere_premiere_vendue_par_fournisseur as Vp
         * inner join Fournisseur as F on F.id_fournisseur = Vp.id_fournisseur
         * inner join Matiere_premiere as M on M.id_matiere_premiere = Vp.id_matiere_premiere
         * where Vp.id_matiere_premiere=$id; */
        $this->db->select('matiere_premiere_vendue_par_fournisseur.id_fournisseur, nom_fournisseur, prix');
        $this->db->join('Fournisseur', 'Fournisseur.id_fournisseur = matiere_premiere_vendue_par_fournisseur.id_fournisseur');
        $this->db->join('Matiere_premiere', 'Matiere_premiere.id_matiere_premiere = matiere_premiere_vendue_par_fournisseur.id_matiere_premiere');
        $this->db->order_by("prix", "asc");
        $query = $this->db->get_where('matiere_premiere_vendue_par_fournisseur', array('matiere_premiere_vendue_par_fournisseur.id_matiere_premiere' => $id));

        return $query->result_array();
    }

    function printCommandesMatprem($id)
    {
        /* Select * from commande_matiere_premiere as com
         * inner join Fournisseur as F on F.id_fournisseur = com.id_fournisseur
         * where com.id_matiere_premiere=$id; */
        $this->db->join('Fournisseur', 'Fournisseur.id_fournisseur = commande_matiere_premiere.id_fournisseur');
        $query = $this->db->get_where('commande_matiere_premiere', array('commande_matiere_premiere.id_matiere_premiere' => $id));

        return $query->result_array();
    }

    function updateModif($array)
    {
        $error = !(array_key_exists("nom_matiere_premiere", $array));
        $error = $error || !(array_key_exists("id_matiere_premiere", $array));

        if($error)
            return 0;

        $this->db->set('nom_matiere_premiere', $array['nom_matiere_premiere']);
        $this->db->where('id_matiere_premiere', $array['id_matiere_premiere']);
        $error = $this->db->update('matiere_premiere');
        return $error;
    }

    function getFournPrice($idMatprem, $idFourn)
    {
        $this->db->select('prix');
        $query = $this->db->get_where('matiere_premiere_vendue_par_fournisseur', array('matiere_premiere_vendue_par_fournisseur.id_matiere_premiere' => $idMatprem, 'matiere_premiere_vendue_par_fournisseur.id_fournisseur' => $idFourn));

        return $query->result_array();
    }

    function insertCommand($array)
    {
        $error = $this->db->insert("commande_matiere_premiere", $array);
        return $error;
    }

    function deleteCommand($idCommand)
    {
        return $this->db->delete("commande_matiere_premiere", array("id_commande_matiere_premiere" => $idCommand));
    }
}

?>
