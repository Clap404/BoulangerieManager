<?php

class Produits extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/produits_model','prod');
        $this->load->helpers('url');
    }

    function index() {
        $data['produits'] = $this->prod->affiche_all();
        $data['title'] = "Produits";
        $this->load->view('templates/header', $data);
        $this->load->view('stocks/produits_v', $data);
        $this->load->view('templates/footer');
    }

    function remove($id) {
        $this->prod->remove_produit($id);
        $this->index();
    }

    function ajoutproduit() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nom', 'nom', 'required');
        $this->form_validation->set_rules('prix', 'prix', 'required');
        $this->form_validation->set_rules('temps', 'temps', 'required');

        if($this->form_validation->run() === FALSE) {
            $data['title'] = 'Ajout Produit';
            $this->load->view('templates/header', $data);
            $this->load->view('stocks/produits_add');
            $this->load->view('templates/footer');
        }
        else {
            $donnees = array(
                'nom_produit' => $_POST['nom'],
                'prix_produit' => $_POST['prix'],
                'temps_preparation_produit' => $_POST['temps']
            );
            $this->prod->add_produit($donnees);
            if($this->do_upload("image")) {
                $info = $this->upload->data();
                $id = $this->prod->get_next_id()[0]['id_produit'];
                $dest = $info['file_path'].'../assets/images/produit/'.$id.$info['file_ext'];
                $src = $info['full_path'];
                rename($src,$dest);
            }
            else {
                echo "L'upload a échoué";
            }
            $this->index();
        }
    }

    function add($add) {
        $this->prod->add_produit($add);
        $this->index();
    }

    private function do_upload($field_name) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width']  = '128';
        $config['max_height']  = '128';

        $this->load->library('upload', $config);
        return $this->upload->do_upload($field_name);
    }
}

?>

