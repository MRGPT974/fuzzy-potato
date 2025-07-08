<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
<?php
require_once(__DIR__ . '/../includes/session.php');
require_once('../config/db.php');
requireLogin('PRO');

header('Content-Type: application/json');

$pro_id = $_SESSION['user_id'] ?? null;

// Récupérer la ville du pro connecté
$stmt = $pdo->prepare("SELECT ville FROM users WHERE id = ?");
$stmt->execute([$pro_id]);
$pro_ville = $stmt->fetchColumn();

if (!$pro_ville) {
    echo json_encode([]);
    exit;
}

try {
    $sql = "SELECT d.id, d.titre, d.description, d.ville, u.nom AS nom_parent, u.email AS email_parent
            FROM demandes d
            JOIN users u ON d.user_id = u.id
            WHERE d.ville = :ville AND d.statut != 'traitee'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['ville' => $pro_ville]);
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($demandes);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors du chargement des demandes.']);
}
