<?php
session_start();

function requireLogin($role = null) {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        // Redirige vers la connexion si non connecté
        header('Location: ../connexion-inscription.php');
        exit;
    }

    if ($role && $_SESSION['role'] !== $role) {
        http_response_code(403);
        echo "⛔ Accès refusé : rôle non autorisé.";
        exit;
    }
}
