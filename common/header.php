<?php
// Preguntar a raphael si es necesario poner session_start() aquí, ya que en index.php y login.php ya lo tenemos
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Sport 2000</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Articles</a>
                </li>
                
                <?php if (isset($_SESSION['user_connected']) && $_SESSION['user_role'] === 'ADMIN'): ?>
                    <li class="nav-item">
                        <a class="nav-link text-success fw-bold" href="../pages/add.php">+ Ajouter un article</a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="navbar-nav align-items-center">
                <?php if (isset($_SESSION['user_connected'])): ?>
                    <span class="navbar-text text-white me-3">
                        Bienvenue, <strong><?= htmlspecialchars($_SESSION['user_name']); ?></strong> 
                        <span class="badge bg-secondary"><?= htmlspecialchars($_SESSION['user_role']); ?></span>
                    </span>
                    <a class="btn btn-sm btn-outline-danger" href="../pages/logout.php">Déconnexion</a>
                <?php else: ?>
                    <a class="btn btn-sm btn-outline-light" href="../pages/login.php">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>