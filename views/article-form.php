<?php

include_once PATH_VIEW_INCLUDES . 'header.php';

?>


<div class="container">
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titre" class="form-label required">titre : </label>
            <input required="required" type="text" class="form-control" id="titre" name="titre" <?php echo ((isset($article)?'value="'.$article->titre.'"':'')).preFill('titre')?>>
        </div>
        <div class="mb-3">
            <label for="auteur" class="form-label">auteur : </label>
            <input type="text" class="form-control" id="auteur" name="auteur" <?php echo ((isset($article)?'value="'.$article->auteur.'"':'')).preFill('auteur')?>>
        </div>
        <div class="mb-3">
            <label for="date_de_publication" class="form-label">date de publication : </label>
            <input type="date" class="form-control" id="date_de_publication" name="date_de_publication" <?php echo ((isset($article)?'value="'.date_format(new Datetime($article->date_de_publication),'Y-m-d').'"':'')).preFill('date_de_publication')?>>
        </div>
        <div class="mb-3">
            <label for="contenu" class="form-label required">contenu : </label>
            <textarea required="required" class="form-control" name="contenu" id="contenu" rows="10"><?php if (isset($article)) echo $article->contenu; else echo preFill('contenu','textarea');?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">adresse de l'image : </label>
            <input type="text" class="form-control" id="image" name="image" <?php echo ((isset($article)?'value="'.$article->image.'"':'')).preFill('image')?>>
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

</div>


<?php

include_once PATH_VIEW_INCLUDES . 'footer.php';
