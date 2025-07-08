<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion - Tatienounou</title>
  <meta name="description" content="Tatienounou connecte parents et professionnels de la garde d'enfants à La Réunion." />
  <meta property="og:title" content="Connexion - Tatienounou" />
  <meta property="og:description" content="Tatienounou connecte parents et professionnels de la garde d'enfants à La Réunion." />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="images/Mme Nobody &amp; baby 2.png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <main class="max-w-md mx-auto mt-20 bg-white p-8 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold text-center text-violet-700 mb-6">Connexion</h1>

    <form action="../backend/auth/login.php" method="POST" class="space-y-5">
      <div>
        <label for="email" class="block mb-1 font-semibold">Adresse e-mail</label>
        <input type="email" id="email" name="email" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-violet-300" />
      </div>

      <div>
        <label for="password" class="block mb-1 font-semibold">Mot de passe</label>
        <input type="password" id="password" name="password" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-violet-300" />
      </div>

      <button type="submit" class="w-full bg-violet-600 text-white py-2 rounded hover:bg-violet-700 transition">
        Se connecter
      </button>
    </form>

    <div class="text-center text-sm text-gray-500 mt-6 space-y-2">
      <p>
        <a href="forgot-password.php" class="text-violet-600 hover:underline">
          Mot de passe oublié ?
        </a>
      </p>
      <p>
        Pas reçu l’e-mail de confirmation ?
        <a href="resend-confirmation.php" class="text-violet-600 hover:underline">
          Renvoyer le lien
        </a>
      </p>
    </div>

    <p class="text-center text-sm text-gray-500 mt-6">
      Pas encore inscrit ?
      <a href="register-parent.php" class="text-violet-600 hover:underline">Créer un compte parent</a> |
      <a href="register-pro.php" class="text-violet-600 hover:underline">Créer un compte pro</a>
    </p>
  </main>

  <footer class="text-center text-sm text-gray-400 mt-10">
    <a href="index.html" class="underline">← Retour à l'accueil</a>
  </footer>

</body>
</html>
