<?php
include("scriptsPHP/connexion.inc.php");
include("navbar.php");
$film = $_GET['id'];
$data = $cnx->query("SELECT * FROM cinecrit.film WHERE cinecrit.film.idfilm = " . $film . ";")->fetchAll();
foreach ($data as $row) {
    $titre = $row['titre'];
    $sortie = $row['datesortie'];
    $box = $row['boxoffice'];
    $duree = $row['dureeminutesfilm'];
    $vo = $row['vofilm'];
    $synopsis = $row['synopsis'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/main.css">
    <title>Critiques : <?php echo $titre; ?></title>

</head>

<body>
    <h1><?php echo $titre; ?></h1>
    <table>
        <tr>
            <td>Date de sortie</td>
            <td><?php echo $sortie; ?></td>
        </tr>
        <tr>
            <td>Score au box office</td>
            <td><?php echo $box; ?></td>
        </tr>
        <tr>
            <td>Durée</td>
            <td><?php echo $duree; ?></td>
        </tr>
        <tr>
            <td>Langue</td>
            <td><?php echo $vo; ?></td>
        </tr>
        <tr>
            <td>Genre(s)</td>
            <td><?php
                $datagenre = $cnx->query("SELECT * FROM cinecrit.genre NATURAL JOIN cinecrit.qualifier NATURAL JOIN cinecrit.film WHERE cinecrit.qualifier.idfilm = " . $row['idfilm'] . ";")->fetchAll();
                foreach ($datagenre as $row) {
                    echo $row['nomgenre'] . " ";
                }
                ?></td>
        </tr>
        <tr>
            <td>Synopsis</td>
            <td><?php echo $synopsis; ?></td>
        </tr>
    </table>
    <h2>Ajouter une critique pour ce film</h2>
    <form action="scriptsPHP/ajoutCritique.php" method="post">
        <table>
            <tr>
                <td><label for="note">Note</label></td>
                <td>
                    <select name="note">
                        <option selected="selected">-- note --</option>
                        <option name="note" value="1">1</option>
                        <option name="note" value="2">2</option>
                        <option name="note" value="3">3</option>
                        <option name="note" value="4">4</option>
                        <option name="note" value="5">5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="textecrit">Votre critique</label></td>
                <td><textarea name="textecrit" rows="5" cols="50"></textarea></td>
            </tr>
        </table>
        <br>
        <input type="hidden" name="idfilm" value="<?php echo $film; ?>">
        <input type="reset" name="reset" value="Effacer" />
        <input type="submit" name="submit" value="Valider" />
    </form>
    <h2>Critiques des utilisateurs</h2>
    <table>
        <tr>
            <td>Pseudo</td>
            <td>Note</td>
            <td>Critique</td>
        </tr>
        <?php
        $data = $cnx->query("SELECT * FROM cinecrit.critique NATURAL JOIN cinecrit.utilisateur NATURAL JOIN cinecrit.film WHERE cinecrit.critique.idfilm = " . $film . ";")->fetchAll();
        foreach ($data as $row) {
            echo "<tr>";
            echo "<td>" . $row['pseudouser'] . "</td>";
            echo "<td>" . $row['notecrit'] . "/5</td>";
            echo "<td>" . $row['textecrit'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>
