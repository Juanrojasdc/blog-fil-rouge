<?php
// ============================================
// VUE : FORMULAIRE DE CONNEXION
// ============================================
/** @var array|false $user */
?>

<div class="container d-flex align-items-center justify-content-center my-5" style="min-height: 70vh;">
    <div class="col-md-4">
        <div class="card shadow p-4">
            <h3 class="text-center mb-3">Connexion</h3>
            
            <?php if (isset($_SESSION['error_login'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error_login']; ?>
                </div>
                <?php unset($_SESSION['error_login']); ?>
            <?php endif; ?>

            <!-- Apunta al index.php central -->
            <form action="index.php?page=login" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="mail" class="form-control" required placeholder="exemple@test.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="mdp" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                <a href="index.php" class="btn btn-link w-100 text-center mt-2">Retour au site (Lecture seule)</a>
            </form>

        </div>
    </div>
</div>