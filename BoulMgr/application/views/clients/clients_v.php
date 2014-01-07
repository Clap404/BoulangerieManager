<h2>Clients</h2>

<?php
    $this->table->set_heading("ID", "Nom du client", "Ville", "Numéro de téléphone", "Montant des commandes", "Fiche détaillée");


    foreach ($clients as $value) {
        if(empty($value->total))
            $total = 0;
        else
            $total = $value->total;
        
        $this->table->add_row(
            $value->id_client,
            $value->nom_client." ".$value->prenom_client,
            $value->nom_ville,
            $value->numero_telephone,
            $total." €",
            anchor(array("clients", "profil", $value->id_client), "<button class='smallbutton'>Profil</button>")
        );
    }

    echo $this->table->generate(); 
?>
