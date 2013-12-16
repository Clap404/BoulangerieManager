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

        if(count($data['matprem']) != 0)
            $data['title'] = $data['matprem'][0]['nom_matiere_premiere'];
        else
            $data['title'] = "Matières premières (détail)";

        $this->load->view('templates/header', $data);
        $this->load->view('stocks/matprem_detail_v', $data);
        $this->load->view('templates/footer');
    }

    function modify()
    {
        $json = trim(file_get_contents('php://input'));
        $changes = json_decode($json, true);

        $array = $this->model_matprem->printByID($changes['id_matiere_premiere'])[0];
        $array['nom_matiere_premiere'] = $changes['nom_matiere_premiere'];

        // Check if $array is unidimensional
        if(count($changes, COUNT_RECURSIVE) == count($changes) && count($changes) != 0)
            echo($this->model_matprem->updateModif($array));
        else
            echo(0);
    }
}
?>
