<?php
require_once('../config/db.php');
require_once(__DIR__ . '/../includes/session.php');
requireLogin('PARENT');

$user_id = $_SESSION['user_id'];

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("SELECT id, titre, description, ville, statut, created_at FROM demandes WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($demandes);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors du chargement de vos demandes.']);
}
