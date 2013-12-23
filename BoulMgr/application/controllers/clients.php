<?php

class Clients extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('clients_m','clients');
        $this->load->helper('url');
        $this->load->library('table');
    }

    function index() {
        $data['clients'] = $this->clients->liste_clients();
        $data['title'] = "clients";
        $this->load->view('templates/header', $data);
        $this->load->view('clients/clients_v', $data);
        $this->load->view('templates/footer');
    }

    function profil($id_client) {
        $data['infos'] = $this->clients->infos_client($id_client);
        $data['adresses'] = $this->clients->adresses_client($id_client);
        $data['telephones'] = $this->clients->telephones_client($id_client);
        $data['title'] = "profil de ".$data['infos']['nom_client'];
        $this->load->view('templates/header', $data);
        $this->load->view('clients/profil_client_v', $data);
        $this->load->view('templates/footer');
    }
}

?>
