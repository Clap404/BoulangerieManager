<?php

class Matprem_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function print_all() {
        $query = $this->db->get('Matiere_premiere');
        return $query->result_array();
    }
}

?>