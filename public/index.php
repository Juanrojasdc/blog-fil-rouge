<?php
session_start();

// Inclusión de archivos comunes obligatorios
require_once(__DIR__ . '/../common/db.php');
require_once(__DIR__ . '/../common/functions.php');
require_once(__DIR__ . '/../common/variables.php'); 

// 1. Definir la página actual de forma limpia
$page = $_GET['page'] ?? 'home';

// 2. CASO ESPECIAL LOGIN: Si es la página de login y el usuario envió el formulario por POST,
// ejecutamos la lógica de verificación ANTES de mostrar cualquier HTML (evita errores de redirección).
if ($page === 'login' && isset($_POST['mail']) && isset($_POST['mdp'])) {
    include(__DIR__ . '/../common/dbLogin.php');
}

// 3. Incluimos la estructura visual superior común del sitio
include(__DIR__ . '/../common/header.php');

// 4. ENRUTADOR (Routing) - Decide qué contenido mostrar según el parámetro 'page'
if ($page === 'articles' && isset($_GET['id'])) {
    // Si la URL pide un artículo específico
    include(__DIR__ . '/../common/dbArticle.php');
    include(__DIR__ . '/../pages/articles.php');
} 
elseif (array_key_exists($page, $whitelist)) {
    // Si la página solicitada está permitida en la whitelist
    include(__DIR__ . "/../pages/" . $page . ".php");
} 
else {
    // Si la página no existe en la whitelist
    echo "<div class='container mt-5'><div class='alert alert-danger'>Erreur 404 : Vous êtes perdu ?</div></div>";
}

// 5. Incluimos el pie de página común del sitio
include(__DIR__ . '/../common/footer.php');

