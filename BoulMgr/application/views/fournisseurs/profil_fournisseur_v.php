<h2>Profil de <?= $infos[0]->nom_fournisseur ?></h2>

<h3>adresses</h3>
<div>
    <table>
        <thead>
            <tr>
                <td colspan=3>adresse</td>
                <td>code postal</td>
                <td>ville</td>
                <td>description</td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($adresses as $value) {
                echo("<tr>
                    <td>".$value->num_voie."</td>
                    <td>".$value->lib_type_voie."</td>
                    <td>".$value->nom_voie."</td>
                    <td>".$value->code_postal."</td>
                    <td>".$value->nom_ville."</td>
                    <td>".$value->description_adresse."</td>
                    </tr>"
                );
            }

            ?>
        </tbody>
    </table>
</div>

<h3>numéros de téléphone</h3>
<div>
    <table>
        <thead>
            <tr>
                <td>numéro</td>
                <td>description</td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($telephones as $value) {
                echo("<tr>
                    <td>".$value->numero_telephone."</td>
                    <td>".$value->description_telephone."</td>
                    </tr>"
                );
            }

            ?>
        </tbody>
    </table>
</div>

<h3>produits vendus</h3>
<div>
    <table>
        <thead>
            <tr>
                <td>id</td>
                <td>matiere première</td>
                <td>prix</td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($matieres_premieres as $value) {
                echo("<tr>
                    <td>".$value->id_matiere_premiere."</td>
                    <td>".$value->nom_matiere_premiere."</td>
                    <td>".$value->prix."</td>
                    </tr>"
                );
            }

            ?>
        </tbody>
    </table>
</div>