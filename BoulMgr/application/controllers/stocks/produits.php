<?php

class Produits extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/produits_model','prod');
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
        redirect('/stocks/produits/');
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
            redirect('/stocks/produits');
        }
    }

    private function do_upload($field_name) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg';
        $config['max_size'] = '100';
        $config['max_width']  = '128';
        $config['max_height']  = '128';

        $this->load->library('upload', $config);
        return $this->upload->do_upload($field_name);
    }

    function modifproduit($id = 0) {
        $this->load->helper('form');
        $this->load->library('form_validation');
       
        $this->form_validation->set_rules('nom', 'nom', 'required');
        $this->form_validation->set_rules('prix', 'prix', 'required');
        $this->form_validation->set_rules('temps', 'temps', 'required');
        if(isset($_POST['id_produit'])) {
            $idtemp = $_POST['id_produit'];
            $data['produit'] = $this->prod->get_prod_by_id($idtemp)[0];
        }
        else {
            $data['produit'] = $this->prod->get_prod_by_id($id)[0];
        }
        $data['title'] = "Modifier produit";
        if($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('stocks/produits_modif', $data);
            $this->load->view('templates/footer');
        }
        else {
            $id = $_POST['id_produit'];
            $donnees = array(
                'nom_produit' => $_POST['nom'],
                'prix_produit' => $_POST['prix'],
                'temps_preparation_produit' => $_POST['temps']
            );
            $this->prod->modif_produit($id, $donnees);
            redirect('/stocks/produits/');
        }
    }
}

?>

