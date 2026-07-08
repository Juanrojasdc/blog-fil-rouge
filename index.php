<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php050 READ - Lecture des articles</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php
    /**
     * ============================================
     * READ (CRUD) - AFFICHAGE DES ARTICLES
     * ============================================
     *
     * Ce fichier affiche la liste de tous les articles présents en base de données
     * C'est la partie "READ" du CRUD (Create, Read, Update, Delete)
     *
     * Fonctionnalités :
     * - Récupère tous les articles de la BDD avec une jointure SQL
     * - Affiche les articles avec un formatage HTML
     * - Tronque les textes trop longs pour un affichage propre
     */

    // ============================================
    // 1. CONNEXION À LA BASE DE DONNÉES
    // ============================================
    // On se connecte à la BDD en incluant le fichier de connexion
   include('connect.php');
    // Si tout va bien, on peut continuer


    // ============================================
    // 2. RÉCUPÉRATION DES ARTICLES EN BASE
    // ============================================
    // On récupère tout le contenu de la table articles avec une requête SQL complexe

    $sqlQuery = '
        SELECT a.id, a.titre, a.contenu, a.date_publication AS textequejeveux, r.score, r.lieu
        FROM s2_articles_presse a
        LEFT JOIN s2_resultats_sportifs r ON a.match_id = r.id
        ORDER BY `a`.`date_publication`
        DESC;';

    /*
     * Explication de la requête SQL :
     *
     * SELECT : colonnes qu'on veut récupérer
     *   - a.id, a.titre, a.contenu : infos de l'article
     *   - a.date_publication AS textequejeveux : on renomme la colonne (alias)
     *   - r.score, r.lieu : infos du match sportif associé
     *
     * FROM s2_articles_presse a : table principale (alias "a" pour simplifier)
     *
     * LEFT JOIN s2_resultats_sportifs r : jointure avec la table des résultats sportifs
     *   - LEFT JOIN : garde tous les articles MÊME s'ils n'ont pas de match associé
     *   - ON a.match_id = r.id : condition de jointure (lien entre les tables)
     *   - Si match_id = 0 ou NULL, r.score et r.lieu seront NULL
     *
     * ORDER BY a.date_publication DESC : trie par date décroissante (les plus récents d'abord)
     */

    // Préparation et exécution de la requête
    $newsFraiches = $mysqlClient->prepare($sqlQuery);
    $newsFraiches->execute();

    // fetchAll() : récupère TOUS les résultats sous forme de tableau
    // Chaque élément du tableau $news est un article (lui-même un tableau associatif)
    $news = $newsFraiches->fetchAll();


    // ============================================
    // 3. FONCTION UTILITAIRE : TRONQUER LE TEXTE
    // ============================================
    /**
     * Tronque une chaîne de caractères trop longue pour l'affichage
     *
     * @param string $string Le texte à tronquer
     * @param int $length La longueur maximale (par défaut 20 caractères)
     * @return string Le texte tronqué avec "(...)" ou le texte complet s'il est court
     */
    function truncateString($string, $length = 20)
    {
        // strlen() : compte le nombre de caractères
        if (strlen($string) > $length) {
            // substr() : extrait une partie de la chaîne (de 0 à $length)
            return substr($string, 0, $length) . ' (...)';
        }
        // Si le texte est assez court, on le retourne tel quel
        return $string;
    }

    // ============================================
    // 4. AFFICHAGE DES ARTICLES
    // ============================================
    echo '<div class="container-fluid"> <div class="d-flex justify-content-center">
 <a class="btn btn-secondary text-white" href="php050-C.php">Ajouter un nouvel article</a> <hr> </div></div>';

    // Boucle foreach : parcourt tous les articles récupérés
    // À chaque tour, $new contient un article différent

    /*
     * On utilise htmlspecialchars() pour sécuriser l'affichage et éviter les injections XSS
     * On utilise la fonction truncateString() pour limiter la longueur du titre et du contenu
     */

    
 foreach ($news as $new) {
    ?>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center p-3"> 
        <div class="card bg-light" style="width: 300px;">
            <div class="card-body">
                <img src="https://picsum.photos/200/150" alt="img-card" class="card-img-top mb-3">
                <h5 class="card-title"><?= htmlspecialchars(truncateString($new['titre'], 20)); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">ID: <?= htmlspecialchars($new['id']); ?></h6>
                <p class="card-text"><?= htmlspecialchars(truncateString($new['contenu'], 100)); ?></p>
                <p class="small text-dark">Score: <?= htmlspecialchars($new['score'] ?? 'N/A'); ?> | Lieu: <?= htmlspecialchars($new['lieu'] ?? 'N/A'); ?></p>
                <!-- <p class="text-muted"><?= htmlspecialchars(truncateString($new['auteur'], 20)); ?></p> -->
                <p class="small text-muted">-<?= htmlspecialchars($new['textequejeveux']); ?></p>
                <a href="article.php?id=<?= htmlspecialchars($new['id']); ?>" class="btn btn-outline-primary">Lire l'article</a>
            </div>
        </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="d-flex justify-content-center p-3">
            <a class="btn btn-outline-dark" href="php050-U.php?id=<?= htmlspecialchars($new['id']); ?>">Modifier</a>
            <a class="btn btn-outline-danger" href="php050-D.php?id=<?= htmlspecialchars($new['id']); ?>">Supprimer</a>
        </div>
    </div>
    <?php
    } // Fin de la boucle foreach
    echo '</div>';
    ?>


</body>

</html>
