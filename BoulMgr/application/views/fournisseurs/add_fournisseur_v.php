<div id="pop_up" style="display:none;">

<style type="text/css">
    textarea {
        resize: none;
        height: 2em;
    }
</style>

<h3>Nouveau fournisseur</h3>
<?php

    echo form_open("fournisseurs/save");

    ?>
    <h4>Adresse</h4>
    <input type="text" id="numero_rue" style="width:10%; display:inline-block;" placeholder="numéro" />

    <!-- datalist avec passage de la ligne sélectionnée dans le champ input si pertinent -->
    <!-- sélection du type de rue -->

    <input id="type_rue" list="type_rue_lst" style="width:20%; display:inline-block;" placeholder="type de voie" />
    <datalist id="type_rue_lst">
        <?php

        foreach ($type_rue as $key => $value) {
            echo "<option id='".$key."' value='".$value."'>\n";
        }

        ?>
    </datalist>
    <input type="hidden" id="id_type_rue" value="new">

    <!-- sélection du nom de rue -->
    <input id="nom_rue" list="nom_rue_lst" style="width:60%; display:inline-block;" placeholder="nom de la rue" />
    <datalist id="nom_rue_lst">
        <?php

        foreach ($nom_rue as $key => $value) {
            echo "<option id='".$key."' value='".$value."'>\n";
        }

        ?>
    </datalist>

    <!-- sélection du code postal -->
    <input id="code_postal" list="code_postal_lst" style="width:30%; display:inline-block;" placeholder="code postal" />
    <datalist id="code_postal_lst">
        <?php

        foreach ($code_postal as $key => $value) {
            echo "<option id='".$key."' value='".$value."'>\n";
        }

        ?>
    </datalist>
    <input type="hidden" id="id_code_postal" value="new">

    <!-- sélection de la ville -->
    <input id="ville" list="ville_lst" style="width:60%; display:inline-block;" placeholder="ville" />
    <datalist id="ville_lst">
        <?php

        foreach ($ville as $key => $value) {
            echo "<option id='".$key."' value='".$value."'>\n";
        }

        ?>
    </datalist>
    <input type="hidden" id="id_ville" value="new">
    
    <textarea id="description_adresse" placeholder="description de l'adresse"></textarea>

    <!-- numéro de téléphone -->
    <h4>Numéro de téléphone</h4>
    <input id="numero_telephone" type="text" placeholder="numéro de téléphone">
    <textarea id="description_numero" placeholder="description du numéro"></textarea>

    <input type="reset" value="reset"/>
    <?php
    echo form_close();

    ?>
    <script type="text/javascript">

        document.querySelector("div#pop_up form").reset();

        document.querySelector("#ville").oninput = function(event){
            var datalistToFill = document.querySelector("#ville_lst"); 
            
            if(this.value.length === 1){
                setDatalistOptions(
                    datalistToFill,
                    "http://localhost:8080/BDD/BoulangerieManager/BoulMgr/index.php/adresses/liste_ville/" + this.value ,
                    "id_ville",
                    "nom_ville"
                );
            }
        }

        document.querySelector("input#type_rue").onchange = function(){
            dataListWithId("type_rue");
        }

        document.querySelector("input#code_postal").onchange = function(){
            dataListWithId("code_postal");
        }

        document.querySelector("input#ville").onchange = function(){
            dataListWithId("ville");
        }
    </script>
</div>


<div id="addfourn">
    <button class="button radius round" onclick="popupFormDiv('div#pop_up', null, 0.6, 'fixed' )" >Ajouter un fournisseur</button>
</div>

<script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
<script defer src="<?= base_url("/assets/js/popup_form.js") ?>"></script>