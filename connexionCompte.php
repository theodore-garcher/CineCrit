<?php
include("scriptsPHP/connexion.inc.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Page de connexion</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body class="connect">
    <h1>Connectez-vous à votre compte Cinécrit</h1>
    <p>Accès administrateur : pseudo = admin, mdp = admin</p>
    <form action="scriptsPHP/authentification.php" method="post">
        <table>
            <tr>
                <td><label for="pseudo">Pseudo</label></td>
                <td><input type="text" name="pseudo" /></td>
            </tr>
            <tr>
                <td><label for="mdp">Mot de passe</label></td>
                <td><input type="password" name="mdp" /></td>
            </tr>
        </table>
        <br>
        <input type="reset" name="reset" value="Effacer" />
        <input type="submit" name="submit" value="Valider" />
    </form>
    <br>
    <p><a href="creationCompte.php">Se créer un compte</a></p>
</body>

</html>
