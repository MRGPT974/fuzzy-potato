<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
<?php
require_once('../config/db.php');
require_once(__DIR__ . '/../includes/session.php');
requireLogin();

if ($_SESSION['role'] !== 'ADMIN') {
    http_response_code(403);
    echo json_encode(["error" => "Accès refusé."]);
    exit;
}

try {
    $stats = [];

    $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'PARENT'");
    $stats['parents'] = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'PRO'");
    $stats['pros'] = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM demandes");
    $stats['demandes'] = $stmt->fetchColumn();

    header('Content-Type: application/json');
    echo json_encode($stats);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur lors du chargement des statistiques.']);
}
