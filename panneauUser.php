<?php
include("scriptsPHP/connexion.inc.php");
include("navbar.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/main.css">
    <title>Catalogue</title>
</head>

<body>
    <h1>Vos films visionnés</h1>
    <div class="catalog">
        <table>
            <tr>
                <td>Titre</td>
                <td>Date de sortie</td>
                <td>Score au box office</td>
                <td>Durée</td>
                <td>Langue</td>
                <td>Genre(s)</td>
                <td>Ajouter critique</td>
            </tr>
            <?php
            $data = $cnx->query("SELECT * FROM cinecrit.film NATURAL JOIN cinecrit.filmvisionne NATURAL JOIN cinecrit.utilisateur WHERE cinecrit.utilisateur.pseudouser LIKE '" . $_SESSION['pseudo'] . "';")->fetchAll();
            foreach ($data as $row) {
                echo "<tr>";
                echo "<td>" . $row['titre'] . "</td>";
                echo "<td>" . $row['datesortie'] . "</td>";
                echo "<td>" . $row['boxoffice'] . "</td>";
                echo "<td>" . $row['dureeminutesfilm'] . "</td>";
                echo "<td>" . $row['vofilm'] . "</td>";
                echo "<td>";
                $datagenre = $cnx->query("SELECT * FROM cinecrit.genre NATURAL JOIN cinecrit.qualifier NATURAL JOIN cinecrit.film WHERE cinecrit.qualifier.idfilm = " . $row['idfilm'] . ";")->fetchAll();
                foreach ($datagenre as $row) {
                    echo $row['nomgenre'] . " ";
                }
                echo "</td>";
                echo "<td>";
                echo "<form method=\"POST\" action=\"scriptsPHP/ajoutCritique.php\">";
                echo "<input type=\"radio\" name=\"film\" value=\"" . $row['idfilm'] . "\" checked hidden/>";
                echo "<input type=\"submit\" name=\"submit\" value=\"Ajouter\" /></form>";
                echo "</td></tr>";
            }
            ?>

        </table>
    </div>
</body>

</html>