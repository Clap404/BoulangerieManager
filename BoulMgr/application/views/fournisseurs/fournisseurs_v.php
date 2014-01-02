
<div>
<?php
    $this->table->set_heading("ID", "Nom du fournisseur", "Ville", "Numéro de téléphone", "Fiche détaillée");

    foreach ($fournisseurs as $value) {
        $this->table->add_row(
            $value->id_fournisseur,
            $value->nom_fournisseur,
            $value->nom_ville,
            $value->numero_telephone,
            anchor(array("fournisseurs", "profil", $value->id_fournisseur), "Profil")
        );
    }

    echo $this->table->generate(); 
?>
</div>

<?php
