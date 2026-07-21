<?php

session_start();

// Inclusión de archivos comunes obligatorios
require_once(__DIR__ . '/../common/db.php');
require_once(__DIR__ . '/../common/functions.php');
require_once(__DIR__ . '/../common/variables.php'); 

// inclusion del header.php que contiene la estructura HTML inicial y el menú de navegación
include(__DIR__ . '/../common/header.php');

// ENRUTADOR (Routing) - Decide que deside qué página mostrar según el parámetro 'page' en la URL
if (isset($_GET['page']) && $_GET['page'] === 'articles' && isset($_GET['id'])) {
    // Si la URL pide un artículo específico
    include(__DIR__ . '/../common/dbArticle.php');
    include(__DIR__ . '/../pages/articles.php');
} 
elseif (isset($_GET['page']) && array_key_exists($_GET['page'], $whitelist)) {
    // Si la URL pide una página permitida en la whitelist (ej: ?page=add)
    include(__DIR__ . "/../pages/" . $_GET['page'] . ".php");
} 
elseif (!isset($_GET['page'])) {
    // Si no hay parámetro 'page', cargamos la página de inicio por defecto
    include(__DIR__ . '/../pages/home.php');
} 
else {
    // Si el usuario escribe una página que no existe
    echo "<div class='container mt-5'><div class='alert alert-danger'>Erreur 404 : Vous êtes perdu ?</div></div>";
}


include(__DIR__ . '/../common/footer.php');