<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
	    parent::__construct();
	    $this->load->model('stocks/matprem_model', 'matprem');
	    $this->load->model('stocks/produits_model', 'prod');
	    $this->load->model('commerce/commande_m', 'commande');
	    $this->load->model('commerce/vente_m', 'vente');
	    $this->load->helper('url');
	    $this->load->library('table');
	}


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $data['title'] = "Tableau de bord";
        $data['root'] = $this->config->base_url();


        //nom_matprem, nom_fournisseur, prix
        $data['lowmatprem'] = $this->matprem->listLowMatprem();
        //nom_produit, prod, commande
        $data['productip'] = $this->commande->allProductsForTodaysCommandes();
        //nom_produit, vendus
        $data['prodtip'] = $this->prod->trending();
        //nom_produit, vendus
        $data['sales'] = $this->vente->todaysVente();
        //client , heure, adresse
        $data['todayscommande'] = $this->commande->metainfoForTodaysCommandes();

        $this->load->view('templates/header', $data);
		$this->load->view('welcome_message', $data);
        $this->load->view('templates/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
