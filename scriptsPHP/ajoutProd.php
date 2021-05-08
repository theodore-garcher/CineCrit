<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="title" content="Ajout d'un producteur" />
</head>

<body>
    <?php
    include("connexion.inc.php");
    if (isset($_POST['nom']) == false or isset($_POST['nat']) == false or isset($_POST['code']) == false) {
        echo "Merci de passer par le panneau administrateur.";
    } else {
        $nom = $_POST['nom'];
        $nat = $_POST['nat'];
        $code = $_POST['code'];
        $sql = "INSERT INTO cinecrit.production (codeprod, nomprod, nationaliteprod) VALUES (?,?,?)";
        $req = $cnx->prepare($sql);
        $req->execute([$code, $nom, $nat]);
        if ($req->rowCount() > 0) {
            echo "Le producteur de nom " . $nom . ", de nationalité " . $nat . " et de code " . $code . " a bien été ajouté.";
        } else {
            echo 'Erreur lors de l’ajout de votre producteur.';
        }
    }
    ?>
    </br>
    <a href="../panneauAdmin.php">Retourner au panneau administrateur</a>
</body>

</html>