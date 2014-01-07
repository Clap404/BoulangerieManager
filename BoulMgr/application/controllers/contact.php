<?php
class Contact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    function index()
    {
        $data['title'] = "Contact";

        $this->load->view('templates/header', $data);
        $this->load->view('contact_v', $data);
        $this->load->view('templates/footer');
    }
}
