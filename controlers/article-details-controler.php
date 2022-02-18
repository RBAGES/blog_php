<?php

require_once PATH_MODELS.'Article.php';

if(empty($_GET['id'])){
    $errorCode = 404;
    include_once PATH_VIEWS.'errorPage.php';
    die();
}
else{
    //retriveByPK déclenche une erreur si jamais l'id n'existe pas, c'est pour ça que j'utilise un try catch
    try {
        $article = Article::retrieveByPK($_GET['id']);
        include_once PATH_VIEWS.'details-article.php';

    } catch (\Throwable $th) {
        $errorCode = 404;
        include_once PATH_VIEWS.'errorPage.php';
        die();
    }

}