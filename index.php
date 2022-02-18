<?php 
// routeur

//constantes
define('PATH_IMAGES', __DIR__.'/assets/img/');
define('PATH_MODELS', __DIR__.'/models/');
define('PATH_CONTROLERS', __DIR__.'/controlers/');
define('PATH_VIEWS',__DIR__.'/views/');
define('PATH_VIEW_INCLUDES',__DIR__.'/views/includes/');

include_once __DIR__.'/functions.php';

if(empty($_GET['route'])){
    include_once PATH_CONTROLERS . 'home-controler.php';
}
else{
    switch ($_GET['route']) {
        case 'home':
            include_once PATH_CONTROLERS . 'home-controler.php';
            break;
        
        default:
            # code...
            break;
    }
}