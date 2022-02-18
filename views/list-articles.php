<?php

include_once PATH_VIEW_INCLUDES . 'header.php';

?>


<div class="container">


    <?php foreach ($articles as $article) { ?>

        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col-6 d-none d-lg-block">
                <img class="img-thumbnail" src="<?= $article->image ?>" alt="$article->image">

            </div>
            <div class="col-6 p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary"><?= $article->auteur ?></strong>
                <h3 class="mb-0"><?= $article->titre ?></h3>
                <div class="mb-1 text-muted"><?= $article->date_de_publication ?></div>
                <p class="card-text mb-auto"><?= summarize($article->contenu) ?></p>
                <a href="<?= url('article',$article->id) ?>">Poursuivre vers l'article</a>
            </div>

        </div>

    <?php } ?>

</div>


<?php

include_once PATH_VIEW_INCLUDES . 'footer.php';
