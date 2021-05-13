<?php session_start();
if ((!isset($_SESSION['pseudo'])) || (!isset($_SESSION['mdp']))) {
    header('Location: connexionCompte.php');
}
?>
<div class="navbar">
    <ul>
        <li><a href="../catalogue.php">Catalogue</a></li>
        <li><a href="../panneauUser.php">Panneau de <?php echo $_SESSION['pseudo']; ?></a></li>
        <?php
        if ($_SESSION['isAdmin'] == 't') {
            echo "<li><a href=\"../panneauAdmin.php\">Panneau administrateur</a></li>";
        }
        ?>
        <li><a href="../scriptsPHP/deconnexion.php">Déconnexion</a></li>
    </ul>
</div>