<?php
class Matprem extends Controller {

    function index()
    {
        $this->load->view('templates/header');
        $this->load->view('matprem_v');
        $this->load->view('templates/footer');
    }

}
?>
