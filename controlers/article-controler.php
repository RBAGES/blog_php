<?php


/**
 * récupère tous les articles dans la base de données et appelle la vue qui afficle la liste
 */
function listArticles()
{
    require_once PATH_MODELS . 'Article.php';

    $articles = Article::all();

    include_once PATH_VIEWS . 'list-articles.php';
}


/**
 * récupère un article en fonction de l'id passé en url et appelle la vue qui affiche les détails d'un article
 */
function detailsArticle()
{
    require_once PATH_MODELS . 'Article.php';

    if (empty($_GET['id']))
        displayError(404);

    else {
        //retrieveByPK déclenche une erreur si jamais l'id n'existe pas, c'est pour ça que j'utilise un try catch
        try {

            $article = Article::retrieveByPK($_GET['id']);
            include_once PATH_VIEWS . 'article-details.php';
        } catch (\Throwable $th) {
            displayError(404);
        }
    }
}
