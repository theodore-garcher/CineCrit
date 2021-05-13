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
    <h1>Catalogue de films</h1>
    <div class="catalog">
        <?php
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 't') {
            $isadmin = true;
        } else {
            $isadmin = false;
        }
        ?>
        <table>
            <tr>
                <td>Titre</td>
                <td>Synopsis</td>
                <td>Date de sortie</td>
                <td>Score au box office</td>
                <td>Durée</td>
                <td>Langue</td>
                <td>Genre(s)</td>
                <td>Ajouter film</td>
                <?php
                if ($isadmin == 1) {
                echo "<td colspan=3>Actions d'administrateur</td>";
            }
                ?>
            </tr>
            <?php
            $data = $cnx->query("SELECT * FROM cinecrit.film;")->fetchAll();
            foreach ($data as $row) {
                echo "<tr class=\"catalogitem\">";
                echo "<td>" . $row['titre'] . "</td>";
                echo "<td>" . $row['synopsis'] . "</td>";
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
                $dataCheck = $cnx->query("SELECT * FROM cinecrit.filmvisionne WHERE cinecrit.filmvisionne.idfilm = " . $row['idfilm'] . " AND cinecrit.filmvisionne.iduser = " . $_SESSION['iduser'] . ";")->fetchAll();
                if (empty($dataCheck)) {
                    echo "<a href=\"scriptsPHP/ajoutFilmVu.php/?id=" . $row['idfilm'] . "\">J'ai vu ce film</a>";
                }
                echo "</td>";

                if ($isadmin) {
                    echo "<td><a href=\"\">Gérer les acteurs</a></td>";
                    echo "<td><a href=\"\">Gérer les résalisateurs</a></td>";
                    echo "<td><a href=\"\">Supprimer ce film</a></td>";
                }
                echo "</tr>";
            }
            ?>

        </table>
    </div>
</body>

</html>
