<h2><?=$title?></h2>

<h3>adresses</h3>
<div>
<?php
    $this->table->set_heading('Adresse', 'Code postal', 'Ville', 'Description');

    foreach ($adresses as $value) {
        $this->table->add_row(
            $value->numero_voie_adresse ." ". $value->nom_type_voie ." ". $value->nom_voie_adresse,
            $value->code_postal,
            $value->nom_ville,
            $value->description_adresse
        );
    }

    echo $this->table->generate(); 
?>
</div>


<h3>numéros de téléphone</h3>
<div>
  
<?php
    $this->table->set_heading('Numéro', 'Description');

    foreach ($telephones as $value) {
        $this->table->add_row(
            $value->numero_telephone,
            $value->description_telephone
        );
    }

    echo $this->table->generate(); 
?>

</div>

<h3>produits vendus</h3>
<div>
<?php
    $this->table->set_heading('id', 'Matiere Premiere', 'prix fournisseur');

    foreach ($matieres_premieres as $value) {
        $this->table->add_row(
            $value->id_matiere_premiere,
            $value->nom_matiere_premiere,
            $value->prix

        );
    }

    echo $this->table->generate(); 
?>
</div>