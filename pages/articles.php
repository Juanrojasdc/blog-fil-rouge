<?php
// ============================================================
// PAGE D'AFFICHAGE D'UN ARTICLE COMPLET
// ============================================================

include('../common/db.php');

// Inicializar variable por defecto
$article = false;

// 1. Validar si viene un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $articleId = (int)$_GET['id'];

    $sqlQuery = '
        SELECT a.id, a.titre, a.contenu, a.date_publication, r.score, r.lieu
        FROM s2_articles_presse a
        LEFT JOIN s2_resultats_sportifs r ON a.match_id = r.id
        WHERE a.id = :id';

    $statement = $mysqlClient->prepare($sqlQuery);
    $statement->bindParam(':id', $articleId, PDO::PARAM_INT);
    $statement->execute();

    // Retorna un array si existe, o FALSE si no existe
    $article = $statement->fetch();
}

// 2. Definir el título de la página de forma segura
$pageTitle = ($article && is_array($article)) 
    ? htmlspecialchars(($article['score'] ? "{$article['score']} " : "") . $article['titre'])
    : "Article non trouvé";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Équipe | <?= $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

    <div class="container text-center d-flex flex-wrap justify-content-center my-4">

    <?php if ($article && is_array($article)): ?>
        
        <!-- ============================================================ -->
        <!-- SI EL ARTICLE EXISTE: SE MUESTRA EL CONTENIDO Y EL BOTÓN     -->
        <!-- ============================================================ -->
        <div class='card col-9 p-3 shadow-sm'>
            <?php
            $imagePath = "img/" . $article['id'] . ".jpg";
            $image = file_exists($imagePath) ? "../$imagePath" : "https://picsum.photos/800/150";
            ?>
            <img src="<?= $image; ?>" class="img-fluid rounded-top mb-3" alt="<?= htmlspecialchars($article['titre']); ?>">

            <h1><?= htmlspecialchars($article['titre']); ?></h1>
            <p class="text-muted">Publié le : <?= htmlspecialchars($article['date_publication']); ?></p>

            <?php if (!empty($article['score'])): ?>
                <strong style="color:#FF0000">Score : <?= htmlspecialchars($article['score']); ?></strong>
            <?php endif; ?>

            <?php if (!empty($article['lieu'])): ?>
                <p>Lieu : <?= htmlspecialchars($article['lieu']); ?></p>
            <?php endif; ?>

            <p class="mt-3 text-start"><?= nl2br(htmlspecialchars($article['contenu'])); ?></p>
        </div>

        <!-- Zone des boutons (Solo se muestra si el artículo existe) -->
        <div class="col-12 mt-4">
            <button
                id="shareButton"
                class="btn btn-outline-primary share-button"
                data-title="<?= htmlspecialchars($article['titre']); ?>"
                data-text="<?= htmlspecialchars($article['titre']); ?>"
                data-url="article.php?id=<?= (int)$article['id']; ?>">
             <i class="bi bi-share" aria-hidden="true"></i> Partager
            </button>

            <a class="btn btn-primary ms-2" role="button" href="../public/index.php">RETOUR</a>
            <div id="shareAlert" class="alert mt-2"></div>
        </div>

    <?php else: ?>

        <!-- ============================================================ -->
        <!-- SI EL ARTICLE NO EXISTE: SE MUESTRA UN MENSAJE DE ERROR      -->
        <!-- ============================================================ -->
        <div class='card col-8 p-5 shadow-sm mt-5'>
            <h2 class="text-danger">Article non trouvé</h2>
            <p class="lead">L'article demandé n'existe pas ou a été supprimé.</p>
            <div>
                <a class="btn btn-primary mt-3" role="button" href="../public/index.php">RETOUR À L'ACCUEIL</a>
            </div>
        </div>

    <?php endif; ?>

    </div>

    <script src="../../js/share.js"></script>
</body>
</html>