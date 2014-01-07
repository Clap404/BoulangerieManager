<?php
class Matprem extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks/matprem_model','model_matprem');
        $this->load->helper('url');
        date_default_timezone_set("Europe/Paris");
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
        $data['produits'] = $this->model_matprem->printProduits($id);

        if(count($data['matprem']) != 0)
            $data['title'] = $data['matprem'][0]['nom_matiere_premiere'];
        else
            $data['title'] = "Matières premières (détail)";

        $this->load->view('templates/header', $data);
        $this->load->view('stocks/matprem_detail_v', $data);
        $this->load->view('templates/footer');
    }

    function addMatprem()
    {
        $json = trim(file_get_contents('php://input'));
        $array = json_decode($json, true);
        $array = $this->security->xss_clean($array);

        if(!array_key_exists("abbreviation_unite", $array))
        {
            echo(0);
            return;
        }
        else if($this->model_matprem->matpremNameAlreadyExists($array["nom_matiere_premiere"]))
        {
            echo(-1);
            return;
        }

        $id = $this->model_matprem->getIdUniteByName($array["abbreviation_unite"]);
        if($id === [])
        {
            $unite = [];
            $unite["abbreviation_unite"] = $array["abbreviation_unite"];
            $unite["nom_unite"] = $unite["abbreviation_unite"];
            $matprem["id_unite"] = $this->model_matprem->insertUnite($unite);
            if($matprem["id_unite"] === -1)
            {
                echo(0);
                return;
            }
        }
        else
            $matprem["id_unite"] = $id[0]["id_unite"];

        $matprem["nom_matiere_premiere"] = $array["nom_matiere_premiere"];
        $id_matprem = $this->model_matprem->insert_matprem($matprem);
        if($id_matprem > 0)
            echo($id_matprem);
        else
            echo(0);
    }

    function modify()
    {
        $json = trim(file_get_contents('php://input'));
        $array = json_decode($json, true);
        $array = $this->security->xss_clean($array);

        if($this->model_matprem->matpremNameAlreadyExists($array["nom_matiere_premiere"], $array["id_matiere_premiere"]))
        {
            echo(-1);
            return;
        }

        if(array_key_exists("abbreviation_unite", $array))
        {
            $id = $this->model_matprem->getIdUniteByName($array["abbreviation_unite"]);
            if($id === [])
            {
                $unite = [];
                $unite["abbreviation_unite"] = $array["abbreviation_unite"];
                $unite["nom_unite"] = $unite["abbreviation_unite"];
                $matprem["id_unite"] = $this->model_matprem->insertUnite($unite);
                if($matprem["id_unite"] === -1)
                {
                    echo(0);
                    return;
                }
            }
            else
                $matprem["id_unite"] = $id[0]["id_unite"];
        }

        $matprem["nom_matiere_premiere"] = $array["nom_matiere_premiere"];
        $matprem["id_matiere_premiere"] = $array["id_matiere_premiere"];

        echo($this->model_matprem->updateMatprem($matprem));
    }

    function uploadMatpremImage($id_newmatprem)
    {
        $field_name = "upload_image";

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg';
        $config['max_size'] = '100';
        $config['max_width']  = '128';
        $config['max_height']  = '128';

        $this->load->library('upload', $config);
        $this->upload->do_upload($field_name);
        $info = $this->upload->data();

        if($info === [] || !file_exists($info["full_path"]))
        {
            echo(0);
            return;
        }

        $dest = $info['file_path'].'../assets/images/matprem/'.$id_newmatprem.$info['file_ext'];
        $src = $info['full_path'];
        echo(rename($src,$dest));
    }

    function jsonQuickDetail()
    {
        $id = $this->input->post('id');
        $matprem = $this->model_matprem->printByID($id);
        if($matprem === [])
        {
            echo(0);
            return;
        }

        $fournisseurs = $this->model_matprem->printFournisseurs($id);
        if($fournisseurs === [])
            $result = array("matprem" => $matprem[0]);
        else
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
            echo(json_encode($unites));
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
