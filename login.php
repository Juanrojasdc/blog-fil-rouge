<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Espace Rédacteur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow p-4">
                    <h3 class="text-center mb-3">Connexion</h3>
                    
                    <?php if (isset($_SESSION['error_login'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error_login']; ?>
                        </div>
                        <?php unset($_SESSION['error_login']); ?>
                    <?php endif; ?>

                    <form action="submit-login.php" method="POST">
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
    </div>

</body>
</html>