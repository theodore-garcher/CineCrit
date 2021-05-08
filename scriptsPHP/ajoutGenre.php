<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="title" content="Ajout d'un genre" />
</head>

<body>
    <?php
    include("connexion.inc.php");
    if (isset($_POST['code']) == false or isset($_POST['nom']) == false) {
        echo "Merci de passer par le panneau administrateur.";
    } elseif (strlen($_POST['code']) != 8) {
        echo "Erreur : le code doit comporter 8 caractères.";
    } else {
        $nom = $_POST['nom'];
        $code = $_POST['code'];
        $sql = "INSERT INTO cinecrit.genre (codegenre, nomgenre) VALUES (?,?)";
        $req = $cnx->prepare($sql);
        $req->execute([$code, $nom]);
        if ($req->rowCount() > 0) {
            echo "Le genre de nom " . $nom . " et de code " . $code . " a bien été ajouté.";
        } else {
            echo 'Erreur lors de l’ajout de votre genre.';
        }
    }
    ?>
    </br>
    <a href="../panneauAdmin.php">Retourner au panneau administrateur</a>
</body>

</html>