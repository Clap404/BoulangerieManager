<div class="pop_up" id="telephone" style="display:none;">

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
<h3>Ajout d'un numéro de téléphone</h3>
<?php

    echo form_open("clients/add_joignable");

    ?>

    <!-- id du client -->

    <input id="id_client" type="hidden" value="<?= $id_client ?>" />
    <input id="numero_telephone" type="text" placeholder="Numéro" />
    <textarea id="description_numero" type="text" placeholder="Description du numéro" ></textarea>

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
    var joignable_callbacks = function(){

        var formElement = document.querySelector("#telephone form");
        formElement.reset();

        document.querySelector("#telephone button#reset").onclick = function(){
            formElement.reset();
        }

        document.querySelector("#telephone button#add").onclick = function(){
            sendForm(
                formElement,
                "<?= base_url('/index.php/clients/add_joignable') ?>",
                document.querySelector("#telephone #status")
            );
        }
    };

    joignable_callbacks();

    </script>
</div>
