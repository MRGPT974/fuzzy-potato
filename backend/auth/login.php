<?php
session_start();
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$email || empty($password)) {
        echo "❌ Champs invalides.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        echo "❌ Identifiants incorrects.";
        exit;
    }

    if (!$user['is_confirmed']) {
        echo "❌ Veuillez confirmer votre adresse email avant de vous connecter.";
        exit;
    }

    // ✅ Connexion réussie
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role']    = $user['role'];
    $_SESSION['ville']   = $user['ville'] ?? null; // utile pour pros
    $_SESSION['nom']     = $user['nom'];
    $_SESSION['prenom']  = $user['prenom'];

    switch ($user['role']) {
        case 'ADMIN':
            header("Location: ../../frontend/admin.php");
            exit;
        case 'PRO':
            header("Location: ../../frontend/dashboard-pro.php");
            exit;
        case 'PARENT':
            header("Location: ../../frontend/dashboard-parent.php");
            exit;
        default:
            echo "❌ Rôle utilisateur non reconnu.";
            exit;
    }
} else {
    echo "⛔ Méthode non autorisée.";
}
 