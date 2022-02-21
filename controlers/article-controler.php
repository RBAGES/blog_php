<?php

require_once PATH_MODELS . 'Article.php';
require_once PATH_MODELS . 'Commentaire.php';
require_once PATH_MODELS . 'Utilisateur.php';

/**
 * récupère tous les articles dans la base de données et appelle la vue qui affiche la liste
 */
function listArticles(string $title = 'nos articles')
{
    $articles = Article::all();

    // on filtre les articles dont la date de publication est postérieure à la date actuelle
    $articles = array_filter($articles,function($article){
        $art_time = (new DateTime($article->date_de_publication))->getTimeStamp();
        return ($art_time <= time());
    });

    include_once PATH_VIEWS . 'list-articles.php';
}


/**
 * récupère un article et appelle la vue qui affiche les détails d'un article
 */
function detailsArticle(string $title = 'detail de l\'article')
{
    if(empty($_GET['id']))
        displayError(404);

    $article = getArticle();
    $comments = getCommentaires($_GET['id']);

    include_once PATH_VIEWS . 'article-details.php';
}


/**
 * affiche le formulaire d'ajout d'un article et fait les vérifications lors du submit
 * @param object $article est utilisé pour être passé en paramètre au handler, s'il est null un nouvel article sera créé
 */
function manageArticle(object $article = null, string $title = 'ajouter un article')
{
    if(!isAdmin())
     displayError(403);
    //le message d'erreur qui sera affiché s'il y en a
    $errors = [];

    if (!empty($_POST['submit'])) {

        //on teste si tous les champs obligatoires sont remplis
        if (!empty($_POST['titre']) && (!empty($_POST['contenu']))) {

            // si l'image est renseignée, elle doit être une url
            if (!empty($_POST['image']) && (!filter_var($_POST['image'], FILTER_VALIDATE_URL)))
                $errors[] = 'Vous devez renseigner une url correcte pour l\'image';


            // si la date est renseignée, elle doit être correcte
            if (!empty($_POST['date_de_publication']) && (!DateTime::createFromFormat('Y-m-d', $_POST['date_de_publication'])))
                $errors[] = 'date incorrecte';
            

            $uploadResult = [];

            if(file_exists($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])){
                $uploadResult = saveUploadedFile($_FILES['image']);
                if(!empty($uploadResult['errors']))
                    $errors = array_merge($errors,$uploadResult['errors']);
            }else if(!is_null($article))
                unlink($article->image);
            

            // si pas d'erreur on appelle le handler pour enregistrer le produit
            if (empty($errors)) {
                manageArticleHandler($article,false, $uploadResult);
            }
        } else
            $errors[] = 'Veuillez remplir tous les champs obligatoires (avec un *)';
    }

    include_once PATH_VIEWS . 'article-form.php';
}

/**
 * enregistre l'article dans la base de données
 * @param object $article si l'article passé est null alors on crée un nouveau article sinon on modifie $article et on l'enregistre
 * @param bool $delete true si on veut supprimer l'article en paramètre
 */
function manageArticleHandler(object $article = null, bool $delete = false,array $uploadResult=[])
{

    if (is_null($article))
        $article = new Article();
    else if ($delete) {
        unlink($article->image);
        $article->delete();
        redirect('list-articles');
    }
    $article->titre = $_POST['titre'];
    $article->contenu = $_POST['contenu'];
    $article->image = $uploadResult['path']??'';
    $article->auteur = $_POST['auteur'];
    $article->date_de_publication = ((empty($_POST['date_de_publication']))? date('Y-m-d H:i:s') : $_POST['date_de_publication']);

    $article->save();
    redirect('list-articles');
}

/**
 * récupère l'article avec l'id de l'url
 * affiche le formulaire pré rempli avec les données de l'article
 * si le formulaire est submit, alors on appelle la méthode addArticle avec en paramètre l'article récupéré 
 */
function editArticle(string $title = 'modifier l\'article')
{
    if(!isAdmin())
     displayError(403);

    $errors = [];

    $article = getArticle();
    if (empty($_POST['submit']))
        include_once PATH_VIEWS . 'article-form.php';

    else
        manageArticle($article, $title);
}

/**
 * supprime l'article qui a l'id passé en url
 */
function deleteArticle()
{
    if(!isAdmin())
     displayError(403);
     
    $article = getArticle();
    manageArticleHandler($article, true);
}

/**
 * récupère l'article s'il existe, sinon renvoie sur une page 404
 */
function getArticle()
{
    if (empty($_GET['id']))
        displayError(404);
    else {
        try {
            $article = Article::retrieveByPK($_GET['id']);
            return $article;
        } catch (\Throwable $th) {
            displayError(404);
        }
    }
}

/**
 * fonction qui récupère les commentaires de l'article ayant l'id passé en paramètre
 * @param int $id_article l'id de l'article sur lequel sont postés les commentaires
 * @return array un tableau contenant le tableau des commentaires et le tableau des utilisateurs qui y sont liés, indexés par l'id des commentaires
 */
function getCommentaires(int $id_article): array{
    $comments = Commentaire::retrieveByField('id_article', $id_article,SimpleOrm::FETCH_MANY);
    $users = Utilisateur::all();


    $usersIndexedByCommentID = [];
    foreach ($comments as $comment) {
        foreach ($users as $user) {
            if($user->id === $comment->id_utilisateur)
                $usersIndexedByCommentID[$comment->id] = $user;
        }        
    }

    return ['comments' => $comments, 'users' => $usersIndexedByCommentID];
}

/**
 * fonction qui enregistre un commentaire dans la base de données
 */
function newCommentHandler(){
    
    if (empty($_SESSION['id']))
        displayError(401);

    if (empty($_POST['newComment']))
        displayError(404);
    $commentaire = new Commentaire();
    $commentaire->contenu = $_POST['contenu'];
    $commentaire->id_utilisateur = $_SESSION['id'] ?? -1;
    $commentaire->id_article = $_GET['id'];
    $commentaire->date_publication = date('Y-m-d H:i:s');

    $commentaire->save();
    redirect('article',$_GET['id']);
    
}
