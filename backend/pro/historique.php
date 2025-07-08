<?php
require_once(__DIR__ . '/../includes/session.php');
requireLogin('PRO');
require_once('../config/db.php');

// 🔍 Ville du pro connecté
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT ville FROM users WHERE id = ?");
$stmt->execute([$userId]);
$ville = $stmt->fetchColumn();

// 📦 Requête pour demandes traitées dans cette ville
$stmt = $pdo->prepare("
    SELECT d.titre, d.description, d.ville, d.created_at, u.nom AS nom_parent, u.email AS email_parent
    FROM demandes d
    JOIN users u ON d.user_id = u.id
    WHERE d.ville = ? AND d.statut = 'traitee'
    ORDER BY d.created_at DESC
");
$stmt->execute([$ville]);
$demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Historique des demandes</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

  <?php include('header-pro.php'); ?>
  <?php include('menu-pro.php'); ?>

  <main class="max-w-5xl mx-auto my-12 px-4">
    <h1 class="text-2xl font-bold text-violet-700 mb-6">🕘 Historique des demandes traitées</h1>

    <?php if (count($demandes) === 0): ?>
      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
        Aucune demande traitée trouvée dans votre ville.
      </div>
    <?php else: ?>
      <div class="grid gap-6">
        <?php foreach ($demandes as $demande): ?>
          <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold text-violet-700"><?= htmlspecialchars($demande['titre']) ?></h2>
            <p class="text-gray-700 mb-2"><?= nl2br(htmlspecialchars($demande['description'])) ?></p>
            <p class="text-sm text-gray-600">Demandée par <?= htmlspecialchars($demande['nom_parent']) ?> (<?= htmlspecialchars($demande['email_parent']) ?>)</p>
            <p class="text-xs text-gray-500">Date : <?= date('d/m/Y H:i', strtotime($demande['created_at'])) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

</body>
</html>
