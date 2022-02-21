<?php

include_once PATH_VIEW_INCLUDES . 'header.php';

?>


<div class="container mt-5">


    <?php foreach ($articles as $article) { ?>

        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col-6 d-none d-lg-block">
                <img class="img-thumbnail" src="<?= $article->image ?>" alt="<?=$article->image?>">

            </div>
            <div class="col-6 p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary"><?= $article->auteur ?></strong>
                <h3 class="mb-0"><?= $article->titre ?></h3>
                <div class="mb-1 text-muted"><?= formatDate($article->date_de_publication) ?></div>
                <p class="card-text mb-auto"><?= summarize($article->contenu) ?></p>
                <div class="buttons">
                    <a class="btn btn-primary" href="<?= url('article',$article->id) ?>">Poursuivre vers l'article <i class="fa-solid fa-eye"></i></a>
                    <?php if(isAdmin()) { ?>
                        <a class="btn btn-primary ms-3" href="<?= url('edit-article',$article->id) ?>">Modifier <i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-danger ms-1" href="<?= url('delete-article',$article->id) ?>" onclick="return confirm('voulez vous vraiment supprimer cet article?')">Supprimer <i class="fa-solid fa-pen-to-square"></i></a>
                    <?php } ?>
                </div>
            </div>

        </div>

    <?php } ?>

</div>


<?php

include_once PATH_VIEW_INCLUDES . 'footer.php';
