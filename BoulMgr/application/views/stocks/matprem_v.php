<h3>Matières premières</h3>

<?php
if(count($matprem) != 0)
{
    echo('
        <table>
            <tr>
                <td colspan="2">LA PHOTO</td>
            <tr />
            <tr>
                <td colspan="2">'.$matprem[0]['nom_matiere_premiere'].'</td>
            <tr />
            <tr>
                <td>'.$matprem[0]['disponibilite_matiere_premiere'].' pièces</td>
                <td>- +</td>
            </tr>
        </table>

        <p></p>
        <table>
            <tr>
                <td>ID</td>
                <td>Matière première</td>
                <td>Quantité disponible</td>
            </tr>');

    foreach($matprem as $result) {
        echo('
            <tr>
                <td>'.$result['id_matiere_premiere'].'</td>
                <td>'.$result['nom_matiere_premiere'].'</td>
                <td>'.$result['disponibilite_matiere_premiere'].' pièces</td>
            </tr>');
    }
    echo('</table>');
}

else
{
    echo('Aucune matière première existante.');
}
?>
