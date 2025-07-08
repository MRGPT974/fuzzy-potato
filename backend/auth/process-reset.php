<?php
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token   = $_POST['token'] ?? '';
    $pass    = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (!$token || !$pass || !$confirm) {
        $message = "❌ Tous les champs sont requis.";
    } elseif ($pass !== $confirm) {
        $message = "❌ Les mots de passe ne correspondent pas.";
    } elseif (strlen($pass) < 6) {
        $message = "❌ Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        // Vérification token
        $stmt = $pdo->prepare("SELECT id, reset_expires FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if (!$user || strtotime($user['reset_expires']) < time()) {
            $message = "⛔ Lien expiré ou invalide.";
        } else {
            // Mise à jour du mot de passe
            $hashed = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
            $stmt->execute([$hashed, $user['id']]);
            $message = "✅ Mot de passe mis à jour avec succès. Vous pouvez maintenant vous connecter.";
        }
    }
} else {
    $message = "⛔ Méthode non autorisée.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réinitialisation du mot de passe</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">
  <main class="max-w-xl mx-auto mt-24 bg-white p-8 rounded-xl shadow-lg text-center">
    <h1 class="text-2xl font-bold text-violet-700 mb-4">Réinitialisation</h1>
    <p class="text-lg text-gray-700"><?= htmlspecialchars($message) ?></p>

    <div class="mt-6">
      <a href="../../frontend/connexion-inscription.php" class="text-violet-600 hover:underline text-sm">← Retour à la connexion</a>
    </div>
  </main>
</body>
</html>
