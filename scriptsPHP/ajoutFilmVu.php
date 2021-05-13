<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="title" content="Ajout d'un film visionné" />
</head>

<body>
    <?php
    include("connexion.inc.php");
    session_start();
    if (isset($_GET['id']) == false) {
        echo "Merci de passer par le catalogue.";
    } else {
        $film = $_GET['id'];
        $sql = "INSERT INTO cinecrit.filmvisionne (idfilm, iduser) VALUES (?,?)";
        $req2 = $cnx->prepare($sql);
        $req2->execute([$film, $_SESSION['iduser']]);
        if ($req2->rowCount() > 0) {
            echo "Le film a bien été ajouté à votre liste.";
            header('Location: ../../panneauUser.php');
        } else {
            echo 'Erreur lors de l’ajout de votre film.';
        }
    }
    ?>
    </br>
    <a href="../catalogue.php">Retourner au catalogue</a>
</body>

</html>
