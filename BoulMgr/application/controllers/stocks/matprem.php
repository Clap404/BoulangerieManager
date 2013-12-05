<?php
class Matprem extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/matprem_model','model_matprem');
        $this->load->helper('url');
    }

    function index()
    {
        $data['matprem'] = $this->model_matprem->print_all();
        $data['title'] = "Matières premières";

        $this->load->view('templates/header', $data);
        $this->load->view('stocks/matprem_v', $data);
        $this->load->view('templates/footer');
    }

    function detail($id)
    {
        $data['matprem'] = $this->model_matprem->printByID($id);
        $data['fournisseur'] = $this->model_matprem->printFournisseurs($id);
        //$data['title'] = $data['matprem']['nom_matiere_premiere'];
        $data['title'] = "Test";

        $this->load->view('templates/header', $data);
        $this->load->view('stocks/matprem_detail_v', $data);
        $this->load->view('templates/footer');
    }

}
?>
