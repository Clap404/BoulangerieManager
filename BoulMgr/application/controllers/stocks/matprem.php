<?php
class Matprem extends CI_Controller {

    function index()
    {
        $this->load->view('templates/header');
        $this->load->view('matprem_v');
        $this->load->view('templates/footer');
    }

}
?>
