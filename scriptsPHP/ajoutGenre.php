<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="title" content="Ajout d'un genre" />
</head>

<body>
    <?php
    include("connexion.inc.php");
    if (isset($_POST['nom']) == false) {
        echo "Merci de passer par le panneau administrateur.";
    } else {
        $nom = $_POST['nom'];
        $sql = "INSERT INTO cinecrit.genre (nomgenre) VALUES (?)";
        $req = $cnx->prepare($sql);
        $req->execute([$nom]);
        if ($req->rowCount() > 0) {
            echo "Le genre " . $nom . " a bien été ajouté.";
        } else {
            echo 'Erreur lors de l’ajout de votre genre.';
        }
    }
    ?>
    </br>
    <a href="../panneauAdmin.php">Retourner au panneau administrateur</a>
</body>

</html>