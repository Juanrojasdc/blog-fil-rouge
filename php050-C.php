<?php
/**
 * ============================================
 * CREATE (CRUD) - FORMULAIRE D'AJOUT D'ARTICLE
 * ============================================
 *
 * Ce fichier affiche un formulaire HTML permettant de créer un nouvel article
 * C'est la partie "CREATE" du CRUD (Create, Read, Update, Delete)
 *
 * Fonctionnement :
 * 1. L'utilisateur remplit le formulaire sur cette page
 * 2. Quand il clique sur "Envoyer", les données sont envoyées vers php050-C-post.php
 * 3. Le fichier php050-C-post.php traitera les données et les insérera en base
 */

// ============================================
// CONNEXION À LA BASE DE DONNÉES
// ============================================
// On inclut le fichier de connexion (même si on ne l'utilise pas directement ici)
// C'est une bonne pratique pour vérifier que la connexion BDD fonctionne avant d'afficher le formulaire
include('connect.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout d'article</title>
    <!-- Bootstrap pour le style du formulaire -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container">

        <h1>Ajouter un article</h1>

        <!-- ============================================
             FORMULAIRE D'AJOUT
             ============================================
             - action="php050-C-post.php" : où les données seront envoyées
             - method="POST" : méthode HTTP (POST cache les données dans l'URL, GET les affiche)
        -->
     <form action="php050-C-post.php" method="POST">
            <div class="mb-3">
                <label for="auteur" class="form-label">Auteur</label>
                <input type="text" class="form-control" id="auteur" name="auteur" required>
            </div>
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" required>
            </div>
            <div class="mb-3">
                <label for="contenu" class="form-label">Contenu</label>
                <textarea class="form-control" id="contenu" name="contenu" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
            <a class="btn btn-secondary" href="php050-R.php">Retour</a>
        </form>
    </div>

</body>

</html>

<!--
NOTES PÉDAGOGIQUES :

1. Séparation formulaire / traitement :
   - Ce fichier (php050-C.php) : AFFICHE le formulaire
   - Le fichier php050-C-post.php : TRAITE les données

2. Attributs importants des champs :
   - name : OBLIGATOIRE pour récupérer la valeur en PHP
   - id : pour le JavaScript et les labels
   - type : définit le type de données attendu

3. Méthode POST vs GET :
   - POST : données cachées, pour modifier/créer des données
   - GET : données visibles dans l'URL, pour rechercher/lire des données

4. Sécurité :
   - Ce formulaire n'a pas de validation côté client (JavaScript)
   - Toute la validation sera faite côté serveur dans php050-C-post.php
   - JAMAIS faire confiance aux données utilisateur !

5. Framework Bootstrap :
   - Les classes comme "form-control", "mb-3", "btn btn-primary" viennent de Bootstrap
   - Elles permettent d'avoir un design propre sans écrire de CSS
-->
