<div class="pop_up" id="adresse" style="display:none;">

<style type="text/css">
    textarea {
        resize: none;
    }
    table {
        width: 100% ;
    }
</style>
<table>
<tr><td>
<h3>Ajout d'une adresse</h3>
<?php

    echo form_open("fournisseurs/add_adresse");

    ?>

    <!-- id du fournisseur -->

    <input id="id_fournisseur" type="hidden" value="<?= $id_fournisseur ?>" />
    <input type="text" id="numero_rue" style="width:10%; display:inline-block;" placeholder="numéro" />

    <!-- datalist avec passage de la ligne sélectionnée dans le champ input si pertinent -->
    <!-- sélection du type de rue -->

    <input id="type_rue" type="text" list="type_rue_lst" style="width:20%; display:inline-block;" placeholder="type de voie" />
    <datalist id="type_rue_lst"></datalist>

    <!-- sélection du nom de rue -->
    <input id="nom_rue" type="text" list="nom_rue_lst" style="width:60%; display:inline-block;" placeholder="nom de la rue" />
    <datalist id="nom_rue_lst"></datalist>

    <!-- sélection de la ville -->
    <input id="ville" type="text" list="ville_lst" style="width:60%; display:inline-block;" placeholder="ville" />
    <datalist id="ville_lst"></datalist>

    <!-- code postal -->
    <input id="code_postal" type="text" style="width:30%; display:inline-block;" placeholder="code postal" />
    
    <textarea id="description_adresse" placeholder="description de l'adresse"></textarea>

    <?php
    echo form_close();
    ?>

    <button id="reset" type="reset">Reset</button>
    <button id="add" type="button">Ajouter</button>
</td><td>
    <div id="status"></div>
</td></tr>
</table>
    <script type="text/javascript">
    var adresse_callbacks = function(){

        var formElement = document.querySelector("#adresse form");
        formElement.reset();

        document.querySelector("#adresse button#reset").onclick = function(){
            formElement.reset();
        }

        document.querySelector("#adresse button#add").onclick = function(){
            sendForm(
                formElement,
                "<?= base_url('/index.php/fournisseurs/add_adresse') ?>",
                document.querySelector("#adresse #status")
            );
        }

        var fields = {
            dl : {
                ville : document.querySelector("#ville_lst"),
                type_rue : document.querySelector("#type_rue_lst"),
                nom_rue : document.querySelector("#nom_rue_lst")
            },
            in : {
                ville : document.querySelector("#ville"),
                type_rue : document.querySelector("#type_rue"),
                nom_rue : document.querySelector("#nom_rue"),
                numero_rue : document.querySelector("#numero_rue"),
                code_postal : document.querySelector("#code_postal")
            }
        }

        fields.in.ville.oninput = function(event){
            var datalistToFill = fields.dl.ville; 
            
            if( firstCharChanged(this) ) {
                setDatalistOptions(
                    datalistToFill,
                    "<?= base_url('/index.php/adresses/liste_ville') ?>/" + this.value ,
                    "nom_ville"
                );
            }
        }

        fields.in.type_rue.onfocus = function(){
                var datalistToFill = fields.dl.type_rue; 
                if (!datalistToFill.hasChildNodes()) {
                setDatalistOptions(
                    datalistToFill,
                    "<?= base_url('/index.php/adresses/liste_type_rue') ?>",
                    "nom_type_voie"
                );
            }
        }

        fields.in.nom_rue.oninput = function(event){
            var datalistToFill = fields.dl.nom_rue; 
            
            if( firstCharChanged(this) ) {
                setDatalistOptions(
                    datalistToFill,
                    "<?= base_url('/index.php/adresses/liste_nom_rue') ?>/" + this.value ,
                    "nom_voie_adresse"
                );
            }
        }

        fields.in.ville.onchange = function() {
            setInputValue(
                fields.in.code_postal,
                "<?= base_url('/index.php/adresses/postal_by_ville') ?>/" + fields.in.ville.value ,
                "code_postal"
            );
        }

        fields.in.code_postal.onchange = function() {
            setInputValue(
                fields.in.ville,
                "<?= base_url('/index.php/adresses/ville_by_postal') ?>/" + fields.in.code_postal.value ,
                "nom_ville"
            );
        }
    };

    adresse_callbacks();

    </script>
</div>