<div class="row d-flex justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-0 border" style="background-color: #f0f2f5;">
            <div class="card-body p-4" id="commentlist">
                <form method="POST" class="form-outline mb-4">
                    <input required="required" name="contenu" type="text" id="addANote" class="form-control" placeholder="Type comment..." />
                    <input type="submit" name="newComment" value="Ajouter un commentaire" class="btn btn-primary mt-3" id="addCommentBtn">
                </form>

                <?php foreach ($comments as $comment) {  ?>

                <div class="card mb-4">
                    <div class="card-body">
                        <p><?= $comment->contenu ?></p>

                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center">
                                <img src="https://bip.cnrs.fr/wp-content/uploads/2019/11/user.jpg" alt="avatar" width="25" height="25" />
                                <p class="small mb-0 ms-2">Utilisateur <?= $comment->id_utilisateur ?></p>
                            </div>
                            <div class="mb-1 text-muted"><?= formatDate($comment->date_publication) ?></div>
                        </div>
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>
</div>
</div>

