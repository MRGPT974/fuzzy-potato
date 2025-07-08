<?php
require_once(__DIR__ . '/../includes/session.php');
requireLogin('PRO');
require_once('../config/db.php');

$userId = $_SESSION['user_id'];

// 🔍 Récupération du nombre de demandes
$stmt = $pdo->prepare("SELECT COUNT(*) FROM demandes WHERE pro_id = ?");
$stmt->execute([$userId]);
$nbDemandes = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pro - Tatienounou</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

  <?php include('header-pro.php'); ?>
  <?php include('menu-pro.php'); ?>

  <main class="max-w-5xl mx-auto my-12 px-4">
    <h1 class="text-2xl font-bold text-violet-700 mb-6">🏠 Tableau de bord</h1>

    <div class="grid md:grid-cols-3 gap-6 mb-8">
      <!-- Bloc demandes -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-2 text-violet-600">📥 Demandes reçues</h2>
        <p class="text-3xl font-bold text-gray-800"><?= $nbDemandes ?></p>
        <a href="demandes.php" class="text-sm text-violet-600 hover:underline mt-2 inline-block">Voir les demandes</a>
      </div>

      <!-- Bloc abonnement -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-2 text-violet-600">📦 Abonnement</h2>
        <p class="text-gray-700">Vérifiez ou modifiez votre abonnement.</p>
        <a href="abonnement.php" class="text-sm text-violet-600 hover:underline mt-2 inline-block">Gérer mon abonnement</a>
      </div>

      <!-- Bloc profil -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-2 text-violet-600">👤 Profil</h2>
        <p class="text-gray-700">Modifiez vos informations personnelles.</p>
        <a href="pro.php" class="text-sm text-violet-600 hover:underline mt-2 inline-block">Voir mon profil</a>
      </div>
    </div>

    <div class="bg-violet-50 border-l-4 border-violet-600 p-4 rounded text-sm text-gray-700">
      ✅ Astuce : pensez à maintenir vos disponibilités à jour pour recevoir plus de demandes.
    </div>
  </main>

</body>
</html>
