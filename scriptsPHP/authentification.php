<?php
session_start();
include("connexion.inc.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Authentification</title>
</head>

<body>
    <?php
    $pseudo = $_POST['pseudo'];
    $mdp = md5($_POST['mdp']);
    $requete = "SELECT * FROM cinecrit.utilisateur WHERE cinecrit.utilisateur.pseudouser LIKE '" . $pseudo . "';";
    $data = $cnx->query($requete)->fetchAll();
    if (empty($data)) {
        echo "Pseudo incorrect";
    } else {
        foreach ($data as $row) {
            $crypted = $row['motdepasse'];
            $isAdmin = $row['isadmin'];
            $iduser = $row['iduser'];
        }
        if (!($mdp == $crypted)) {
            echo "mot de passe incorrect";
        } else {
            echo "Authentification réussie";
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['isAdmin'] = $isAdmin;
            $_SESSION['iduser'] = $iduser;
            header('Location: ../catalogue.php');
        }
    }
    ?>
    <br>
    <p><a href="../connexionCompte.php">Retourner à l'écran de connexion</a></p>
</body>

</html>
