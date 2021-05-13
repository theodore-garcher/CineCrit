<?php
include("scriptsPHP/connexion.inc.php");
include("navbarGET.php");
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
    <link rel="stylesheet" href="../css/main.css">
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
    <form action="../scriptsPHP/ajoutCritique.php" method="post">
        <table>
            <tr>
                <td><label for="note">Note</label></td>
                <td><input type="text" name="note" /></td>
            </tr>
            <tr>
                <td><label for="mdp">Votre critique</label></td>
                <td><input type="password" name="mdp" /></td>
            </tr>
        </table>
        <br>
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
        <tr>
            <?php
            $datagenre = $cnx->query("SELECT * FROM cinecrit.critique NATURAL JOIN cinecrit.utilisateur NATURAL JOIN cinecrit.film WHERE cinecrit.critique.idfilm = " . $film . ";")->fetchAll();
            foreach ($datagenre as $row) {
                echo "<td>" . $row['pseudouser'] . "</td>";
                echo "<td>" . $row['notecrit'] . "/5</td>";
                echo "<td>" . $row['textecrit'] . "</td>";
            }
            ?>
        </tr>
    </table>
</body>

</html>