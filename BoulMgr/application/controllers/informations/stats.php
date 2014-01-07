<?php
class Stats extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('stocks/produits_model','model_produits');
        $this->load->helper('url');
        $this->load->library('table');
        date_default_timezone_set("Europe/Paris");
    }

    function index()
    {
        $data['title'] = 'Statistiques';
        $data['total'] = $this->model_produits->somme_vente_produit_annee();
        $total = 0;
        foreach($data['total'] as $soustot)
        {
            $total += $soustot["somme_produit"];
        }
        $data['grand_total'] = $total;

        $data['total2'] = $this->model_produits->somme_vente_produit_semaine();
        $total2 = 0;
        foreach($data['total2'] as $soustot)
        {
            $total2 += $soustot["somme_produit"];
        }
        $data['grand_total2'] = $total2;

        $this->load->view('templates/header', $data);
        $this->load->view('informations/stats_v', $data);
        $this->load->view('templates/footer');
    }
}
