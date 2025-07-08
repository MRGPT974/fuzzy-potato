<?php
require_once(__DIR__ . '/../includes/session.php');
requireLogin('PRO');
require_once('../config/db.php');

// 🔍 Récupération du statut d’abonnement
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT abonnement_actif, abonnement_expiration FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon Abonnement</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

  <?php include('header-pro.php'); ?>
  <?php include('menu-pro.php'); ?>

  <main class="max-w-3xl mx-auto my-12 bg-white shadow-md rounded-lg p-8">
    <h1 class="text-2xl font-bold text-violet-700 mb-6">📦 Mon abonnement</h1>

    <?php if ($user && $user['abonnement_actif']): ?>
      <div class="text-green-600 font-semibold mb-4">✅ Votre abonnement est actif.</div>
      <p class="text-gray-700">Expiration : <strong><?= htmlspecialchars($user['abonnement_expiration']) ?></strong></p>
    <?php else: ?>
      <div class="text-red-600 font-semibold mb-4">❌ Vous n'avez pas d’abonnement actif.</div>
      <a href="paiement.php" class="inline-block bg-violet-600 text-white px-4 py-2 mt-4 rounded hover:bg-violet-700">Souscrire un abonnement</a>
    <?php endif; ?>
  </main>

</body>
</html>
