<div class="pop_up" id="matprem" style="display:none;">

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
<h3>Ajout/Modification d'un article</h3>
<?php

    echo form_open("fournisseurs/add_matprem");

    ?>

    <!-- id du fournisseur -->

    <input id="id_fournisseur" type="hidden" value="<?= $id_fournisseur ?>" />
    <select id="id_matprem" style="width:45%; display:inline-block;" >
        <?php
        foreach ($matprem as $value) {
            echo "<option value='".$value["id_matiere_premiere"]."'>".$value["nom_matiere_premiere"]."</option>\n";
        }
        ?>
    </select>
    <input id="prix" type="text" placeholder="prix pour ce fournisseur" style="width:45%; display:inline-block;" />

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
    var matprem_callbacks = function(){

        var formElement = document.querySelector("#matprem form");
        formElement.reset();

        document.querySelector("#matprem button#reset").onclick = function(){
            formElement.reset();
        }

        document.querySelector("#matprem button#add").onclick = function(){
            sendForm(
                formElement,
                "<?= base_url('/index.php/fournisseurs/add_matprem') ?>",
                document.querySelector("#matprem #status")
            );
        }
    };

    matprem_callbacks();

    </script>
</div>