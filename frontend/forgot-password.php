<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mot de passe oublié</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

  <main class="max-w-md mx-auto mt-20 bg-white p-8 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold text-center text-violet-700 mb-6">Mot de passe oublié</h1>

    <form action="../backend/auth/send-reset.php" method="POST" class="space-y-4">
      <div>
        <label for="email" class="block mb-1 font-semibold">Votre adresse email</label>
        <input type="email" name="email" id="email" required class="w-full border px-4 py-2 rounded" placeholder="exemple@domaine.com">
      </div>

      <button type="submit" class="w-full bg-violet-600 text-white py-2 rounded hover:bg-violet-700">
        Envoyer le lien de réinitialisation
      </button>

      <p class="text-sm text-gray-500 text-center mt-4">
        Si cette adresse existe, un lien vous sera envoyé par email.
      </p>
    </form>

    <div class="text-center mt-6">
      <a href="connexion-inscription.php" class="text-violet-600 text-sm hover:underline">← Retour à la connexion</a>
    </div>
  </main>

</body>
</html>
