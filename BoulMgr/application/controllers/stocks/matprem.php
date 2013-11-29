<?php
class Matprem extends CI_Controller {

    function index()
    {
        $this->load->database();
        $this->load->model('stocks/matprem_model','model_matprem');

        $data['matprem'] = $this->model_matprem->print_all();
        $data['title'] = "Matières premières";

        $this->load->view('templates/header', $data);
        $this->load->view('stocks/matprem_v', $data);
        $this->load->view('templates/footer');
    }

}
?>
