<?php
include("../navbar.php");
include("connexion.inc.php");


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <?php
    if (!isset($_GET['idfilm'])) {
    ?>
    <link rel="stylesheet" href="../../css/main.css">
    <?php
    } else {
    ?>
    <link rel="stylesheet" href="../css/main.css">
    <?php
    }
    ?>
    <title>Acteurs</title>
</head>

<body>
    <?php
        if (isset($_GET['idfilm']) && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 't') {
        $prep = $cnx->prepare("SELECT titre FROM cinecrit.film WHERE idfilm = ?;");
        $prep->execute([intval($_GET['idfilm'])]);
        $data = $prep->fetchAll();
        $titrefilm = $data[0]['titre'];
    ?>
    <?php
    }
    if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 't') {
            echo "<p>Vous devez vous connecter en tant qu'administrateur.";
            echo "<a href=\"../connexionCompte.php\">Se connecter</a>";
    }
    if (!isset($_GET['idfilm'])) {
            echo "<p>Merci de passer par le catalogue.</p>";
            echo "<a href=\"../catalogue.php\">Aller au catalogue</a>";
        }

    ?>
</body>
