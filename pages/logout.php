<?php
/**
 * ============================================
 * SCRIPT DE DÉCONNEXION (LOGOUT)
 * ============================================
 * * Ce script est "invisible" pour l'utilisateur.
 * Il détruit la session active et redirige immédiatement vers l'accueil.
 */

// 1. TOUJOURS DÉMARRER LA SESSION EN PREMIER
// (PHP a besoin de savoir QUELLE session il doit détruire)
session_start();

// 2. VIDER LES VARIABLES DE SESSION
// On remplace le tableau $_SESSION par un tableau vide
$_SESSION = [];

// (Alternative / Sécurité supplémentaire : détruire les variables en mémoire)
session_unset();

// 3. DÉTRUIRE LA SESSION SUR LE SERVEUR
// Supprime le fichier temporaire de session côté serveur
session_destroy();

// 4. REDIRECTION IMMÉDIATE
// On renvoie l'utilisateur sur la page d'accueil en mode "invité"
header('Location: index.php');
exit();