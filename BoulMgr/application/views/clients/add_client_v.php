<div class="pop_up" style="display:none;">

<style type="text/css">
    textarea {
        resize: none;
    }
</style>
<table>
<tr><td>
<h3>Nouveau client</h3>
<?php

    echo form_open("clients/save");

    ?>

    <h4>Non du client</h4>
    <!-- nom du client -->
    <input id="prenom_client" type="text" placeholder="prénom du client" style="width:45%; display:inline-block;" />
    <input id="nom_client" type="text" placeholder="nom du client" style="width:45%; display:inline-block;" />

    <h4>Adresse</h4>
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

    <!-- numéro de téléphone -->
    <h4>Numéro de téléphone</h4>
    <input id="numero_telephone" type="text" placeholder="numéro de téléphone">
    <textarea id="description_numero" placeholder="description du numéro"></textarea>

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

        var formElement = document.querySelector("div.pop_up form");
        formElement.reset();

        document.querySelector("button#reset").onclick = function(){
            formElement.reset();
        }

        document.querySelector("button#add").onclick = function(){
            sendForm(
                formElement,
                "<?= base_url('/index.php/clients/add') ?>",
                document.querySelector("#status")
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

    </script>
</div>


<div id="addfourn">
    <button class="button radius round" onclick="popupFormDiv('div.pop_up', null, 0.6, 'fixed' )" >Ajouter un client</button>
</div>

<script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
<script defer src="<?= base_url("/assets/js/popup_form.js") ?>"></script>
