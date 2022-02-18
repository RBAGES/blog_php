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



/**
 * Renvoie l'erreur correspondante au code fourni
 * @param int $code le code de l'erreur
 * @return string l'erreur formatée pour l'affichage
 */
function errorRoute(int $code):string{
    $error = '';
    switch ($code) {
        case 401:
            $error = 'Vous devez être authentifié pour accéder à cette page';
            break;
        case 404:
            $error = 'La page demandée n\'existe pas';
            break;
        case 403:
            $error = 'Vous n\'avez pas l\'autorisation d\'accéder à cette page';
            break;
        case 500:
            $error = 'Le serveur a eu un problème';
            break;
            // code custom qui correspond à un utilisateur déjà connecté
        case 100:
            $error = 'Vous êtes déjà connecté';
            break;
            // code custom qui correspond à une liste vide de produits 
        case 101:
            $error = 'Aucun produit n\'est disponible';
            break;
        
        default:
            $error = 'Erreur inconnue';
            break;
    }

    return $error.'<br><a href="'.url('home').'">Retour à la page d\'acceuil</a>';
}