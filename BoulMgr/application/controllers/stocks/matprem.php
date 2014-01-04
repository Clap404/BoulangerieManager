<?php
class Matprem extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/matprem_model','model_matprem');
        $this->load->helper('url');
    }

    function addMatprem()
    {
        $json = trim(file_get_contents('php://input'));
        $matprem = json_decode($json, true);
        $matprem = $this->security->xss_clean($matprem);

        // temp line for test
        $matprem["id_unite"] = 1;

        echo($this->model_matprem->insert_matprem($matprem));
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
        $data['commandes'] = $this->model_matprem->printCommandesMatprem($id);

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
        $changes = $this->security->xss_clean($changes);

        // Check if $array is unidimensional
        if(is_array($changes) && count($changes, COUNT_RECURSIVE) == count($changes) && count($changes) != 0)
            echo($this->model_matprem->updateMatprem($changes));
        else
            echo(0);
    }

    function jsonQuickDetail()
    {
        $id = $this->input->post('id');
        $matprem = $this->model_matprem->printByID($id);
        $fournisseurs = $this->model_matprem->printFournisseurs($id);
        $result = array("matprem" => $matprem[0], "fournisseur" => $fournisseurs[0]);

        if(count($result) != 0)
            echo(json_encode($result));
        else
            echo(0);
    }

    function jsonListUnites()
    {
        $unites = $this->model_matprem->printUnites();
        if(count($unites) != 0)
            echo(json_encode($result));
        else
            echo(0);
    }

    function addCommand()
    {
        $json = trim(file_get_contents('php://input'));
        $command = json_decode($json, true);
        $command = $this->security->xss_clean($command);

        $prix = $this->model_matprem->getFournPrice($command["id_matiere_premiere"], $command["id_fournisseur"]);
        if(count($prix) == 0)
        {
            echo(0);
            return;
        }
        $command["prix_unite_matiere_premiere"] = $prix[0]["prix"];
        $command["date_commande_matiere_premiere"] = date("Y-m-d H:i:s");

        echo($this->model_matprem->insertCommand($command));
    }

    function deleteCommand($idCommand)
    {
        if(isset($idCommand))
        {
            echo($this->model_matprem->deleteCommand($idCommand));
            return;
        }
        echo(0);
    }

    function modifyCommand()
    {
        $json = trim(file_get_contents('php://input'));
        $command = json_decode($json, true);
        $command = $this->security->xss_clean($command);

        echo($this->model_matprem->modifyCommand($command));
    }
}
?>
