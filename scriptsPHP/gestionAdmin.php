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
    if (isset($_GET['setadmin']) && isset($_GET['iduser'])) {
        $setadmin = ($_GET['setadmin'] == 'true') ? 1 : 0;
        $iduser = intval($_GET['iduser']);

        $prep = $cnx->prepare("UPDATE cinecrit.utilisateur SET isadmin = ? WHERE iduser = ?;");
        $prep->execute([$setadmin, $iduser]);

        $prep = $cnx->prepare("SELECT pseudouser FROM cinecrit.utilisateur WHERE iduser = ?;");
        $prep->execute([$iduser]);
        $data = $prep->fetchAll();

        if ($setadmin) {
            echo "<p>L'utilisateur ". $data[0]['pseudouser'] ." a bien été ajouté au groupe des administrateurs.</p>";
        } else {
            echo "<p>L'utilisateur ". $data[0]['pseudouser'] ." a bien été retiré du groupe des administrateurs.</p>";
        }
    }
    ?>
    <a href="../../panneauAdmin.php">Retourner au panneau administrateur</a>
</body>
</html>
