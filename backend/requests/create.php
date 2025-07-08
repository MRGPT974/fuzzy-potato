<?php
require_once('../config/db.php');
require_once(__DIR__ . '/../includes/session.php');
requireLogin('PARENT');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre       = htmlspecialchars(trim($_POST['titre'] ?? ''));
    $description = htmlspecialchars(trim($_POST['description'] ?? ''));
    $user_id     = $_SESSION['user_id'];

    if (empty($titre) || empty($description)) {
        http_response_code(400);
        echo "❌ Tous les champs sont requis.";
        exit;
    }

    try {
        // 🔍 Récupérer la ville du parent connecté
        $stmt = $pdo->prepare("SELECT ville FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $ville = $stmt->fetchColumn();

        if (!$ville) {
            http_response_code(400);
            echo "❌ Impossible de récupérer votre ville.";
            exit;
        }

        // ✅ Insérer la demande
        $stmt = $pdo->prepare("INSERT INTO demandes (titre, description, user_id, ville) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titre, $description, $user_id, $ville]);

        // 🔁 Redirection après succès
        header("Location: ../../frontend/dashboard-parent.php");
        exit;
    } catch (PDOException $e) {
        http_response_code(500);
        echo "❌ Erreur serveur : " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "⛔ Méthode non autorisée.";
}
