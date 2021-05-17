<?php
include("../navbar.php");
include("connexion.inc.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/main.css">
    <title>Acteurs</title>
</head>

<body>
    <?php
        if (isset($_GET['idfilm']) && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 't') {
        $prep = $cnx->prepare("SELECT titre FROM cinecrit.film WHERE idfilm = ?;");
        $prep->execute([intval($_GET['idfilm'])]);
        $count = $prep->rowCount();
        if ($count < 1) {
            echo "<p>Le film demandé n'est pas repertorié, veuillez passer par le <a href=\"../catalogue.php\">Catalogue</a>.</p>";
        } else {
            $data = $prep->fetchAll();
            $titrefilm = $data[0]['titre'];

            // Insérer ici le code pour l'utilisation normale
            echo "<h1> Suppression du film : ". $titrefilm ."</h1>";

            $prep = $cnx->prepare("DELETE FROM cinecrit.film WHERE idfilm = ?");
            $prep->execute([$_GET['idfilm']]);
            $count = $prep->rowCount();
            if ($count > 0) {
                echo "Le film a bien été supprimé.";
            } else {
                echo "Le film n'a pas pu être supprimé.";

            }
        }
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
