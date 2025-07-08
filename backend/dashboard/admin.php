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
    $stmt = $pdo->query("SELECT id, nom, prenom, email, role, ville, type_pro, email_confirmed, created_at FROM users ORDER BY role, nom");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors du chargement des utilisateurs.']);
}
