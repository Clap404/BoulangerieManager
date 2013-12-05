<?php

class Matprem_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function print_all()
    {
        /* Select * from Matiere_premiere; */
        $query = $this->db->get('Matiere_premiere');
        return $query->result_array();
    }

    function printByID($id)
    {
        /* Select * from Matiere_premiere where id_matiere_premiere = $id; */
        $query = $this->db->get_where('Matiere_premiere', array('id_matiere_premiere' => $id));
        return $query->result_array();
    }

    function printFournisseurs($id)
    {
        /* Select id_fournisseur, nom_fournisseur, prix
         * from Vendu_par as Vp
         * inner join Fournisseur as F on F.id_fournisseur = Vp.id_fournisseur; */
        $this->db->select('Vendu_par.id_fournisseur, nom_fournisseur, prix');
        $this->db->join('Fournisseur', 'Fournisseur.id_fournisseur = Vendu_par.id_fournisseur');
        $this->db->join('Matiere_premiere', 'Matiere_premiere.id_matiere_premiere = Vendu_par.id_matiere_premiere');
        $query = $this->db->get_where('Vendu_par', array('Vendu_par.id_matiere_premiere' => $id));

        return $query->result_array();
    }

}

?>
