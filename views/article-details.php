<?php
include_once PATH_VIEW_INCLUDES.'header.php';
?>

<div class="container-fluid mt-5">
    <div class="col d-flex justify-content-center">
        <img class="" src="<?= $article->image ?>" alt="<?= $article->image ?>">
    </div>
    <div class="col mt-3">
        <h1><?= $article->titre ?></h1>
        <p><?= $article->contenu ?></p>
        
        <p>
            <strong>auteur : <?= $article->auteur ?></strong>
            , publié le <?= $article->date_de_publication ?>
        </p>
        
    </div>
</div>

<?php
include_once PATH_VIEW_INCLUDES . 'section-commentaires.php';


include_once PATH_VIEW_INCLUDES.'footer.php';