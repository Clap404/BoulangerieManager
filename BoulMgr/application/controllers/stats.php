<?php
class Stats extends CI_Controller {
   
    function __construct()
    {
            parent::__construct();
            $this->load->model('stats_m','stats');
            $this->load->helper('url');
            $this->load->library('table');
            date_default_timezone_set("Europe/Paris"); 
    }

    function index() {
    $data['total'] = $this->stats->somme_vente_produit();
    $data['title'] = 'Statistiques';
    $total = 0; 
    foreach($data['total'] as $soustot)
    {
        $total += $soustot["somme_produit"]; 
    }
    $data['grand_total'] = $total; 
    $this->load->view('templates/header', $data);
    $this->load->view('stats_v', $data);
    $this->load->view('templates/footer');
    }
}