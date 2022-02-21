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
        case 102:
            $error = 'Utilisateur introuvable';
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
 * fonction qui redirige vers l'url demandée
 */
function redirect(string $url, int $id = -1){
    header("Location: ".url($url,$id));
    die();
}

/**
 * retourne true si l'utilisateur est connecté en tant qu'admin
 */
function isAdmin():bool{
    return (!empty($_SESSION['role']) && $_SESSION['role']==='admin');
}

/**
 * transforme une chaine représentant une date en une répresentation plus lisible comportant les mois en français
 * @param string $dateStr la date qu'on veut transformer
 * @return string la date sous la forme 'Le {jour} {mois} {année} à {heure}h{minute}'
 */
function formatDate(string $dateStr):string{
    $date = new DateTime($dateStr);
    $day = intval($date->format('d'));
    $month = intval($date->format('m'));
    $year = intval($date->format('Y'));
    $hour = $date->format('H');
    $minute = $date->format('i');

    switch ($month) {
        case 1:
            $monthName = 'Janvier';
            break;
        case 2:
            $monthName = 'Février';
            break;
        case 3:
            $monthName = 'Mars';
            break;
        case 4:
            $monthName = 'Avril';
            break;
        case 5:
            $monthName = 'Mai';
            break;
        case 6:
            $monthName = 'Juin';
            break;
        case 7:
            $monthName = 'Juillet';
            break;
        case 8:
            $monthName = 'Août';
            break;
        case 9:
            $monthName = 'Septembre';
            break;
        case 10:
            $monthName = 'Octobre';
            break;
        case 11:
            $monthName = 'Novembre';
            break;
        case 12:
            $monthName = 'Décembre';
            break;
            
            
        default:
            $monthName = 'erreur sur le mois';
        break;
    }
    return 'Le '.$day.' '.$monthName.' '.$year.' à '.$hour.'h'.$minute;

}

/**
 * fonction qui récupère le fichier uploadé et le met dans le dossier des images
 * @param array $file le fichier uploadé (correspond à $_FILES['monfichier']) 
 * @return array un tableau contenant le status de l'upload (true si ok, false sinon), le chemin du fichier enregistré et un tableau d'erreurs s'il y en a 
 */
function saveUploadedFile(array $file):array{
    if(empty($file))
        return 'aucun fichier fourni';

    $type = explode('/',$file['type'])[0];
    $extension = '.'.pathinfo($file['name'],PATHINFO_EXTENSION);
    $size = $file['size'];
    $error = $file['error'];
    $newName = uniqid('image').$extension;

    $status = ['status'=>true,'path'=>'','errors'=>[]];

    if ($type !=='image'){
        $status['status'] = false;
        $status['errors'][] = 'le fichier n\'est pas une image';
    }

    if ($size > MAX_FILE_SIZE){
        $status['status'] = false;
        $status['errors'][] = 'le fichier est trop volumineux ('.intval($size/2**10).'ko), la taille maximale acceptée est de : '. intval(MAX_FILE_SIZE /(2**10)).'ko';
    }
    if ($error != 0){
        $status['status'] = false;
        $status['errors'][] = 'une erreur est survenue lors du téléversement du fichier';
    }
    
    if($status['status']){
        if (move_uploaded_file($file['tmp_name'], PATH_IMAGES.$newName))
            $status['path'] = PATH_IMAGES.$newName;
        else{
            $status['status'] = false;
            $status['errors'][] = 'une erreur est survenue lors du téléversement du fichier';
        }
    }

    return $status;
}
