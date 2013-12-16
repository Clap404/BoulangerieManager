<?php

class Produits extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/produits_model','prod');
        $this->load->helpers('url');
    }

    function index() {
        $data['produits'] = $this->prod->affiche_all();
        $data['title'] = "Produits";
        $this->load->view('templates/header', $data);
        $this->load->view('stocks/produits_v', $data);
        $this->load->view('templates/footer');
    }

    function remove($id) {
        $this->prod->remove_produit($id);
        $this->index();
    }
}

?>

