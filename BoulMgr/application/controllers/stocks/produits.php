<?php

class Produits extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/produits_model','prod');
    }

    function index() {
        $data['produits'] = $this->prod->affiche_all();
        $data['title'] = "Produits";
        $this->load->view('templates/header', $data);
        $this->load->view('stocks/produits_v', $data);
        $this->load->view('templates/footer');
    }
}

?>
