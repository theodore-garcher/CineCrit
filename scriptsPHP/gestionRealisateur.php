<?php
include("../navbar.php");
include("connexion.inc.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/main.css">
    <title>Acteurs</title>
</head>

<body>
    <?php
        $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 't');

        if (isset($_GET['idfilm'])) {
        $prep = $cnx->prepare("SELECT titre FROM cinecrit.film WHERE idfilm = ?;");
        $prep->execute([intval($_GET['idfilm'])]);
        $count = $prep->rowCount();
            if ($count < 1) {
                echo "<p>Le film demandé n'est pas repertorié, veuillez passer par le <a href=\"../catalogue.php\">Catalogue</a>.</p>";
            } else {
            $data = $prep->fetchAll();
            $titrefilm = $data[0]['titre'];

            //Gestion ajout/retrait
            if ($isAdmin && !empty($_POST) && isset($_POST["idperso"])) {
                if (isset($_POST["action"]) &&  $_POST["action"] == "Retirer") {
                    $prep = $cnx->prepare("DELETE FROM cinecrit.realise WHERE idfilm = ? AND idpersonalite = ?");
                    $prep->execute([$_GET["idfilm"], $_POST["idperso"]]);

                } else if (isset($_POST["action"]) &&  $_POST["action"] == "Ajouter") {
                    $prep = $cnx->prepare("INSERT INTO cinecrit.realise (idfilm, idpersonalite) VALUES (? , ?)");
                    $prep->execute([$_GET["idfilm"], $_POST["idperso"]]);
                }
            }


            // Insérer ici le code pour l'utilisation normale
            echo "<h1>Personne(s) ayant réalisé ". $titrefilm ."</h1>";
            ?>
            <div class="catalog">
                <table>
                <tr>
                    <td>Nom</td>
                    <td>Date de Naissance</td>
                    <td>Nationalité</td>
                    <?php
                    if ($isAdmin) {
                        echo "<td>Action administrateur</td>";
                    }
                    ?>
                </tr>

                <?php
                    $data = $cnx->query("SELECT * FROM cinecrit.personnalite NATURAL JOIN cinecrit.realise NATURAL JOIN cinecrit.film");
                    $count = $data->rowCount();

                    if ($count > 0) {
                        foreach ($data as $row) {
                            echo "<tr>";
                            echo "<td>". $row["prenomperso"] ." ". $row["nomperso"] ."</td>";
                            echo "<td>". $row["datenaissance"] ."</td>";
                            echo "<td>". $row["nationaliteperso"] ."</td>";

                            if ($isAdmin) {
                                ?>
                                <td>
                                    <?php
                                     echo "<form method=\"POST\" action=\"gestionRealisateur.php?idfilm=". $_GET['idfilm'] ."\">";
                                     echo "<input type=\"hidden\" name=\"idperso\" value=\"". $row["idpersonalite"] ."\"/>";
                                    ?>

                                        <input type="submit" name=action value="Retirer"/>
                                    </form>
                                </td>
                                <?php
                            }

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan=4><p>Aucun réalisateur n'a été enregistré.</p></td></tr>";
                    }


                ?>
            </table>

            </br>
            <?php
            if ($isAdmin) {
                echo "<h1>Ajouter des réalisateurs</h1>";
                echo "<h2>Rechercher un réalisateur</h2>";
                echo "<form method=\"POST\" action=\"gestionRealisateur.php?idfilm=". $_GET['idfilm'] ."\">";
                ?>
                <table>
                    <tr>
                        <td>Rechercher une personnalité</td>
                        <td><input type="search" name="searchDemandPerso"/></td>
                        <td><input type="submit" value="Rechercher"></td>
                    </tr>
                    <!-- Optionnel, vérifie qu'il y a bien eu une recherche dans le champs de recherche-->
                    <tr>
                        <td>Vous avez recherché : </td>
                        <td colspan=2>
                        <?php
                        if (isset($_POST['searchDemandPerso']) == false){
                            echo "Rien";
                        } else {
                            echo $_POST['searchDemandPerso'];
                        }
                        ?>
                        </td>
                    </tr>
                </table>
                </form>



                <div class="catalog">
                    <table>
                    <tr>
                        <td>Nom</td>
                        <td>Date de Naissance</td>
                        <td>Nationalité</td>
                        <td>Action administrateur</td>
                    </tr>

                    <?php

                        if (isset($_POST['searchDemandPerso']) == false){
                            $prep = $cnx->prepare("SELECT * FROM cinecrit.personnalite WHERE cinecrit.personnalite.idpersonalite NOT IN (SELECT cinecrit.personnalite.idpersonalite FROM cinecrit.personnalite JOIN cinecrit.realise ON (cinecrit.personnalite.idpersonalite = cinecrit.realise.idpersonalite AND cinecrit.realise.idfilm = ?))");
                            $prep->execute([$_GET["idfilm"]]);
                            $data = $prep->fetchAll();

                        } else {
                            $searchString = $_POST['searchDemandPerso'];
                            $prep = $cnx->prepare("SELECT * FROM cinecrit.personnalite WHERE cinecrit.personnalite.idpersonalite NOT IN (SELECT cinecrit.personnalite.idpersonalite FROM cinecrit.personnalite JOIN cinecrit.realise ON (cinecrit.personnalite.idpersonalite = cinecrit.realise.idpersonalite AND cinecrit.realise.idfilm = ?)) AND CONCAT(UPPER(cinecrit.personnalite.prenomperso), UPPER(cinecrit.personnalite.nomperso)) LIKE CONCAT('%',UPPER(?),'%');");
                            $prep->execute([$_GET["idfilm"], $searchString]);

                            $data = $prep->fetchAll();
                        }



                        foreach ($data as $row) {
                            echo "<tr>";
                            echo "<td>". $row["prenomperso"] ." ". $row["nomperso"] ."</td>";
                            echo "<td>". $row["datenaissance"] ."</td>";
                            echo "<td>". $row["nationaliteperso"] ."</td>";
                            echo "<td><form method=\"POST\" action=\"gestionRealisateur.php?idfilm=". $_GET['idfilm'] ."\">";
                            echo "<input type=\"hidden\" name=\"idperso\" value=\"". $row["idpersonalite"] ."\"/>";
                            echo "<input type=\"submit\" name=action value=\"Ajouter\"/></form></td>";
                            echo "</tr>";
                        }
                    ?>

                <?php
            }

            }
        }
        if (!isset($_GET['idfilm'])) {
                echo "<p>Merci de passer par le catalogue.</p>";
                echo "<a href=\"../catalogue.php\">Aller au catalogue</a>";
        }

    ?>
</body>
