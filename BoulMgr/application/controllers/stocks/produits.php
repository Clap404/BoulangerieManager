<?php

class Produits extends CI_Controller {

    function index() {
        $this->load->view('templates/header');
        $this->load->view('stocks/produits_v');
        $this->load->view('templates/footer');
    }
}

?>
