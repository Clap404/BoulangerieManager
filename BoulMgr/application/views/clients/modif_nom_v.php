<div class="pop_up" id="modifnom" style="display:none;">

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
<h3>Modification du nom</h3>
<?php

    echo form_open("");

    ?>

    <!-- id du client -->

    <input id="id_client" type="hidden" value="<?= $id_client ?>" />
    <input id="prenom_client" type="text" placeholder="prénom du client" style="width:45%; display:inline-block;" value="<?= $infos['prenom_client'] ?>" />
    <input id="nom_client" type="text" placeholder="nom du client" style="width:45%; display:inline-block;" value="<?= $infos['nom_client'] ?>" />

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
    var modifnom_callbacks = function(){

        var formElement = document.querySelector("#modifnom form");
        formElement.reset();

        document.querySelector("#modifnom button#reset").onclick = function(){
            formElement.reset();
        }

        document.querySelector("#modifnom button#add").onclick = function(){
            sendForm(
                formElement,
                "<?= base_url('/index.php/clients/modif_nom') ?>",
                document.querySelector("#modifnom #status")
            );
        }
    };

    modifnom_callbacks();

    </script>
</div>
