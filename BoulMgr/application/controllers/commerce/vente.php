<?php

class Vente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/produits_model', 'produits');
        $this->load->model('commerce/vente_m', 'ventes');
        $this->load->model('clients_m', 'clients');
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
            $data['cli'] = 0;
        } else {
            $data['prods_commande'] = $this->ventes->liste_produits_pour($id_vente);
            $data['cli'] = $this->ventes->get_client_for_vente($id_vente);
        }
        $data['id_vente'] = $id_vente;
        $data['produits'] = $this->produits->affiche_all();
        $data['clients'] = $this->clients->all_clients();

        $data['title'] = "Vente";
        $data['root'] = $this->config->base_url();


        $this->load->view('templates/header', $data);
        $this->load->view('commerce/venteform_v', $data);
        $this->load->view('templates/footer');
    }

    function save($id_vente) {
        $id_vente = intval($id_vente, 10);
        $json = json_decode(trim(file_get_contents('php://input')));
        if (!(count($json->commande) === 0 && $id_vente === 0)) {
            if (count($json->commande) === 0) {
                $res = $this->ventes->delete_vente($id_vente);
            } elseif ($id_vente === 0) {
                $this->ventes->ajoute_vente($json);
            } else {
                $this->ventes->modif_vente($id_vente, $json); 
            }
        }
        $this->output->set_output("OK");
    }
}

?>
