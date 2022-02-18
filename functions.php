<?php
// les fonctions
require_once PATH_MODELS . 'SimpleOrm.php';

/**
 * Se connecte à la base de données
 */
function connexion(){
    $connexion = new mysqli('localhost', 'root', '');
    if ($connexion->connect_error) die('Impossible de se connecter à la BDD.');

    SimpleOrm::useConnection($connexion, 'projet_php');
}


/**
 * renvoie l'url correspondante à la route fournie
 * @param string $route le nom de la route
 * @param int $id l'id à ajouter dans l'url si nécessaire
 * @return string l'url pour le routeur
 */
function url(string $route,int $id=-1):string{
    return 'index.php?route='.$route.(($id!==-1)?"&id=$id":'');
}