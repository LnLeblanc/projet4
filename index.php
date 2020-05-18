<?php
session_start(); 
if(!isset($_SESSION['info'])) 
{
    $_SESSION['info'] = '';    
}

// création et utilisation d'un objet routeur
require('controleur/Routeur.php');

$routeur = new Routeur();
$routeur->routerRequete();