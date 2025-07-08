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
    echo json_encode(["error" => "Accès interdit."]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, nom, prenom, email, ville, type_pro, is_confirmed, created_at FROM users WHERE role = 'PRO'");
    $stmt->execute();
    $pros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($pros);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur.']);
}
