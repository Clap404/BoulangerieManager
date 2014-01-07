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

    <!-- id du fournisseur -->

    <input id="id_fournisseur" type="hidden" value="<?= $id_fournisseur ?>" />
    <input id="nom_fournisseur" type="text" placeholder="Nouveau nom" value="<?= $infos['nom_fournisseur'] ?>" />

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
                "<?= base_url('/index.php/fournisseurs/modif_nom') ?>",
                document.querySelector("#modifnom #status")
            );
        }
    };

    modifnom_callbacks();

    </script>
</div>
