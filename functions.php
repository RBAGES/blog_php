<?php
// les fonctions
require_once PATH_MODELS . 'SimpleOrm.php';

/**
 * Se connecte à la base de données
 */
function connexion()
{
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
function url(string $route, int $id = -1): string
{
    return 'index.php?route=' . $route . (($id !== -1) ? "&id=$id" : '');
}



/**
 * Renvoie l'erreur correspondante au code fourni
 * @param int $code le code de l'erreur
 * @return string l'erreur formatée pour l'affichage
 */
function errorMessage(int $code): string
{
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

    return $error . '<br><a href="' . url('home') . '">Retour à la page d\'acceuil</a>';
}

/**
 * retourne une version tronqué de la chaine
 * @param string $desc la chaîne à réduire
 * @param int $length la longueur max de la nouvelle chaîne
 * @return string la nouvelle chaîne réduite
 */
function summarize(string $desc, int $lenght = 300): string
{
    return mb_substr($desc, 0, $lenght) . ((strlen($desc) > $lenght) ? '...' : '');
}

/**
 * affiche la page d'erreur voulue et die
 * @param int $code le code le l'erreur pour savoir quel message afficher (cf fonction errorMessage)
 */
function displayError(int $code){
    $title = 'Erreur '.$code;
    $errorCode = $code;
    include_once PATH_VIEWS.'errorPage.php';
    die();
}


/**
 * retourne une chaine pour remplir un champ de formulaire avec la valeur correspondante (si l'utilisateur a déjà submit et qu'il y a eu des erreurs, il n'est pas obligé de re-remplir les champs qui étaient corrects)
 * 
 * @param string $att le nom de l'attribut correspondant au champ
 * @param string $type le type de champ à préremplir
 * @return string la chaine permettant de préremplir le champ
 * 
 */
function preFill(string $att, string $type='input'):string{
    $str = '';
    if(isset($_POST[$att]))
        $str = (($type==='input')?'value="':'').$_POST[$att].(($type==='input')?'"':'');
    return $str;
}

/**
 * fonction qui redirige vers l'url demandée
 */
function redirect(string $url, int $id = -1){
    header("Location: ".url($url,$id));
    die();
}