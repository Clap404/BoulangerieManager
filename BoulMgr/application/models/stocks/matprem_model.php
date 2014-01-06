<?php

class Matprem_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insert_matprem($array)
    {
        $this->db->insert("matiere_premiere", $array);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function print_all()
    {
        /* Select * from Matiere_premiere
         * inner join unite as u on u.id_unite = matiere_premiere.id_unite; */
        $this->db->select('matiere_premiere.id_matiere_premiere, nom_matiere_premiere, matiere_premiere.id_unite, abbreviation_unite, nom_unite, last_production, dispo AS disponibilite_matiere_premiere');
        $this->db->join('unite', 'unite.id_unite = matiere_premiere.id_unite');
        $this->db->join('(select id_matiere_premiere, date_production as last_production from produit inner join produit_est_produit on produit_est_produit.id_produit = produit.id_produit inner join produit_est_compose_de_matiere_premiere on produit_est_compose_de_matiere_premiere.id_produit = produit.id_produit group by id_matiere_premiere) as subqueryDateProd', 'subqueryDateProd.id_matiere_premiere = matiere_premiere.id_matiere_premiere', 'left');
        $this->db->join('(SELECT id_matiere_premiere, (possede - utilise) AS dispo FROM (SELECT id_matiere_premiere, sum(utilise) as utilise FROM (SELECT m.id_matiere_premiere, ifnull(quantite_matiere_premiere_produit * sum(quantite_produit_produit), 0.0) AS utilise FROM matiere_premiere m NATURAL LEFT JOIN (produit_est_produit NATURAL JOIN produit_est_compose_de_matiere_premiere) GROUP BY m.id_matiere_premiere, id_produit) GROUP BY id_matiere_premiere) NATURAL LEFT JOIN (SELECT id_matiere_premiere, ifnull(sum(quantite_matiere_premiere),0.0) AS possede FROM matiere_premiere NATURAL LEFT JOIN commande_matiere_premiere GROUP BY id_matiere_premiere) GROUP BY id_matiere_premiere) as subQueryDispo', 'subqueryDispo.id_matiere_premiere = matiere_premiere.id_matiere_premiere', 'left');
        $this->db->order_by("nom_matiere_premiere", "asc");
        $query = $this->db->get('Matiere_premiere');
        return $query->result_array();
    }

    function printByID($id)
    {
        /* Select * from Matiere_premiere
         * inner join unite as u on u.id_unite = matiere_premiere.id_unite;
         * where id_matiere_premiere = $id; */
        $this->db->select('matiere_premiere.id_matiere_premiere, nom_matiere_premiere, matiere_premiere.id_unite, abbreviation_unite, nom_unite, dispo AS disponibilite_matiere_premiere');
        $this->db->join('unite', 'unite.id_unite = matiere_premiere.id_unite');
        $this->db->join('(SELECT id_matiere_premiere, (possede - utilise) AS dispo FROM (SELECT id_matiere_premiere, sum(utilise) as utilise FROM (SELECT m.id_matiere_premiere, ifnull(quantite_matiere_premiere_produit * sum(quantite_produit_produit), 0.0) AS utilise FROM matiere_premiere m NATURAL LEFT JOIN (produit_est_produit NATURAL JOIN produit_est_compose_de_matiere_premiere) GROUP BY m.id_matiere_premiere, id_produit) GROUP BY id_matiere_premiere) NATURAL LEFT JOIN (SELECT id_matiere_premiere, ifnull(sum(quantite_matiere_premiere),0.0) AS possede FROM matiere_premiere NATURAL LEFT JOIN commande_matiere_premiere GROUP BY id_matiere_premiere) GROUP BY id_matiere_premiere) as subQueryDispo', 'subqueryDispo.id_matiere_premiere = matiere_premiere.id_matiere_premiere', 'left');
        $query = $this->db->get_where('Matiere_premiere', array('matiere_premiere.id_matiere_premiere' => $id));
        return $query->result_array();
    }

    function printUnites()
    {
        $query = $this->db->get("unite");
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

    function printProduits($id)
    {
        $this->db->select("produit_est_compose_de_matiere_premiere.id_produit, nom_produit, quantite_matiere_premiere_produit");
        $this->db->join('Produit', 'Produit.id_produit = produit_est_compose_de_matiere_premiere.id_produit');
        $query = $this->db->get_where('produit_est_compose_de_matiere_premiere', array('produit_est_compose_de_matiere_premiere.id_matiere_premiere' => $id));

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

    function updateMatprem($array)
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

    function matpremNameAlreadyExists($name)
    {
        $this->db->select('nom_matiere_premiere');
        $query = $this->db->get_where('matiere_premiere', array('nom_matiere_premiere' => $name));

        $result = $query->result_array();
        return !($result === []);
    }

    function getFournPrice($idMatprem, $idFourn)
    {
        $this->db->select('prix');
        $query = $this->db->get_where('matiere_premiere_vendue_par_fournisseur', array('matiere_premiere_vendue_par_fournisseur.id_matiere_premiere' => $idMatprem, 'matiere_premiere_vendue_par_fournisseur.id_fournisseur' => $idFourn));

        return $query->result_array();
    }

    function getIdUniteByName($abbreviation_unite)
    {
        $this->db->select('id_unite');
        $query = $this->db->get_where('unite', array('LOWER(abbreviation_unite)' => strtolower($abbreviation_unite)));

        return $query->result_array();
    }

    function insertUnite($array)
    {
        $error = $this->db->insert("unite", $array);
        $insert_id = $this->db->insert_id();

        if(!$error)
            return -1;

        return $insert_id;
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

    function modifyCommand($array)
    {
        $error = !(array_key_exists("id_commande_matiere_premiere", $array));
        $error = $error || !(array_key_exists("quantite_matiere_premiere", $array));

        if($error)
            return 0;

        $this->db->set('quantite_matiere_premiere', $array['quantite_matiere_premiere']);
        $this->db->where('id_commande_matiere_premiere', $array['id_commande_matiere_premiere']);
        $error = $this->db->update('commande_matiere_premiere');
        return $error;
    }

    function listLowMatprem() {
        //nom_matprem, nom_fournisseur, prix quand dispo faible

        //Minimum de dispo pour warn
        $pallier = 10;

        //les dispos
        $sq1 = "SELECT id_matiere_premiere, (possede - utilise) AS dispo
                FROM (SELECT id_matiere_premiere, sum(utilise) as utilise
                        FROM (SELECT m.id_matiere_premiere,
                                ifnull(quantite_matiere_premiere_produit
                                    * sum(quantite_produit_produit), 0.0) AS utilise
                            FROM matiere_premiere m
                                NATURAL LEFT JOIN (produit_est_produit
                                           NATURAL JOIN produit_est_compose_de_matiere_premiere)
                            GROUP BY m.id_matiere_premiere, id_produit)
                    GROUP BY id_matiere_premiere)
                    NATURAL LEFT JOIN (SELECT id_matiere_premiere,
                            ifnull(sum(quantite_matiere_premiere),0.0) AS possede
                        FROM matiere_premiere
                            NATURAL LEFT JOIN commande_matiere_premiere
                        GROUP BY id_matiere_premiere)
                GROUP BY id_matiere_premiere";


        //Les fournisseurs les moins cher par matprem
        $sq2 = "SELECT nom_matiere_premiere,
                    id_matiere_premiere,
                    nom_fournisseur, 
                    min(prix) AS minprix
                FROM matiere_premiere_vendue_par_fournisseur
                    NATURAL JOIN matiere_premiere
                    NATURAL JOIN fournisseur
                GROUP BY id_matiere_premiere";

        //l'union des deux avec selectio selon le pallier
        $sql = "SELECT nom_matiere_premiere, nom_fournisseur, minprix
                FROM ($sq1) NATURAL JOIN ($sq2)
                WHERE dispo < $pallier;";

        $query = $this->db->query($sql);
        return $query->result();
    }

}

?>
