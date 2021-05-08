<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="title" content="Ajout d'une personnalité" />
</head>

<body>
    <?php
    include("connexion.inc.php");
    if (isset($_POST['titre']) == false) {
        echo "Merci de passer par le panneau administrateur.";
    } else {
        $titre = $_POST['titre'];
        $sortie = $_POST['sortie'];
        $box = $_POST['box'];
        $duree = $_POST['duree'];
        $langue = $_POST['langue'];
        $genre = $_POST['genre'];

        $sql = "INSERT INTO cinecrit.film (datesortie, boxoffice, dureeminutesfilm, vofilm, titre) VALUES (?,?,?,?,?) RETURNING idfilm";
        $req = $cnx->prepare($sql);
        $req->execute([$sortie, $box, $duree, $langue, $titre]);
        $data = $req->fetch(\PDO::FETCH_ASSOC);
        foreach ($data as $row) {
            $idfilm = $row;
        }
        foreach ($genre as $item) {
            $sql = "INSERT INTO cinecrit.qualifier (idfilm, codegenre) VALUES (?,?)";
            $req2 = $cnx->prepare($sql);
            $req2->execute([$idfilm, $item]);
        }
        if ($req->rowCount() > 0) {
            echo $titre . " a bien été ajouté.";
        } else {
            echo 'Erreur lors de l’ajout de votre film.';
        }
    }
    ?>
    </br>
    <a href="../panneauAdmin.php">Retourner au panneau administrateur</a>
</body>

</html>