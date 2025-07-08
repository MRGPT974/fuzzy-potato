<?php
require_once('../backend/includes/session.php');
require_once('../backend/config/db.php');
requireLogin('ADMIN');

if (!isset($_GET['id'])) {
  echo "ID manquant.";
  exit;
}

$id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['desactiver'])) {
    $stmt = $pdo->prepare("UPDATE users SET actif = 0 WHERE id = ? AND role = 'PARENT'");
    $stmt->execute([$id]);
    header("Location: fiche-parent.php?id=$id");
    exit;
  }
  if (isset($_POST['reactiver'])) {
    $stmt = $pdo->prepare("UPDATE users SET actif = 1 WHERE id = ? AND role = 'PARENT'");
    $stmt->execute([$id]);
    header("Location: fiche-parent.php?id=$id");
    exit;
  }
}

// Infos du parent
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND role = 'PARENT'");
$stmt->execute([$id]);
$parent = $stmt->fetch();

if (!$parent) {
  echo "Parent introuvable.";
  exit;
}

// Demandes liées à ce parent
$stmt = $pdo->prepare("SELECT * FROM demandes WHERE parent_id = ?");
$stmt->execute([$parent['id']]);
$demandes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Fiche Parent - Tatienounou</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

  <header class="bg-violet-600 text-white text-center py-6 shadow">
    <h1 class="text-2xl font-semibold">Fiche parent</h1>
  </header>

  <main class="max-w-4xl mx-auto px-6 py-10 space-y-6">
    <div class="bg-white shadow-lg rounded-xl p-6 space-y-6">

      <!-- Infos parent -->
      <section class="text-center">
        <h2 class="text-xl font-bold text-violet-700">👨‍👩‍👧 <?= htmlspecialchars($parent['prenom']) . ' ' . htmlspecialchars($parent['nom']) ?></h2>
        <p class="text-sm text-gray-500">Email : <?= htmlspecialchars($parent['email']) ?></p>
        <p class="text-sm text-gray-500">Ville : <?= htmlspecialchars($parent['ville'] ?? 'Non renseignée') ?></p>
        <p class="text-xs text-gray-400 mt-2">
          ID : <?= $parent['id'] ?> |
          Inscrit : <?= htmlspecialchars($parent['created_at'] ?? '—') ?> |
          Confirmé : <?= $parent['email_confirmed'] ? '✅' : '❌' ?> |
          Actif : <?= $parent['actif'] ? '✅' : '❌' ?>
        </p>
      </section>

      <!-- Demandes -->
      <section>
        <h3 class="text-md font-semibold mb-2">Demandes enregistrées</h3>
        <?php if (count($demandes) === 0): ?>
          <p class="text-sm italic text-gray-500">Aucune demande.</p>
        <?php else: ?>
          <ul class="space-y-2 text-sm">
            <?php foreach ($demandes as $demande): ?>
              <li class="bg-gray-50 border rounded p-3">
                <strong><?= htmlspecialchars($demande['titre']) ?></strong><br>
                <?= nl2br(htmlspecialchars($demande['description'])) ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </section>

      <!-- Actions admin -->
      <section class="flex justify-between items-center">
        <a href="admin.php" class="text-sm text-gray-500 hover:text-violet-600 underline">← Retour admin</a>
        <form method="POST">
          <?php if ($parent['actif']): ?>
            <button type="submit" name="desactiver" class="text-sm bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
              Désactiver le compte
            </button>
          <?php else: ?>
            <button type="submit" name="reactiver" class="text-sm bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
              Réactiver le compte
            </button>
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
