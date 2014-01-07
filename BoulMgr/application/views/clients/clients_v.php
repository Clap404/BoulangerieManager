<h2>Clients</h2>

<?php
    $this->table->set_heading("ID", "Nom du client", "Ville", "Numéro de téléphone", "Commandes", "Achats", "Total", "Fiche détaillée");


    foreach ($clients as $value) {
        if(empty($value->total_commande))
            $total_commande = 0;
        else
            $total_commande = $value->total_commande;

        if(empty($value->total_vente))
            $total_vente = 0;
        else
            $total_vente = $value->total_vente;
        
        $this->table->add_row(
            $value->id_client,
            $value->nom_client." ".$value->prenom_client,
            $value->nom_ville,
            $value->numero_telephone,
            $total_commande." €",
            $total_vente." €",
            $total_vente + $total_commande." €",
            anchor(array("clients", "profil", $value->id_client), "<button class='smallbutton'>Profil</button>")
        );
    }

    echo $this->table->generate(); 
?>
