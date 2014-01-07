<?php

function exist_offset0_field($array, $fieldName) {
    if (array_key_exists ( 0 , $array )){   
        return $array[0][$fieldName];
    }
    return -1;
}

class Fournisseurs extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('fournisseurs_m','fournisseurs');
        $this->load->helper('url');
        $this->load->library('table');
    }

    function index() {
        $this->load->helper("form");
        $data['fournisseurs'] = $this->fournisseurs->liste_fournisseurs();
        $data['title'] = "fournisseurs";
        $this->load->view('templates/header', $data);
        $this->load->view('fournisseurs/fournisseurs_v', $data);
        //formulaire d'ajout de fournisseur
        $this->load->view('fournisseurs/add_fournisseur_v');
        $this->load->view('templates/footer');
    }

    function profil($id_fournisseur) {
        $this->load->helper("form");
        $this->load->model('stocks/matprem_model','matprem');
        $data['matprem'] = $this->matprem->print_all();
        $data['infos'] = $this->fournisseurs->infos_fournisseur($id_fournisseur);
        $data['id_fournisseur'] = $id_fournisseur;
        $data['adresses'] = $this->fournisseurs->adresses_fournisseur($id_fournisseur);
        $data['telephones'] = $this->fournisseurs->telephones_fournisseur($id_fournisseur);
        $data['matieres_premieres'] = $this->fournisseurs->matieres_premieres($id_fournisseur);
        $data['title'] = "profil de ".$data['infos']['nom_fournisseur'];
        $data['rm_url'] = array(
            "matprem" => base_url("/index.php/fournisseurs/rm_matprem/".$id_fournisseur)."/",
            "telephone" => base_url("/index.php/fournisseurs/rm_joignable/".$id_fournisseur)."/"
        );
        $this->load->view('templates/header', $data);
        $this->load->view('fournisseurs/profil_fournisseur_v', $data);
        $this->load->view('fournisseurs/add_modif_matprem_v', $data);
        $this->load->view('fournisseurs/add_joignable_v', $data);
        $this->load->view('templates/footer');
    }

    function add_matprem() {
        $this->load->library('form_validation');

        $json = trim(file_get_contents('php://input'));
        $_POST = json_decode($json, true);

        $four = $this->fournisseurs;
        $config = array(
            array(
                'field' => 'id_fournisseur',
                'label' => 'id_fournisseur',
                'rules' => 'required'
            ),
            array(
                'field' => 'id_matprem',
                'label' => 'Matière première',
                'rules' => 'required|is_natural'
            ),
            array(
                'field' => 'prix',
                'label' => 'Prix',
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
            // if ( $four->add_matprem($_POST["id_fournisseur"], $_POST["id_matprem"]) != 0 )
            if ( $four->add_update_matprem($_POST["id_fournisseur"], $_POST["id_matprem"], $_POST["prix"]) === 0 )
                echo "La matière première ou le fournisseur n'existe pas.";
            else
                echo "OK";
        }
    }

    function add() {
        $this->load->model('adresses_m','adresses');
        $this->load->library('form_validation');

        $json = trim(file_get_contents('php://input'));
        $_POST = json_decode($json, true);
        
        $addr = $this->adresses;
        $four = $this->fournisseurs;

        $config = array(
            array(
                'field' => 'nom_fournisseur',
                'label' => 'Non du fournisseur',
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

            $four->add_fournisseur($_POST["nom_fournisseur"]);
            $id_fournisseur = $this->db->insert_id();
            $four->add_joignable($id_fournisseur, $id_telephone);
            $four->add_livre($id_fournisseur, $id_adresse);
            
            echo "OK";
        }
    }

    function add_joignable() {
        $this->load->model('adresses_m','adresses');
        $this->load->library('form_validation');

        $json = trim(file_get_contents('php://input'));
        $_POST = json_decode($json, true);

        $addr = $this->adresses;
        $four = $this->fournisseurs;
        $config = array(
            array(
                'field' => 'id_fournisseur',
                'label' => 'id_fournisseur',
                'rules' => 'required'
            ),
            array(
                'field' => 'numero_telephone',
                'label' => 'Numéro de téléphone',
                'rules' => 'required|is_natural'
            ),
            array(
                'field' => 'description_numero',
                'label' => 'Description du numéro',
                'rules' => ''
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

            $four->add_joignable($_POST["id_fournisseur"], $id_telephone);
        }
        echo "OK";
    }

    function rm_matprem($id_fournisseur, $id_matprem) {
        if ( $this->fournisseurs->rm_matprem($id_matprem, $id_fournisseur) == 1 )
            echo "OK";
        else
            echo "NOK";
    }

    function rm_joignable($id_fournisseur, $id_telephone) {
        //décommenter pour supprimer les numéros orphelins
        // $this->load->model('adresses_m','adresses');
        if ( $this->fournisseurs->rm_joignable($id_telephone, $id_fournisseur) == 1 ){   
            // $this->adresses->rm_if_orphaned_telephone($id_telephone);
            echo "OK";
        }
        else
            echo "NOK";
    }
}

?>
