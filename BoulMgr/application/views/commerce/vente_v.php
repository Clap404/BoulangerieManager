<h2><?=$title?></h2>

<a href="<?=site_url()?>/commerce/vente/form">
    <button>Enregistrer un nouveau tiquet</button>
</a>
<div>
<?php
    $this->table->set_heading('Date', 'Prix total', 'Client', 'Action');

    foreach ($ventes as $value) {
        $this->table->add_row(
            $value->date_vente,
            $value->prix_vente,
            $value->id_client,
            '<a href="'.site_url().'/commerce/vente/form/'.$value->id_vente.'">
                <button>modifier</button>
            </a>'
        );
    }

    echo $this->table->generate(); 
?>
</div>
