<?php

class Adresses extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('adresses_m','adresses');
    }

    function liste_ville($ville = "") {
        $result = $this->adresses->liste_ville($ville);
        echo( json_encode($result) );
    }

    function ville_by_postal($postal = "") {
        $result = $this->adresses->ville_by_postal($postal);
        echo( json_encode($result) );
    }

    function postal_by_ville($ville = "") {
        $result = $this->adresses->postal_by_ville($ville);
        echo( json_encode($result) );
    }

    function liste_nom_rue($rue = "") {
        $result = $this->adresses->liste_nom_rue($rue);
        echo( json_encode($result) );
    }

    function liste_type_rue($type = "") {
        $result = $this->adresses->liste_type_rue($type);
        echo( json_encode($result) );
    }
}

?>
