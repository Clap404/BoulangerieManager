
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

foreach ($fournisseurs as $line) {
    print("<tr>\n");
    foreach ($line as $value) {
        print("<td>" . $value . "</td>\n" );
    }
    print("<td>lien vers ".$line->id_fournisseur."</td>");
    print("</tr>\n");
}
?>

    </tbody>
</table>
</div>