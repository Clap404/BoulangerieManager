<?php
class Invendus extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/produits_model','model_produits');
        $this->load->helper('url');
        date_default_timezone_set("Europe/Paris");
    }

    function index()
    {
        for($i = 1; $i < 8; $i++)
        {
            foreach($this->model_produits->affiche_invendu_ago($i) as $result)
                $data['invendus'][] = $result;

            foreach($this->model_produits->affiche_somme_invendu_ago($i) as $result)
                $data["total_par_jour"][] = $result;
        }

        $data['title'] = "Invendus";

        $this->load->view('templates/header', $data);
        $this->load->view('informations/invendus_v', $data);
        $this->load->view('templates/footer');
    }

}
