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
          <?php if(isAdmin()) { ?>
            <a class="nav-link active" aria-current="page" href="<?= url('add-article') ?>">Ajouter un article</a>
          <?php } ?>
          <form method="get" class="d-flex">
            <input type="hidden" name="route" value="list-articles" />
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?= $_GET['search'] ?? ''?>">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
        <div class="nav__right d-flex align-items-center">
          <?php if (empty($_SESSION['id'])) { ?>
            <a class="nav-link active" aria-current="page" href="<?= url('login') ?>">Se connecter</a>
            <?php } else {
            if (!empty($_SESSION['pseudo'])) { ?>
              <span class="text-success mx-3"> Bienvenue <?= $_SESSION['pseudo'] ?>!</span>
            <?php }
            if (!empty($_SESSION['avatar'])) { ?>
              <img class="rounded-circle" height="40" src="<?= $_SESSION['avatar'] ?>" alt="avatar">
            <?php } ?>
            <a class="nav-link active mx-3" aria-current="page" href="<?= url('signout') ?>" onclick="return confirm('voulez vous vraiment vous déconnecter?')">Se déconnecter</a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</nav>