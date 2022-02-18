<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
          <div class="navbar-nav justify-content-between flex-grow-1">
            <div class="nav__left d-flex">
              <a class="nav-link active" aria-current="page" href="<?= url('home') ?>">Home</a>
              <a class="nav-link active" aria-current="page" href="<?= url('list-articles') ?>">Liste des articles</a>
              <a class="nav-link active" aria-current="page" href="<?= url('add-article') ?>">Ajouter un article</a>
            </div>
            <div class="nav__right d-flex">
              <?php if(empty($_SESSION['id'])){?>
              <a class="nav-link active" aria-current="page" href="<?= url('login') ?>">Se connecter</a>
              <?php } else { ?>
              <a class="nav-link active" aria-current="page" href="<?= url('signout') ?>">Se déconnecter</a>
              <?php } ?>
            </div>
          </div>
    </div>
  </div>
</nav>