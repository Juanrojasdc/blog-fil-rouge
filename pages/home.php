<?php
// pages/home.php - AFFICHAGE DE L'ACCUEIL

$sqlQuery = '
    SELECT a.id, a.titre, a.contenu, a.date_publication AS textequejeveux, r.score, r.lieu
    FROM s2_articles_presse a
    LEFT JOIN s2_resultats_sportifs r ON a.match_id = r.id
    ORDER BY `a`.`date_publication` DESC;';

$newsFraiches = $mysqlClient->prepare($sqlQuery);
$newsFraiches->execute();
$news = $newsFraiches->fetchAll();
?>

<div class="container mt-4">
    <div class="row row-cols-1 row-cols-md-3 g-4 p-3 justify-content-center">
        <?php foreach ($news as $new): ?>
            <div class="col" style="max-width: 320px;">
                <div class="card bg-light h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <img src="https://picsum.photos/200/150" alt="img-card" class="card-img-top mb-3">
                            <h5 class="card-title"><?= htmlspecialchars(truncateString($new['titre'], 20)); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">ID: <?= htmlspecialchars($new['id']); ?></h6>
                            <p class="card-text"><?= htmlspecialchars(truncateString($new['contenu'], 100)); ?></p>
                            <p class="small text-dark">Score: <?= htmlspecialchars($new['score'] ?? 'N/A'); ?> | Lieu: <?= htmlspecialchars($new['lieu'] ?? 'N/A'); ?></p>
                            <p class="small text-muted">- <?= htmlspecialchars($new['textequejeveux']); ?></p>
                        </div>
                        
                        <div class="mt-3">
                            <a href="<?= createArticleUrl((int)$new['id'], $new['titre']); ?>" class="btn btn-sm btn-outline-primary w-100 mb-2"> <i class="bi bi-eye"></i> Lire l'article</a>
                            
                            <?php if (isset($_SESSION['user_connected']) && $_SESSION['user_role'] === 'admin'): ?>
                                <div class="d-flex justify-content-between border-top pt-2">
                                    <!--tengo que recordar verificar si todo funciona correctamente -->
                                    <a class="btn btn-xs btn-outline-dark" href="../public/index.php?page=edit&id=<?= htmlspecialchars($new['id']); ?>"><i class="bi bi-pencil"></i> Modifier</a>
                                    <a class="btn btn-xs btn-outline-danger" href="../public/index.php?page=deletepost&id=<?= htmlspecialchars($new['id']); ?>"><i class="bi bi-trash"></i> Supprimer</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>