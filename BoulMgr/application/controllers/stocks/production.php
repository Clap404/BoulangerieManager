<?php 

class Production extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/produits_model', 'prod');
        $this->load->helper('url');
    }

    function index() {
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        $data['title'] = "Production";
        $this->load->view('templates/header', $data);
        $this->load->view('stocks/production');
        $this->load->view('templates/footer');
    }

    function getproduits() {
        $res = $this->prod->get_prod_for_select();
        echo json_encode($res);
    }

    function produire() {
        $this->load->library('input');
        $nbligne = $this->input->post('nbligne');
        $date_prod = $this->input->post('date');

        for($i = 0 ; $i < $nbligne ; $i++) {
            $id_produit = $this->input->post('prod'.$i);
            $qte = $this->input->post('qte'.$i);
            
            $donnees = array(
                'id_produit' => $id_produit,
                'date_production' => $date_prod,
                'quantite_produit_produit' => $qte
            );

            $this->prod->add_production($donnees);
        }
        
        redirect('/stocks/production');
    }
}

?>
