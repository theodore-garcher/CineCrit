<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="title" content="Retrait d'un film visionné" />
</head>

<body>
    <?php
    include("connexion.inc.php");
    session_start();
    if (isset($_GET['id']) == false) {
        echo "Merci de passer par le catalogue.";
    } else {
        $film = $_GET['id'];
        $sql = "DELETE FROM cinecrit.filmvisionne WHERE cinecrit.filmvisionne.idfilm = " . $film . " ;";
        $req2 = $cnx->prepare($sql);
        $req2->execute();
        if ($req2->rowCount() > 0) {
            echo "Le film a bien été retiré de votre liste.";
            header('Location: ../panneauUser.php');
        } else {
            echo 'Erreur lors du retrait de votre film.';
        }
    }
    ?>
    </br>
    <a href="../catalogue.php">Retourner au catalogue</a>
</body>

</html>
