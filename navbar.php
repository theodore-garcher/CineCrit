<?php session_start();
if ((!isset($_SESSION['pseudo'])) || (!isset($_SESSION['mdp']))) {
    header('Location: connexionCompte.php');
}

$url = $_SERVER['REQUEST_URI'];
$script = "/scriptsPHP/";

$str = (strpos($url, $script) !== false) ? "../" : "";
?>


<div class="navbar">
    <ul>
        <?php
        echo "<li><a href=\"". $str ."catalogue.php\">Catalogue</a></li>";
        echo "<li><a href=\"". $str ."panneauUser.php\">Panneau de <?php echo ". $_SESSION['pseudo'] ."; ?></a></li>";

        if ($_SESSION['isAdmin'] == 't') {
            echo "<li><a href=\"". $str ."panneauAdmin.php\">Panneau administrateur</a></li>";
        }
        echo "<li><a href=\"". $str ."scriptsPHP/deconnexion.php\">Déconnexion</a></li>";
        ?>
    </ul>
</div>
