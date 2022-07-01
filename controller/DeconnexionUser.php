<?php
// Permet de se deconnecter en detruisant la session actuelle
$_SESSION = array();
var_dump($_SESSION);
session_destroy();

header("location: index.php?connexion");
