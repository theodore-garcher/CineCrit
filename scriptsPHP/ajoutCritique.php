<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="title" content="Ajout d'une critique" />
</head>

<body>
    <?php
    include("connexion.inc.php");
    session_start();
    if (isset($_POST['note']) == false or isset($_POST['textecrit']) == false) {
        echo "Merci de passer par la page critique.";
    } else {
        $note = $_POST['note'];
        $textecrit = $_POST['textecrit'];
        $idfilm = $_POST['idfilm'];
        $sql = "INSERT INTO cinecrit.critique (notecrit, textecrit, idfilm, iduser) VALUES (?,?,?,?)";
        $req = $cnx->prepare($sql);
        $req->execute([$note, $textecrit, $idfilm, $_SESSION['iduser']]);
        if ($req->rowCount() > 0) {
            echo "Votre critique a bien été ajoutée.";
            header('Location: ../panneauUser.php');
        } else {
            echo 'Erreur lors de l’ajout de votre genre.';
        }
    }
    ?>
    </br>
    <a href="../catalogue.php">Retourner au catalogue</a>
</body>

</html>