<?php
// routeur

//constantes
define('PATH_IMAGES', 'assets/img/');
define('PATH_MODELS', __DIR__ . '/models/');
define('PATH_CONTROLERS', __DIR__ . '/controlers/');
define('PATH_VIEWS', __DIR__ . '/views/');
define('PATH_VIEW_INCLUDES', __DIR__ . '/views/includes/');
define('MAX_FILE_SIZE', 5 * (2**20));//5 Mo

session_start();
include_once __DIR__ . '/functions.php';
connexion();

if (empty($_SESSION['id']) && !empty($_COOKIE['id'])){
    include_once PATH_CONTROLERS . 'user-controler.php';
    loginUserHandler(getUtilisateur($_COOKIE['id']));
}

if (empty($_GET['route'])) {
    include_once PATH_CONTROLERS . 'home-controler.php';
} else {
    switch ($_GET['route']) {
        case 'home':
            include_once PATH_CONTROLERS . 'home-controler.php';
            break;
        case 'list-articles':
            include_once PATH_CONTROLERS . 'article-controler.php';
            listArticles();
            break;
        case 'article':
            include_once PATH_CONTROLERS . 'article-controler.php';
            detailsArticle();
            break;
        case 'add-article':
            include_once PATH_CONTROLERS . 'article-controler.php';
            manageArticle();
            break;
        case 'edit-article':
            include_once PATH_CONTROLERS . 'article-controler.php';
            editArticle();
            break;
        case 'delete-article':
            include_once PATH_CONTROLERS . 'article-controler.php';
            deleteArticle();
            break;
        case 'new-comment':
            include_once PATH_CONTROLERS . 'article-controler.php';
            newCommentHandler();
            break;
        case 'login':
            include_once PATH_CONTROLERS . 'user-controler.php';
            loginUser();
            break;
        case 'signout':
            include_once PATH_CONTROLERS . 'user-controler.php';
            signoutUserHandler();
            break;
        case 'create-account':
            include_once PATH_CONTROLERS . 'user-controler.php';
            createUser();
            break;

        default:
            displayError(404);
            break;
    }
}
