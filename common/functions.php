<?php
/**
 * Fichier de fonctions utilitaires - functions.php
 * =================================================
 * Ce fichier regroupe toutes les fonctions réutilisables du projet.
 */

// ============================================================================
// 1. FONCTIONS UTILITAIRES POUR LES MATCHS
// ============================================================================

function isActiveMatch(array $match): bool
{
    return isset($match['is_active']) && $match['is_active'];
}

function getActiveMatches(array $matches): array
{
    $active_matches = [];
    foreach ($matches as $match) {
        if (isActiveMatch($match)) {
            $active_matches[] = $match;
        }
    }
    return $active_matches;
}

// ============================================================================
// 2. UTILITAIRES DE TEXTE ET D'URL (Version Formateur - SEO Friendly & Typée)
// ============================================================================

/**
 * Fonction slugify pour nettoyer le titre dans les url SEO friendly
 */
function slugify(string $text): string
{
    // Remplace les caractères non alphanumériques par un tiret
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Translitération
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Supprime les caractères indésirables
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Supprime les tirets en début et fin
    $text = trim($text, '-');
    // Convertit en minuscules
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

// funcion createArticleUrl()
/**
 * Genera la URL para ver el detalle de un artículo a través del Front Controller
 *
 * @param int $id El ID del artículo.
 * @param string $titre El título del artículo.
 * @return string La URL formateada para el Front Controller con SEO slug.
 */
function createArticleUrl(int $id, string $titre): string
{
    $titrePropre = slugify($titre);
    return 'index.php?page=articles&id=' . $id . '&titre=' . $titrePropre;
}


/**
 * Tronquer fonction
 */
function truncateString(string $string, int $length = 20): string
{
    if (strlen($string) > $length) {
        return substr($string, 0, $length) . '...';
    }
    return $string;
}

// ============================================================================
// 3. GESTION DES COOKIES ET REDIRECTIONS
// ============================================================================

function redirectToUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}

if (!empty($_REQUEST['firstname'])) {
    setcookie('firstname', htmlspecialchars($_REQUEST['firstname']), time() + (7 * 24 * 60 * 60), "/");
}

// ============================================================================
// 4. REQUÊTES GLOBALES (Conservées pour ne pas casser l'ancien code)
// ============================================================================

if (isset($mysqlClient)) {
    
    $sqlQuery = '
        SELECT a.id, a.titre, a.contenu, a.date_publication, r.score, r.lieu
        FROM s2_articles_presse a
        LEFT JOIN s2_resultats_sportifs r ON a.match_id = r.id
        ORDER BY a.date_publication DESC';
    $newsbdd = $mysqlClient->prepare($sqlQuery);
    $newsbdd->execute();
    $news = $newsbdd->fetchAll();

    $sqlQueryAbo = 'SELECT * FROM `s2_abonnes`';
    $abobdd = $mysqlClient->prepare($sqlQueryAbo);
    $abobdd->execute();
    $abonnes = $abobdd->fetchAll();

    $sqlQueryMatches = 'SELECT * FROM `s2_resultats_sportifs`';
    $bddMatch = $mysqlClient->prepare($sqlQueryMatches);
    $bddMatch->execute();
    $Matches = $bddMatch->fetchAll();
}