<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="title" content="Ajout d'une personnalité" />
</head>

<body>
    <?php
    include("connexion.inc.php");
    if (isset($_POST['nom']) == false or isset($_POST['nat']) == false or isset($_POST['prenom']) == false  or isset($_POST['naissance']) == false) {
        echo "Merci de passer par le panneau administrateur.";
    } else {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $nat = $_POST['nat'];
        $naissance = $_POST['naissance'];
        $sql = "INSERT INTO cinecrit.personnalite (nomperso, prenomperso, datenaissance, nationaliteperso) VALUES (?,?,?,?)";
        $req = $cnx->prepare($sql);
        $req->execute([$nom, $prenom, $naissance, $nat]);
        if ($req->rowCount() > 0) {
            echo $prenom . " " . $nom . " de nationalité " . $nat . " et né le " . $naissance . " a bien été ajouté.";
        } else {
            echo 'Erreur lors de l’ajout de votre personnalité.';
        }
    }
    ?>
    </br>
    <a href="../panneauAdmin.php">Retourner au panneau administrateur</a>
</body>

</html>