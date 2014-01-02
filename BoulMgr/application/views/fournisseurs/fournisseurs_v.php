
<div>
<?php
    $this->table->set_heading("ID", "Nom du fournisseur", "Ville", "Numéro de téléphone", "Fiche détaillée");

    foreach ($fournisseurs as $value) {
        $this->table->add_row(
            $value->id_fournisseur,
            $value->nom_fournisseur,
            $value->nom_ville,
            $value->numero_telephone,
            anchor(array("fournisseurs", "profil", $value->id_fournisseur), "<button>Profil</button>")
        );
    }

    echo $this->table->generate(); 
?>
</div>

<div>
    <button onclick="popupForm('http://localhost:8080', 'GET', null, 0.6, 'fixed' )" >Ajouter un fournisseur</button>
</div>

<script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
<script defer src="<?= base_url("/assets/js/popup_form.js") ?>"></script>
<?php
