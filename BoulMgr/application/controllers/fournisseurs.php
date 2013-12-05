<?php

class Fournisseurs extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('fournisseurs_m','fournisseurs');
        $this->load->helper('url');
    }

    function index() {
        $data['fournisseurs'] = $this->fournisseurs->liste_fournisseurs();
        $data['title'] = "fournisseurs";
        $this->load->view('templates/header', $data);
        $this->load->view('fournisseurs/fournisseurs_v', $data);
        $this->load->view('templates/footer');
    }

    function profil($id_fournisseur) {
        $data['infos'] = $this->fournisseurs->infos_fournisseur($id_fournisseur);
        $data['adresses'] = $this->fournisseurs->adresses_fournisseur($id_fournisseur);
        $data['telephones'] = $this->fournisseurs->telephones_fournisseur($id_fournisseur);
        $data['matieres_premieres'] = $this->fournisseurs->matieres_premieres($id_fournisseur);
        $data['title'] = "profil de ";
        $this->load->view('templates/header', $data);
        $this->load->view('fournisseurs/profil_fournisseur_v', $data);
        $this->load->view('templates/footer');
    }
}

?>
