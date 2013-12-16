
<div>
<table>
    <thead>
        <tr>
            <td>ID</td>
            <td>Nom du client</td>
            <td>Ville</td>
            <td>Numéro de téléphone</td>
            <td>Fiche détaillée</td>
        </tr>
    </thead>
    <tbody>
<?php

$sameId = 1;
$nbTel = count($clients);

foreach ($clients as $key => $line) {

    echo("<tr>\n");
    if ($sameId === 1) {
        while ( $key + $sameId < $nbTel
            && $line->id_client === $clients[ $key + $sameId ]->id_client) {

            $sameId = $sameId +1;
        }
        ?>

        <td rowspan=<?= $sameId ?> > <?= $line->id_client ?> </td>
        <td rowspan=<?= $sameId ?> > <?= $line->nom_client ?> </td>
        <td rowspan=<?= $sameId ?> > <?= $line->nom_ville ?> </td>
        <td> <?= $line->numero_telephone ?> </td>
        <td rowspan=<?= $sameId ?> > <?= anchor(array("clients", "profil", $line->id_client), "Profil") ?></td>

    <?php
    } else {
    ?>

        <td> <?= $line->numero_telephone ?> </td>

        <?php
        $sameId = $sameId -1;
    }

    echo("</tr>\n");
}
?>

    </tbody>
</table>
</div>

<?php
