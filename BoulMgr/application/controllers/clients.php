<?php

function exist_offset0_field($array, $fieldName) {
    if (array_key_exists ( 0 , $array )){   
        return $array[0][$fieldName];
    }
    return -1;
}

class Clients extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('clients_m','clients');
        $this->load->helper('url');
        $this->load->library('table');
    }

    function index() {
        $this->load->helper("form");
        $data['clients'] = $this->clients->liste_clients();
        $data['title'] = "clients";
        $this->load->view('templates/header', $data);
        $this->load->view('clients/clients_v', $data);
        //formulaire d'ajout de client
        $this->load->view('clients/add_client_v');
        $this->load->view('templates/footer');
    }

    function profil($id_client) {
        $data['infos'] = $this->clients->infos_client($id_client);
        $data['adresses'] = $this->clients->adresses_client($id_client);
        $data['telephones'] = $this->clients->telephones_client($id_client);
        $data['title'] = "Profil de ".$data['infos']['prenom_client']." ".$data['infos']['nom_client'];
        $data['commandes'] = $this->clients->get_commandes_client($id_client);
        $this->load->view('templates/header', $data);
        $this->load->view('clients/profil_client_v', $data);
        $this->load->view('templates/footer');
    }

    function add() {
        $this->load->model('adresses_m','adresses');

        $json = trim(file_get_contents('php://input'));
        $_POST = json_decode($json, true);

        $this->load->library('form_validation');
        
        $addr = $this->adresses;
        $clie = $this->clients;

        $config = array(
            array(
                'field' => 'prenom_client',
                'label' => 'Prénom du client',
                'rules' => 'required'
            ),
            array(
                'field' => 'nom_client',
                'label' => 'Nom du client',
                'rules' => 'required'
            ),
            array(
                'field' => 'numero_rue',
                'label' => 'Numéro dans la rue',
                'rules' => 'required|is_natural'
            ),
            array(
                'field' => 'nom_rue',
                'label' => 'Nom de la rue',
                'rules' => 'required'
            ),
            array(
                'field' => 'type_rue',
                'label' => 'Type de rue',
                'rules' => 'required'
            ),
            array(
                'field' => 'ville',
                'label' => 'Ville',
                'rules' => 'required'
            ),
            array(
                'field' => 'code_postal',
                'label' => 'Code postal',
                'rules' => 'required|is_natural'
            ),
            array(
                'field' => 'description_adresse',
                'label' => 'Description de l\'adresse',
                'rules' => ''
            ),
            array(
                'field' => 'description_numero',
                'label' => 'Description du numéro',
                'rules' => ''
            ),
            array(
                'field' => 'numero_telephone',
                'label' => 'Numéro de téléphone',
                'rules' => 'required|is_natural'
            )
        );

        $this->form_validation->set_message("required", "\"%s\" est obligatoire.");
        $this->form_validation->set_message("is_natural", "\"%s\" doit contenir uniquement des chiffres.");

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
        }
        else
        {
            
            // check for if that type of road exists
            $id_type_rue = exist_offset0_field(
                $addr->existe_type_rue( $_POST["type_rue"] ),
                "id_type_voie"
            );

            if($id_type_rue === -1){
                $addr->add_type_voie( $_POST["type_rue"] );
                $id_type_rue = $this->db->insert_id();
            }

            // check city
            $id_ville = exist_offset0_field(
                $addr->existe_ville( $_POST["ville"] ),
                "id_ville"
            );

            if($addr->existe_ville_with_postal($_POST["ville"], $_POST["code_postal"]) == 0 ){
                $addr->add_ville( $_POST["ville"], $_POST["code_postal"] );
                $id_ville = $this->db->insert_id();
            }

            // check adress already exists
            $id_adresse = exist_offset0_field(
                $addr->adresse_existe(
                    $_POST["nom_rue"],
                    $_POST["numero_rue"],
                    $id_ville,
                    $id_type_rue
                ),
                "id_adresse"
            );

            if($id_adresse === -1){
                $addr->add_adresse(
                    $_POST["numero_rue"], $_POST["nom_rue"], $id_ville, $id_type_rue, $_POST["description_adresse"]
                );
                $id_adresse = $this->db->insert_id();
            }

            // telephone exists
            $id_telephone = exist_offset0_field(
                $addr->existe_telephone(
                    $_POST["numero_telephone"]
                ),
                "id_telephone"
            );

            if($id_telephone === -1){
                $addr->add_telephone(
                    $_POST["numero_telephone"], $_POST["description_numero"]
                );
                $id_telephone = $this->db->insert_id();
            }

            $clie->add_client($_POST["nom_client"], $_POST["prenom_client"]);
            $id_client = $this->db->insert_id();
            $clie->add_joignable($id_client, $id_telephone);
            $clie->add_habite($id_client, $id_adresse);
            
            echo "OK";
        }
    }
}

?>
