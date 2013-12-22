<?php

class Vente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/produits_model', 'produits');
        $this->load->model('commerce/vente_m', 'ventes');
        $this->load->helper('url');
        $this->load->library('table');

    }

    function index() {

        $data['title'] = "Vente";
        $data['ventes'] = $this->ventes->liste_ventes();

        $this->load->view('templates/header', $data);
        $this->load->view('commerce/vente_v', $data);
        $this->load->view('templates/footer');
    }

    function form($id_vente = 0) {

        if ($id_vente === 0) {
            $data['prods_commande'] = [];           
        } else {
            $data['prods_commande'] = $this->ventes->liste_produits_pour($id_vente);
        }

        $data['produits'] = $this->produits->affiche_all();
        $data['title'] = "Vente";
        $data['root'] = $this->config->base_url();

        $this->load->view('templates/header', $data);
        $this->load->view('commerce/venteform_v', $data);
        $this->load->view('templates/footer');
    }
}

?>
