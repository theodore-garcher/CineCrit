<?php
include("scriptsPHP/connexion.inc.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Créer un compte</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <h1>Créer votre compte Cinécrit</h1>
    <form method="POST" action="scriptsPHP/ajoutUser.php">
        <table>
            <tr>
                <td>Pseudo</td>
                <td><input type="text" name="pseudo" required></td>
            </tr>
            <tr>
                <td>Adresse mail</td>
                <td><input type="text" name="mail" required></td>
            </tr>
            <tr>
                <td>Mot de passe</td>
                <td><input type="password" name="mdp" required></td>
            </tr>
            <tr>
                <td><input type="radio" name="sexe" value="m" required />Homme<br /></td>
                <td><input type="radio" name="sexe" value="f" required />Femme<br /></td>
            </tr>
        </table><br />
        <input type="reset" name="reset" value="Annuler" />
        <input type="submit" name="submit" value="Valider" />
    </form>
</body>

</html>