<?php

include_once PATH_VIEW_INCLUDES . '/header.php';

?>


<div class="container mt-5">
    <form method="post">
        <div class="mb-3">
            <label for="identifiant" class="form-label">identifiant : </label>
            <input type="text" class="form-control" id="identifiant" name="identifiant" value="<?= $_POST['identifiant'] ?? '' ?>">
        </div>

        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">mot de passe : </label>
            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
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
include_once PATH_VIEW_INCLUDES . '/footer.php';
?>