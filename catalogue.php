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
    <form method="POST" action="catalogue.php">
    <table>
        <tr>
            <td>Rechercher  <select name="searchMode">
                <option value="film">un film</option>
                <option value="acteur">un acteur</option>
                <option value="realisateur">un réalisateur</option>
            <select></td>
            <td><input type="search" name="searchDemand"/></td>
        </tr>
        <tr>
            <td>Trier  <select name="sortMode">
                <option value="alpha">Alphabétiquement</option>
                <option value="date">du plus récent au plus ancien</option>
                <option value="boxoffice">par score au box office</option>
            <select></td>
        </tr>
        <tr>
            <td colspan=3><input type="submit" value="Rechercher"></td>
        </tr>

        <!-- Optionnel, vérifie qu'il y a bien eu une recherche dans le champs de recherche-->
        <tr><tr></tr>
            <td>Vous avez recherché : </td>
            <td colspan=2>
            <?php
            if (isset($_POST['searchDemand']) == false){
                echo "Rien";
            } else {
                echo $_POST['searchDemand'];
            }
            ?>
            </td>
        </tr>
    </table>
</form>




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
                <td>Score au box office (en M$) </td>
                <td>Durée (en minutes)</td>
                <td>Langue</td>
                <td>Genre(s)</td>
                <td>Ajouter film</td>
                <td>Critiques</td>
                <td>Acteurs</td>
                <td>Réalisateurs</td>
                <?php
                if ($isadmin == 1) {
                echo "<td>Actions d'administrateur</td>";
            }
                ?>
            </tr>
            <?php
            if (isset($_POST['searchMode']) && isset($_POST['sortMode'])) {
                $sql = "SELECT titre, synopsis, datesortie, boxoffice, dureeminutesfilm, vofilm FROM cinecrit.film";

                // gestion des trois cas de Rechercher
                if ($_POST['searchMode'] == 'film') {
                    $sql .= " WHERE UPPER(cinecrit.film.titre) LIKE CONCAT('%',UPPER(?),'%')";

                } else if ($_POST['searchMode'] == 'acteur') {
                    $sql .= " NATURAL JOIN cinecrit.jouer NATURAL JOIN cinecrit.personnalite WHERE UPPER(CONCAT(cinecrit.personnalite.prenomperso, ' ', cinecrit.personnalite.nomperso)) LIKE CONCAT('%',UPPER(?),'%')";

                } else if ($_POST['searchMode'] == 'realisateur') {
                    $sql .= " NATURAL JOIN cinecrit.realise NATURAL JOIN cinecrit.personnalite WHERE UPPER(CONCAT(cinecrit.personnalite.prenomperso, ' ', cinecrit.personnalite.nomperso)) LIKE CONCAT('%',UPPER(?),'%')";
                }

                if ($_POST['sortMode'] == 'alpha') {
                    $sql .= " ORDER BY cinecrit.film.titre;";

                } else if ($_POST['sortMode'] == 'date') {
                    $sql .= " ORDER BY cinecrit.film.datesortie;";

                } else if ($_POST['sortMode'] == 'boxoffice') {
                    $sql .= " ORDER BY cinecrit.film.boxoffice;";
                }

                $searchString = $_POST['searchDemand'];

                $prep = $cnx->prepare($sql);
                $prep->execute(array($searchString));

                $data = $prep->fetchAll();

            } else {
                $data = $cnx->query("SELECT * FROM cinecrit.film;")->fetchAll();
            }

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
                    echo "<a href=\"scriptsPHP/ajoutFilmVu.php?id=" . $row['idfilm'] . "\">J'ai vu ce film</a>";
                }
                echo "</td>";
                echo "<td>";
                echo "<a href=\"critique.php?id=" . $row['idfilm'] . "\">Critiques</a>";
                echo "</td>";
                echo "<td><a href=\"scriptsPHP/gestionActeur.php?idfilm=". $row['idfilm'] ."\">Gérer les acteurs</a></td>";
                echo "<td><a href=\"scriptsPHP/gestionRealisateur.php?idfilm=". $row['idfilm'] ." \">Gérer les réalisateurs</a></td>";

                if ($isadmin) {
                    echo "<td><a href=\"scriptsPHP/retirerFilmCatalogue.php?idfilm=". $row['idfilm'] ."\">Supprimer ce film</a></td>";
                }
                echo "</tr>";
            }
            ?>

        </table>
    </div>
</body>

</html>
