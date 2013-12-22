<?php

class Venteform extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/produits_model', 'produits');
    }

    function index() {

        $data['produits'] = $this->produits->affiche_all();
        $data['title'] = "Vente";
        $data['root'] = $this->config->base_url();

        $this->load->view('templates/header', $data);
        $this->load->view('commerce/venteform_v', $data);
        $this->load->view('templates/footer');
    }
}

?>
