<?php
require_once(__DIR__ . '/../includes/session.php');
requireLogin('PRO');
require_once('../config/db.php');

// 🔍 Données actuelles
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT nom, prenom, email, ville, type_pro FROM users WHERE id = ?");
$stmt->execute([$userId]);
$pro = $stmt->fetch(PDO::FETCH_ASSOC);

// 🛠️ Mise à jour du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $ville = htmlspecialchars($_POST['ville']);
    $type_pro = htmlspecialchars($_POST['type_pro']);

    if ($nom && $prenom && $email && $ville && $type_pro) {
        $stmt = $pdo->prepare("UPDATE users SET nom = ?, prenom = ?, email = ?, ville = ?, type_pro = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $ville, $type_pro, $userId]);
        $message = "✅ Profil mis à jour avec succès.";
        $pro = ['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'ville' => $ville, 'type_pro' => $type_pro];
    } else {
        $message = "❌ Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Profil - Espace Pro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

  <?php include('header-pro.php'); ?>
  <?php include('menu-pro.php'); ?>

  <main class="max-w-3xl mx-auto my-12 px-4">
    <h1 class="text-2xl font-bold text-violet-700 mb-6">👤 Mon profil</h1>

    <?php if (isset($message)): ?>
      <div class="mb-4 p-4 rounded <?php echo strpos($message, '✅') === 0 ? 'bg-green-50 border-l-4 border-green-400' : 'bg-red-50 border-l-4 border-red-400'; ?>">
        <?= $message ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="bg-white shadow p-6 rounded-lg space-y-4">
      <input type="text" name="nom" value="<?= htmlspecialchars($pro['nom']) ?>" placeholder="Nom" required class="w-full border px-4 py-2 rounded">
      <input type="text" name="prenom" value="<?= htmlspecialchars($pro['prenom']) ?>" placeholder="Prénom" required class="w-full border px-4 py-2 rounded">
      <input type="email" name="email" value="<?= htmlspecialchars($pro['email']) ?>" placeholder="Email" required class="w-full border px-4 py-2 rounded">
      <input type="text" name="ville" value="<?= htmlspecialchars($pro['ville']) ?>" placeholder="Ville" required class="w-full border px-4 py-2 rounded">
      <select name="type_pro" class="w-full border px-4 py-2 rounded" required>
        <option value="">Sélectionnez un type</option>
        <option value="Assistante Maternelle agréée" <?= $pro['type_pro'] === 'Assistante Maternelle agréée' ? 'selected' : '' ?>>Assistante Maternelle agréée</option>
        <option value="MAM" <?= $pro['type_pro'] === 'MAM' ? 'selected' : '' ?>>MAM</option>
        <option value="Micro-crèche" <?= $pro['type_pro'] === 'Micro-crèche' ? 'selected' : '' ?>>Micro-crèche</option>
        <option value="Crèche" <?= $pro['type_pro'] === 'Crèche' ? 'selected' : '' ?>>Crèche</option>
      </select>
      <button type="submit" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">💾 Enregistrer</button>
    </form>
  </main>

</body>
</html>
