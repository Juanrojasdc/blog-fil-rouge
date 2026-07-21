<?php
// ============================================
// LOGIQUE DE CONNEXION (Procesamiento POST)
// ============================================

// Evaluamos si el formulario de login ha sido enviado
if (isset($_POST['mail']) && isset($_POST['mdp'])) {
    
    $email = trim($_POST['mail']);
    $password = trim($_POST['mdp']);

    // Consulta SQL para obtener el usuario por email
    $sql = 'SELECT * FROM users WHERE email = :mail_recibido'; 
    $query = $mysqlClient->prepare($sql); 
    $query->execute(['mail_recibido' => $email]); 
    
    $user = $query->fetch(); 

    // Validación de contraseña (tal cual lo tenías)
    if ($user && $user['pswd'] === $password) {
        
        $_SESSION['user_connected'] = true; 
        $_SESSION['user_name'] = $user['name']; 
        $_SESSION['user_role'] = $user['role']; 
        
        header('Location: index.php');
        exit();
        
    } else {
        $_SESSION['error_login'] = "Identifiants incorrects (Email ou Mot de passe invalide).";
        header('Location: index.php?page=login');
        exit();
    }
}