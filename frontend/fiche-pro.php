<?php
require_once('../backend/includes/session.php');
require_once('../backend/config/db.php');
requireLogin('ADMIN');

if (!isset($_GET['id'])) {
  echo "ID manquant.";
  exit;
}

$id = (int) $_GET['id'];

// Requête avec jointure entre users et pros_info
$stmt = $pdo->prepare("
  SELECT u.*, p.type_pro, p.presentation, p.capacite, p.disponibilite, p.telephone, p.justificatif
  FROM users u
  LEFT JOIN pros_info p ON u.id = p.user_id
  WHERE u.id = ? AND u.role = 'PRO'
");
$stmt->execute([$id]);
$pro = $stmt->fetch();

if (!$pro) {
  echo "Professionnel introuvable.";
  exit;
}

// Traitement désactivation/réactivation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['desactiver'])) {
    $pdo->prepare("UPDATE users SET actif = 0 WHERE id = ?")->execute([$id]);
    header("Location: fiche-pro.php?id=$id");
    exit;
  }
  if (isset($_POST['reactiver'])) {
    $pdo->prepare("UPDATE users SET actif = 1 WHERE id = ?")->execute([$id]);
    header("Location: fiche-pro.php?id=$id");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fiche Pro - Tatienounou</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

  <header class="bg-violet-600 text-white text-center py-6 shadow">
    <h1 class="text-2xl font-semibold">Fiche professionnel</h1>
  </header>

  <main class="max-w-4xl mx-auto px-6 py-10 space-y-6">
    <div class="bg-white shadow-lg rounded-xl p-6 space-y-6">

      <!-- Profil -->
      <section class="text-center">
        <h2 class="text-xl font-bold text-violet-700">👩‍🏫 <?= htmlspecialchars($pro['prenom']) . ' ' . htmlspecialchars($pro['nom']) ?></h2>
        <p class="text-sm text-gray-500">Inscrit : <?= htmlspecialchars($pro['created_at'] ?? '—') ?></p>
        <p class="text-xs text-gray-400">
          ID : <?= $pro['id'] ?> |
          Confirmé : <?= $pro['email_confirmed'] ? '✅' : '❌' ?> |
          Actif : <?= $pro['actif'] ? '✅' : '❌' ?>
        </p>
      </section>

      <!-- Infos -->
      <section class="grid md:grid-cols-2 gap-6">
        <div>
          <h3 class="text-md font-semibold mb-2">Informations générales</h3>
          <ul class="text-sm space-y-1">
            <li><strong>Email :</strong> <?= htmlspecialchars($pro['email']) ?></li>
            <li><strong>Type :</strong> <?= htmlspecialchars($pro['type_pro'] ?? 'Non renseigné') ?></li>
            <li><strong>Téléphone :</strong> <?= htmlspecialchars($pro['telephone'] ?? 'Non renseigné') ?></li>
            <li><strong>Ville :</strong> <?= htmlspecialchars($pro['ville'] ?? '—') ?></li>
          </ul>
        </div>

        <div>
          <h3 class="text-md font-semibold mb-2">Disponibilité & justificatif</h3>
          <ul class="text-sm space-y-1">
            <li><strong>Capacité :</strong> <?= htmlspecialchars($pro['capacite'] ?? '—') ?> enfants</li>
            <li><strong>Disponibilité :</strong> <?= htmlspecialchars($pro['disponibilite'] ?? '—') ?></li>
            <li><strong>Justificatif :</strong>
              <?= isset($pro['justificatif']) ? '<a href="' . htmlspecialchars($pro['justificatif']) . '" class="text-violet-700 underline" target="_blank">Voir le document</a>' : 'Non fourni' ?>
            </li>
          </ul>
        </div>
      </section>

      <!-- Présentation -->
      <?php if (!empty($pro['presentation'])): ?>
        <section>
          <h3 class="text-md font-semibold mb-2">Présentation</h3>
          <p class="text-sm text-gray-600 whitespace-pre-line"><?= htmlspecialchars($pro['presentation']) ?></p>
        </section>
      <?php endif; ?>

      <!-- Actions -->
      <section class="flex justify-between items-center">
        <a href="admin.php" class="text-sm text-gray-500 hover:text-violet-600 underline">← Retour admin</a>
        <form method="POST">
          <?php if ($pro['actif']): ?>
            <button type="submit" name="desactiver" class="text-sm bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Désactiver</button>
          <?php else: ?>
            <button type="submit" name="reactiver" class="text-sm bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Réactiver</button>
          <?php endif; ?>
        </form>
      </section>
    </div>
  </main>

  <footer class="bg-gray-100 text-sm text-center py-8 mt-10">
    <div class="flex justify-center gap-6 flex-wrap text-gray-600 mb-4">
      <a href="footer/mentions-legales.html" class="hover:underline">Mentions légales</a>
      <a href="footer/confidentialite.html" class="hover:underline">Politique de confidentialité</a>
      <a href="footer/cookies.html" class="hover:underline">Cookies</a>
      <a href="footer/cgv.html" class="hover:underline">CGV</a>
      <a href="footer/cgu.html" class="hover:underline">CGU</a>
      <a href="contact.html" class="hover:underline">Contact</a>
    </div>
    <p class="text-gray-500">&copy; 2025 Tatienounou.fr – Tous droits réservés.</p>
  </footer>

</body>
</html>
