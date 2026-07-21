<?php

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