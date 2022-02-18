<?php

require_once PATH_MODELS . 'Article.php';

/**
 * récupère tous les articles dans la base de données et appelle la vue qui affiche la liste
 */
function listArticles()
{
    $articles = Article::all();

    include_once PATH_VIEWS . 'list-articles.php';
}


/**
 * récupère un article en fonction de l'id passé en url et appelle la vue qui affiche les détails d'un article
 */
function detailsArticle()
{

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


/**
 * affiche le formulaire d'ajout d'un article et fait les vérifications lors du submit
 */
function addArticle()
{


    //le message d'erreur qui sera affiché s'il y en a
    $errorMsg = '';

    if (!empty($_POST['submit'])) {

        //on teste si tous les champs obligatoires sont remplis
        if (!empty($_POST['titre']) && (!empty($_POST['contenu']))) {

            // si l'image est renseignée, elle doit être une url
            if (!empty($_POST['image']) && (!filter_var($_POST['image'], FILTER_VALIDATE_URL)))
                $errorMsg .= 'Vous devez renseigner une url correcte pour l\'image';


            // si la date est renseignée, elle doit être correcte
            if (!empty($_POST['date_de_publication']) && (!DateTime::createFromFormat('Y-m-d', $_POST['date_de_publication'])))
                $errorMsg .= ((!empty($errorMsg)) ? '<br>' : '') . 'date incorrecte';


            // si pas d'erreur on appelle le handler pour enregistrer le produit
            if (empty($errorMsg)) {
                addArticleHandler();
            }
        } else
            $errorMsg = 'Veuillez remplir tous les champs obligatoires (avec un *)';
    }

    include_once PATH_VIEWS . 'article-form.php';
}

/**
 * enregistre l'article dans la base de données
 */
function addArticleHandler()
{
    $article = new Article();

    $article->titre = $_POST['titre'];
    $article->contenu = $_POST['contenu'];
    $article->image = $_POST['image'];
    $article->auteur = $_POST['auteur'];
    $article->date_de_publication = $_POST['date_de_publication'];

    $article->save();
    redirect('list-articles');
}
