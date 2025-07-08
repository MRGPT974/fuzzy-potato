<?php
require_once('../config/db.php');
require_once(__DIR__ . '/../includes/session.php');
requireLogin('PARENT');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id       = intval($_GET['id']);
    $user_id  = $_SESSION['user_id'];

    try {
        // ✅ Supprime uniquement si l'utilisateur est le propriétaire
        $stmt = $pdo->prepare("DELETE FROM demandes WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);

        header("Location: ../../frontend/dashboard-parent.php");
        exit;
    } catch (PDOException $e) {
        http_response_code(500);
        echo "❌ Erreur lors de la suppression : " . $e->getMessage();
    }
} else {
    http_response_code(400);
    echo "❌ ID manquant ou méthode non autorisée.";
}
