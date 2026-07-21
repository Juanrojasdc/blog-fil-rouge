<?php

session_start();

// Inclusion de la connexion à la base de données
require(__DIR__ . '../common/bdd.php');

// Inclusion des fonctions (notamment redirectToUrl et la liste des abonnés)
include(__DIR__ . '../common/functions.php');


  // ÉTAPE 1 : Validation du format de l'email


if (isset($_POST['mail']) && isset($_POST['mdp'])) {
    
    $email = trim($_POST['mail']);
    $password = trim($_POST['mdp']); // Esto es para eliminar espacios en blanco al inicio y al final del correo y la contraseña

    // Buscamos si existe un usuario con ese email en users, o sea una consulta sql para traer los datos de ese usuario
  $sql = 'SELECT * FROM users WHERE email = :mail_recibido'; 
    $query = $mysqlClient->prepare($sql); 
    $query->execute(['mail_recibido' => $email]); 
    
    $user = $query->fetch(); // Trae los datos de ese usuario (o false si no existe)

    // Validamos la contrasena (en este ejemplo se compara en texto plano, pero en producción se debería usar password_verify)
   if ($user && $user['pswd'] === $password) {
        
        $_SESSION['user_connected'] = true; // Guardamos en sesión que el usuario está conectado
        
        $_SESSION['user_name'] = $user['name']; // Guardamos el nombre del usuario en sesión
        
        $_SESSION['user_role'] = $user['role']; // Guardamos el rol del usuario en sesión (por ejemplo, 'admin' o 'user')
        
        header('Location: index.php');
        exit();
        
    } else {
        // error por Si el correo o la contraseña fallan
        $_SESSION['error_login'] = "Identifiants incorrects (Email ou Mot de passe invalide).";
        header('Location: login.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}