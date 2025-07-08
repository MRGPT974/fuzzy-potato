<?php
require_once(__DIR__ . '/../includes/session.php');
requireLogin('PRO');
require_once('../config/db.php');

$userId = $_SESSION['user_id'];

// 🔍 Récupération des demandes reçues par le pro
$stmt = $pdo->prepare("SELECT * FROM demandes WHERE pro_id = ? ORDER BY date_creation DESC");
$stmt->execute([$userId]);
$demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Demandes reçues</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

  <?php include('header-pro.php'); ?>
  <?php include('menu-pro.php'); ?>

  <main class="max-w-5xl mx-auto my-12 px-4">
    <h1 class="text-2xl font-bold text-violet-700 mb-6">📥 Demandes reçues</h1>

    <?php if (count($demandes) === 0): ?>
      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
        <p>Aucune demande reçue pour le moment.</p>
      </div>
    <?php else: ?>
      <div class="grid gap-6">
        <?php foreach ($demandes as $demande): ?>
          <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-violet-700 mb-2"><?= htmlspecialchars($demande['titre']) ?></h2>
            <p class="text-gray-700 text-sm mb-2"><?= nl2br(htmlspecialchars($demande['message'])) ?></p>
            <p class="text-gray-500 text-sm">Envoyée le <?= date('d/m/Y à H:i', strtotime($demande['date_creation'])) ?></p>
            <p class="text-sm text-gray-600 mt-1"><strong>Ville :</strong> <?= htmlspecialchars($demande['ville']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

</body>
</html>
