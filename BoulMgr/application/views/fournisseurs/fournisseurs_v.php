
<div>
<table>
    <thead>
        <tr>
            <td>ID</td>
            <td>Nom du fournisseur</td>
            <td>Ville</td>
            <td>Numéro de téléphone</td>
            <td>Fiche détaillée</td>
        </tr>
    </thead>
    <tbody>
<?php

$sameId = 1;
$nbTel = count($fournisseurs);

foreach ($fournisseurs as $key => $line) {

    echo("<tr>\n");
    if ($sameId === 1) {
        while ( $key + $sameId < $nbTel
            && $line->id_fournisseur === $fournisseurs[ $key + $sameId ]->id_fournisseur) {

            $sameId = $sameId +1;
        }
        ?>

        <td rowspan=<?= $sameId ?> > <?= $line->id_fournisseur ?> </td>
        <td rowspan=<?= $sameId ?> > <?= $line->nom_fournisseur ?> </td>
        <td rowspan=<?= $sameId ?> > <?= $line->nom_ville ?> </td>
        <td> <?= $line->numero_telephone ?> </td>
        <td rowspan=<?= $sameId ?> > <?= anchor(array("fournisseurs", "profil", $line->id_fournisseur), "Profil") ?></td>

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
