<?php

include_once PATH_VIEW_INCLUDES . '/header.php';

?>


<div class="container mt-5">
    <form method="post">
        <div class="mb-3">
            <label for="identifiant" class="form-label required">votre pseudo : </label>
            <input type="text" required="required" class="form-control" id="pseudo" name="pseudo" value="<?= $_POST['pseudo'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="identifiant" class="form-label required">votre identifiant : </label>
            <input type="text" required="required" class="form-control" id="identifiant" name="identifiant" value="<?= $_POST['identifiant'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="identifiant" class="form-label">l'url de votre avatar : </label>
            <input type="text" class="form-control" id="avatar" name="avatar" value="<?= $_POST['avatar'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label for="mot_de_passe" class="form-label required">mot de passe : </label>
            <input required="required" type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
        </div>
        <div class="mb-3">
            <label for="validation_mot_de_passe" class="form-label required">valider votre mot de passe : </label>
            <input required="required" type="password" class="form-control" id="validation_mot_de_passe" name="validation_mot_de_passe">
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