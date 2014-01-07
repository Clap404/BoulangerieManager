<script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
<script defer src="<?= base_url("/assets/js/popup_form.js") ?>"></script>
<div id="client">
<h2><?=$title?></h2>
<div id="buttontitle">
    <button class="button round radius" onclick="popupFormDiv('#modifnom', null, 0.6, 'fixed' )" >Renommer</button>
</div>
<div class="row">
    <div class="small-6 large-6 columns">
<h3>adresses</h3>
<div class="fournisseur">
<?php
    $this->table->set_heading('Adresse', 'Code postal', 'Ville', 'Description', "");

    foreach ($adresses as $value) {
        $this->table->add_row(
            $value->numero_voie_adresse ." ". $value->nom_type_voie ." ". $value->nom_voie_adresse,
            $value->code_postal,
            $value->nom_ville,
            $value->description_adresse,
            "<button class='smallbutton ' rmurl='".$rm_url["adresse"].$value->id_adresse."' >X</button>"
        );
    }

    echo $this->table->generate(); 
?>
</div>
<div id="addmatprem">
    <button class="button radius round clientbutton" onclick="popupFormDiv('#adresse', null, 0.6, 'fixed' )" >Ajouter une adresse</button>
</div>
    </div>

    <div class="small-6 large-6 columns">
<h3>numéros de téléphone</h3>
<div class="fournisseur">
  
<?php
    $this->table->set_heading('Numéro', 'Description', "");

    foreach ($telephones as $value) {
        $this->table->add_row(
            $value->numero_telephone,
            $value->description_telephone,
            "<button class='smallbutton' rmurl='".$rm_url["telephone"].$value->id_telephone."' >X</button>"
        );
    }

    echo $this->table->generate(); 
?>

</div>
<div id="addmatprem">
    <button class="button radius round clientbutton" onclick="popupFormDiv('#telephone', null, 0.6, 'fixed' )" >Ajouter un numéro de téléphone</button>
</div>
</div>
</div>


<h3>Commandes</h3>
<div id="commandes">
<div class="fournisseur">
    <?php
    $this->table->set_heading('Numero','Prix','Date de la commande', 'Date de livraison', 'Adresse de livraison');

    foreach($commandes as $value) {
        $this->table->add_row (
            $value['id_commande'],
            $value['prix_total'].'€',
            $value['date_commande'],
            $value['date_livraison'],
            $value['numero_voie_adresse'].' '.$value['nom_type_voie'].' '.$value['nom_voie_adresse'].', '.$value['code_postal'].' '.$value['nom_ville']
        );
    }

    echo $this->table->generate();
    ?>
</div>
<div id="addmatprem">
    <a href="<?= base_url('/index.php/commerce/commande/form')?>"><button class="button radius round clientbutton">Passer une commande</button></a>
</div>
</div>
</div>
<script type="text/javascript">
    //ajoute les croix de supression et les callbacks
    var rmbuttons = document.querySelectorAll("button[rmurl]");

    for (var i = rmbuttons.length - 1; i >= 0; i--) {
        rmbuttons[i].onclick = function() {
            rm_from_bdd(this.getAttribute("rmurl"), this);
        }
    };
</script>