<?php
// routeur

//constantes
define('PATH_IMAGES', __DIR__ . '/assets/img/');
define('PATH_MODELS', __DIR__ . '/models/');
define('PATH_CONTROLERS', __DIR__ . '/controlers/');
define('PATH_VIEWS', __DIR__ . '/views/');
define('PATH_VIEW_INCLUDES', __DIR__ . '/views/includes/');

include_once __DIR__ . '/functions.php';

connexion();

if (empty($_GET['route'])) {
    include_once PATH_CONTROLERS . 'home-controler.php';
} else {
    switch ($_GET['route']) {
        case 'home':
            $title = 'home';
            include_once PATH_CONTROLERS . 'home-controler.php';
            break;
        case 'list-articles':
            $title = 'nos articles';
            include_once PATH_CONTROLERS . 'list-articles-controler.php';
            break;
        case 'article':
            $title = 'article';
            include_once PATH_CONTROLERS . 'article-details-controler.php';
            break;

        default:
            $errorCode = 404;
            $title = 'page introuvable';
            include_once PATH_VIEWS . 'errorPage.php';
            break;
    }
}
