<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="title" content="Ajout d'un utilisateur" />
</head>

<body>
    <?php
    include("connexion.inc.php");
    if (isset($_POST['pseudo']) == false) {
        echo "Merci de passer par le formulaire de création de compte.";
    } else {
        $pseudo = $_POST['pseudo'];
        $mail = $_POST['mail'];
        $mdp = $_POST['mdp'];
        $sexe = $_POST['sexe'];
        $isadmin = 'false';
        $dataPseudo = $cnx->query("SELECT * FROM cinecrit.utilisateur WHERE cinecrit.utilisateur.pseudouser LIKE '" . $pseudo . "';")->fetchAll();
        $dataMail = $cnx->query("SELECT * FROM cinecrit.utilisateur WHERE cinecrit.utilisateur.mailuser LIKE '" . $mail . "';")->fetchAll();
        if (!empty($dataPseudo)) {
            echo "Le pseudo est déjà pris.";
        } else if (!empty($dataMail)) {
            echo "Cette adresse mail est déjà prise.";
        } else {
            $sql = "INSERT INTO cinecrit.utilisateur (pseudouser, mailuser, motdepasse, sexeuser, isadmin) VALUES (?,?,?,?,?)";
            $req = $cnx->prepare($sql);
            $req->execute([$pseudo, $mail, $mdp, $sexe, $isadmin]);
            if ($req->rowCount() > 0) {
                echo "L'utilisateur " . $pseudo . " a bien été ajouté.";
            } else {
                echo 'Erreur lors de l’ajout de votre producteur.';
            }
        }
    }
    ?>
    </br>
    <p><a href="../connexionCompte.php">Retourner à l'écran de connexion</a></p>
</body>

</html>