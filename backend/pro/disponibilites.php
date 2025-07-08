<?php
require_once(__DIR__ . '/../includes/session.php');
requireLogin('PRO');
require_once('../config/db.php');

$userId = $_SESSION['user_id'];

// Récupération des disponibilités existantes
$stmt = $pdo->prepare("SELECT disponibilite FROM disponibilites WHERE pro_id = ?");
$stmt->execute([$userId]);
$disponibilites = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Disponibilités</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

  <?php include('header-pro.php'); ?>
  <?php include('menu-pro.php'); ?>

  <main class="max-w-3xl mx-auto my-12 px-4">
    <h1 class="text-2xl font-bold text-violet-700 mb-6">📅 Mes disponibilités</h1>

    <?php if (count($disponibilites) === 0): ?>
      <p class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-4">Vous n’avez pas encore renseigné vos disponibilités.</p>
    <?php else: ?>
      <ul class="list-disc list-inside bg-white p-6 rounded-lg shadow mb-4">
        <?php foreach ($disponibilites as $jour): ?>
          <li class="text-gray-700"><?= htmlspecialchars($jour) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <a href="ajouter-disponibilite.php" class="inline-block bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
      ➕ Ajouter une disponibilité
    </a>
  </main>

</body>
</html>
