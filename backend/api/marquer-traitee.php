<?php
require_once(__DIR__ . '/../includes/session.php');
require_once('../config/db.php');
requireLogin('PRO');

header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$pro_ville = $_SESSION['ville'] ?? null;

if (!$id || !$pro_ville) {
    http_response_code(400);
    echo json_encode(['error' => 'ID ou ville manquant.']);
    exit;
}

try {
    // Vérifier si la demande appartient bien à la ville du pro
    $checkStmt = $pdo->prepare("SELECT id FROM demandes WHERE id = :id AND ville = :ville");
    $checkStmt->execute(['id' => $id, 'ville' => $pro_ville]);
    $found = $checkStmt->fetch();

    if (!$found) {
        http_response_code(403);
        echo json_encode(['error' => 'Demande introuvable ou non autorisée.']);
        exit;
    }

    // Mise à jour du statut
    $updateStmt = $pdo->prepare("UPDATE demandes SET statut = 'traitee' WHERE id = :id");
    $updateStmt->execute(['id' => $id]);

    http_response_code(200);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur.']);
}
