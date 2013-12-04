<?php

class Fournisseurs extends CI_Controller {

    function index() {
        $this->load->database();
        $this->load->model('fournisseurs_m','fournisseurs');
        $data['fournisseurs'] = $this->fournisseurs->liste_fournisseurs();
        $data['title'] = "fournisseurs";
        $this->load->view('templates/header', $data);
        $this->load->view('fournisseurs/fournisseurs_v', $data);
        $this->load->view('templates/footer');
    }

    function profil($id_fournisseur) {
        $this->load->database();
        $this->load->model('fournisseurs_m','fournisseurs');
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
