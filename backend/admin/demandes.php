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

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT id, titre, description, user_id FROM demandes ORDER BY id DESC");
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($demandes);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur lors de la récupération des demandes."]);
}
