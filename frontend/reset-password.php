<?php
$token = $_GET['token'] ?? '';
if (!$token || !preg_match('/^[a-zA-Z0-9]{32,}$/', $token)) {
  die("⛔ Lien invalide.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Tatienounou connecte parents et professionnels de la garde d'enfants à La Réunion." />
  <meta property="og:title" content="Réinitialisation du mot de passe" />
  <meta property="og:description" content="Tatienounou connecte parents et professionnels de la garde d'enfants à La Réunion." />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="images/Mme Nobody &amp; baby 2.png" />
  <title>Réinitialisation du mot de passe</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">
  <main class="max-w-md mx-auto mt-20 bg-white p-8 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold text-center text-violet-700 mb-6">Nouveau mot de passe</h1>
    <form action="../backend/auth/process-reset.php" method="POST" class="space-y-4">
      <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
      
      <div>
        <label for="password" class="block mb-1 font-semibold">Nouveau mot de passe</label>
        <input type="password" name="password" id="password" required class="w-full border px-4 py-2 rounded">
      </div>

      <div>
        <label for="confirm" class="block mb-1 font-semibold">Confirmer le mot de passe</label>
        <input type="password" name="confirm" id="confirm" required class="w-full border px-4 py-2 rounded">
      </div>

      <button type="submit" class="w-full bg-violet-600 text-white py-2 rounded hover:bg-violet-700">
        Réinitialiser le mot de passe
      </button>

      <p class="text-sm text-gray-500 text-center mt-4">
        Vous allez pouvoir vous reconnecter avec votre nouveau mot de passe.
      </p>
    </form>

    <div class="text-center mt-6">
      <a href="connexion-inscription.php" class="text-violet-600 text-sm hover:underline">← Retour à la connexion</a>
    </div>
  </main>
</body>
</html>
