<?php
include("scriptsPHP/connexion.inc.php");
include("navbar.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Panneau d'administrateur</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <h1>Ajout d'un genre</h1>
    <form method="POST" action="scriptsPHP/ajoutGenre.php">
        <table>
            <tr>
                <td>Nom du genre</td>
                <td><input type="text" name="nom" required></td>
            </tr>
        </table><br />
        <input type="reset" name="reset" value="Annuler" />
        <input type="submit" name="submit" value="Valider" />
    </form>
    <h1>Ajout d'un producteur</h1>
    <form method="POST" action="scriptsPHP/ajoutProd.php">
        <table>
            <tr>
                <td>Nom de la société de production</td>
                <td><input type="text" name="nom" required></td>
            </tr>
            <tr>
                <td>Nationalité (2 caractères)</td>
                <td><input type="text" name="nat" required></td>
            </tr>
        </table><br />
        <input type="reset" name="reset" value="Annuler" />
        <input type="submit" name="submit" value="Valider" />
    </form>
    <h1>Ajout d'une personnalité</h1>
    <form method="POST" action="scriptsPHP/ajoutPerso.php">
        <table>
            <tr>
                <td>Prénom</td>
                <td><input type="text" name="prenom" required></td>
            </tr>
            <tr>
                <td>Nom</td>
                <td><input type="text" name="nom" required></td>
            </tr>
            <tr>
                <td>Date de naissance (jj-mm-aaaa)</td>
                <td><input type="date" name="naissance" required></td>
            </tr>
            <tr>
                <td>Nationalité (2 caractères)</td>
                <td><input type="text" name="nat" required></td>
            </tr>
        </table><br />
        <input type="reset" name="reset" value="Annuler" />
        <input type="submit" name="submit" value="Valider" />
    </form>
    <h1>Ajout d'un film</h1>
    <form method="POST" action="scriptsPHP/ajoutFilm.php">
        <table>
            <tr>
                <td>Titre</td>
                <td><input type="text" name="titre" required></td>
            </tr>
            <tr>
                <td>Date de sortie</td>
                <td><input type="date" name="sortie" required></td>
            </tr>
            <tr>
                <td>Score au box office</td>
                <td><input type="number" name="box" required></td>
            </tr>
            <tr>
                <td>Durée</td>
                <td><input type="number" name="duree" required></td>
            </tr>
            <tr>
                <td>Langue de la VO</td>
                <td><input type="text" name="langue" required></td>
            </tr>
            <tr>
                <td>Genre</td>
                <td>
                    <?php
                    $data = $cnx->query("SELECT * FROM cinecrit.genre")->fetchAll();
                    foreach ($data as $row) {
                        echo '<input type="checkbox" name="genre[]" value="' . $row['codegenre'] . '" /> ' . $row['nomgenre'] . '<br />';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Synopsis</td>
                <td><textarea name="synopsis" rows="5" cols="50"></textarea></td>
            </tr>
        </table><br />
        <input type="reset" name="reset" value="Annuler" />
        <input type="submit" name="submit" value="Valider" />
    </form>
    <h1>Gérer des Administrateurs</h1>
    <form method="POST" action="panneauAdmin.php">
        <table>
            <tr>
                <td>Rechercher un utilisateur</td>
                <td><input type="search" name="searchDemand"/></td>
                <td><input type="submit" value="Rechercher"></td>
            </tr>
            <!-- Optionnel, vérifie qu'il y a bien eu une recherche dans le champs de recherche-->
            <tr>
                <td>Vous avez recherché :</td>
                <td>
                <?php
                if (isset($_POST['searchDemand']) == false){
                    echo "Rien";
                } else {
                    echo $_POST['searchDemand'];
                }
                ?>
                </td>
            </tr>
        </table>
    </form>
    <div class="catalog">
        <table>
            <tr>
                <td>Pseudo</td>
                <td>Action</td>
            </tr>
            <?php
            if (isset($_POST['searchDemand']) == false){
                $data = $cnx->query("SELECT iduser, pseudouser, isadmin  FROM cinecrit.utilisateur;")->fetchAll();
            } else {
                $searchString = $_POST['searchDemand'];
                // système de protection contre l'injection SQL
                $prep = $cnx->prepare("SELECT iduser, pseudouser, isadmin FROM cinecrit.utilisateur WHERE UPPER(pseudouser) LIKE CONCAT('%',UPPER(?),'%');");
                $prep->execute([$searchString]);
                $data = $prep->fetchAll();
            }
            foreach ($data as $row){
                echo "<tr class=\"catalogitem\"><td>". $row['pseudouser'] ."</td>";

                if ($row['pseudouser'] != 'admin') {
                    if ($row['isadmin']) {
                        $td = "<td><a href=\"scriptsPHP/gestionAdmin.php/?iduser=". $row['iduser'] ."&setadmin=false\">Retirer les droits</a></td>";
                    } else {
                        $td = "<td><a href=\"scriptsPHP/gestionAdmin.php/?iduser=". $row['iduser'] ."&setadmin=true\">Ajouter les droits</a></td>";
                    }
                } else {
                    $td = "<td></td>";
                }

                echo $td;
            }
            ?>
        </table>
    </div>

</body>

</html>
