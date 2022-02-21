<?php

include_once PATH_VIEW_INCLUDES . 'header.php';

?>


<div class="container">
    <form method="post" enctype="multipart/form-data" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titre" class="form-label required">titre : </label>
            <input required="required" type="text" class="form-control" id="titre" name="titre" value="<?= $_POST['titre'] ?? $article->titre ?? null ?>">
        </div>
        <div class="mb-3">
            <label for="auteur" class="form-label">auteur : </label>
            <input type="text" class="form-control" id="auteur" name="auteur" value="<?= $_POST['auteur'] ?? $article->auteur ?? null ?>">
        </div>
        <div class="mb-3">
            <label for="date_de_publication" class="form-label">date de publication : </label>
            <input type="date" class="form-control" id="date_de_publication" name="date_de_publication" value="<?= $_POST['date_de_publication'] ?? explode(' ',$article->date_de_publication)[0] ?? null ?>">
        </div>
        <div class="mb-3">
            <label for="contenu" class="form-label required">contenu : </label>
            <textarea required="required" class="form-control" name="contenu" id="contenu" rows="10"><?= $_POST['contenu'] ?? $article->contenu ?? null ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">image de l'article : </label>
            <div class="d-flex align-items-center"><input type="file" class="form-control" id="image" name="image"></div>
        </div>
        
        <input type="submit" class="btn btn-primary" name="submit" value="Valider">
    </form>
    <?php 
            foreach ($errors as $error) {            
            ?>
                <div class="alert alert-danger mt-3" role="alert">
                <strong>Erreur!</strong> <?= $error ?>
                </div>
            <?php
        }
    ?>
<script src="assets/js/files.js"></script>
</div>


<?php

include_once PATH_VIEW_INCLUDES . 'footer.php';
