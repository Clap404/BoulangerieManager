<h2>Production</h2>
<div id="prod">
<?php


echo form_open('stocks/production/produire');
date_default_timezone_set('Europe/Paris');
$date = date('Y-m-d');

?>

    <label for="date">Date</label><input type="date" name="date" value=<?='"'.$date.'"' ?>>

<table>
    <tr>
        <td>Produit</td>
        <td>Quantité</td>
        <td></td>
    </tr>
</table>

<?= form_hidden('nbligne', 0); ?>

<button>Produire</button>

<?php

echo form_close();

?>
</div>
<script defer src="<?= base_url("/assets/js/stocks/production.js") ?>"></script>
