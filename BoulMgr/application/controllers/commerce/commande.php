<?php

class Commande extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/produits_model', 'produits');
        $this->load->model('commerce/commande_m', 'commandes');
        $this->load->model('clients_m', 'clients');
        $this->load->helper('url');
        $this->load->library('table');

    }

    function index() {
        $data['title'] = "Commandes";
        $data['commandes'] = $this->commandes->liste_commandes();

        $this->load->view('templates/header', $data);
        $this->load->view('commerce/commande_v', $data);
        $this->load->view('templates/footer');
    }

    function getadresse($id_client) {
        $liste = json_encode($this->clients->adresses_client($id_client));
        $this->output->set_output($liste);
    }

    function form($id_commande = 0) {
        if ($id_commande === 0) {
            $data['prods_commande'] = [];           
            $data['cli'] = 0;
            $data['adresse'] = 0;
            $data['date'] = "__/__/____ __:__";
        } else {
            $data['prods_commande'] = $this->commandes->liste_produits_pour($id_commande);
            $data['cli'] = $this->commandes->get_client_for_commande($id_commande);
            $ad = $this->commandes->get_adresse_for_commande($id_commande);
            $data['adresse'] = $ad['id_adresse'];
            $date = $this->commandes->get_date_for_commande($id_commande);
            $data['date'] = $date['date_livraison'];
        }
        $data['id_commande'] = $id_commande;
        $data['produits'] = $this->produits->affiche_all();
        $data['clients'] = $this->clients->all_clients();

        $data['title'] = "commande";
        $data['root'] = $this->config->base_url();


        $this->load->view('templates/header', $data);
        $this->load->view('commerce/commandeform_v', $data);
        $this->load->view('templates/footer');
    }

    function archive($id_commande = 0) {
        $data['commande'] = $this->commandes->liste_single_commande($id_commande);
        $data['produits'] = $this->commandes->liste_produits_pour($id_commande);
        $data['title'] = "Récapitulatif de la commande";
        if (count($data['commande']) === 0) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('commerce/commarchive_v', $data);
        $this->load->view('templates/footer');
    }

    function save($id_commande) {
        $id_commande = intval($id_commande, 10);
        $json = json_decode(trim(file_get_contents('php://input')));
        if (!(count($json->commande) === 0 && $id_commande === 0)) {
            if (count($json->commande) === 0) {
                $res = $this->commandes->delete_commande($id_commande);
            } elseif ($id_commande === 0) {
                $this->commandes->ajoute_commande($json);
            } else {
                $this->commandes->modif_commande($id_commande, $json); 
            }
        }
        $this->output->set_output("OK");
    }
}

?>
