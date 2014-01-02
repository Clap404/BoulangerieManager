
<div>
<?php
    $this->table->set_heading("ID", "Nom du client", "Ville", "Numéro de téléphone", "Fiche détaillée");

    foreach ($clients as $value) {
        $this->table->add_row(
            $value->id_client,
            $value->nom_client,
            $value->nom_ville,
            $value->numero_telephone,
            anchor(array("clients", "profil", $value->id_client), "Profil")
        );
    }

    echo $this->table->generate(); 
?>
</div>

<?php
