<?php
require_once('../config/db.php');
require_once('../config/config.php');

$token = $_GET['token'] ?? '';

if (!$token || !preg_match('/^[a-f0-9]{64}$/', $token)) {
    $message = "❌ Lien invalide.";
} else {
    $stmt = $pdo->prepare("SELECT id, email_confirmed FROM users WHERE confirmation_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        $message = "❌ Ce lien est invalide ou a déjà été utilisé.";
    } elseif ($user['email_confirmed']) {
        $message = "✅ Adresse e-mail déjà confirmée. Vous pouvez vous connecter.";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET email_confirmed = 1, confirmation_token = NULL WHERE id = ?");
        $stmt->execute([$user['id']]);
        $message = "✅ Votre adresse e-mail a été confirmée avec succès. Vous pouvez maintenant vous connecter.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation e-mail</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">
  <main class="max-w-xl mx-auto mt-24 bg-white p-8 rounded-xl shadow-lg text-center">
    <h1 class="text-2xl font-bold text-violet-700 mb-4">Confirmation</h1>
    <p class="text-lg text-gray-700"><?= htmlspecialchars($message) ?></p>
    
    <div class="mt-6">
      <a href="../frontend/connexion-inscription.php" class="text-violet-600 hover:underline text-sm">← Retour à la connexion</a>
    </div>
  </main>
</body>
</html>
