<?php

class Produits extends CI_Controller {

    function index() {
        $this->load->database();
        $this->load->model('stocks/produits_model','prod');
        $data['produits'] = $this->prod->affiche_all();
        $data['title'] = "Produits";
        $this->load->view('templates/header', $data);
        $this->load->view('stocks/produits_v', $data);
        $this->load->view('templates/footer');
    }
}

?>
