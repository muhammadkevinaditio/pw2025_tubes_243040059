<nav class="navbar navbar-expand-lg bg-success navbar-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">Halaman User</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <?php if (isset($_SESSION['login'])) : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle"></i> Welcome, <?= htmlspecialchars($_SESSION['username']); ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../admin_panel/index.php"><i class="bi bi-layout-text-sidebar-reverse"></i> Dasbor Admin</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="../auth/logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?');">
                  <i class="bi bi-box-arrow-right"></i> Logout
                </a>
              </li>
            </ul>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a href="../auth/login.php" class="btn btn-light me-2">Login</a>
          </li>
          <li class="nav-item">
            <a href="../auth/register.php" class="btn btn-outline-light">Register</a>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>