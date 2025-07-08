<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inscription Pro - Tatienounou</title>
  <meta name="description" content="Tatienounou connecte parents et professionnels de la garde d'enfants à La Réunion." />
  <meta property="og:title" content="Inscription Pro - Tatienounou" />
  <meta property="og:description" content="Tatienounou connecte parents et professionnels de la garde d'enfants à La Réunion." />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="images/Mme Nobody &amp; baby 2.png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <header class="bg-violet-600 text-white text-center py-6 shadow">
    <h1 class="text-2xl font-semibold">Inscription - Professionnel</h1>
  </header>

  <main class="max-w-md mx-auto px-6 py-12 bg-white shadow-lg rounded-xl my-8">
    <form action="../backend/auth/register-pro.php" method="POST" class="space-y-4">

      <div>
        <label for="nom" class="block mb-1 font-semibold">Nom</label>
        <input type="text" name="nom" id="nom" required class="w-full border px-4 py-2 rounded">
      </div>

      <div>
        <label for="prenom" class="block mb-1 font-semibold">Prénom</label>
        <input type="text" name="prenom" id="prenom" required class="w-full border px-4 py-2 rounded">
      </div>

      <div>
        <label for="email" class="block mb-1 font-semibold">Email</label>
        <input type="email" name="email" id="email" required class="w-full border px-4 py-2 rounded">
      </div>

      <div>
        <label for="type_pro" class="block mb-1 font-semibold">Type de professionnel</label>
        <select name="type_pro" id="type_pro" required class="w-full border px-4 py-2 rounded">
          <option value="">-- Choisissez un type --</option>
          <option value="Assistante Maternelle agréée">Assistante Maternelle agréée</option>
          <option value="MAM">MAM</option>
          <option value="Micro-crèches">Micro-crèches</option>
          <option value="Crèches">Crèches</option>
        </select>
      </div>

      <div>
        <label for="ville" class="block mb-1 font-semibold">Ville</label>
        <select name="ville" id="ville" required class="w-full border px-4 py-2 rounded">
          <option value="">Sélectionnez votre ville</option>
          <option value="Bras-Panon">Bras-Panon</option>
          <option value="Cilaos">Cilaos</option>
          <option value="Entre-Deux">Entre-Deux</option>
          <option value="L'Étang-Salé">L'Étang-Salé</option>
          <option value="La Possession">La Possession</option>
          <option value="La Plaine-des-Palmistes">La Plaine-des-Palmistes</option>
          <option value="Le Port">Le Port</option>
          <option value="Le Tampon">Le Tampon</option>
          <option value="Les Avirons">Les Avirons</option>
          <option value="Les Trois-Bassins">Les Trois-Bassins</option>
          <option value="Petite-Île">Petite-Île</option>
          <option value="Saint-André">Saint-André</option>
          <option value="Saint-Benoît">Saint-Benoît</option>
          <option value="Saint-Denis">Saint-Denis</option>
          <option value="Sainte-Marie">Sainte-Marie</option>
          <option value="Sainte-Rose">Sainte-Rose</option>
          <option value="Sainte-Suzanne">Sainte-Suzanne</option>
          <option value="Saint-Joseph">Saint-Joseph</option>
          <option value="Saint-Leu">Saint-Leu</option>
          <option value="Saint-Louis">Saint-Louis</option>
          <option value="Saint-Paul">Saint-Paul</option>
          <option value="Saint-Pierre">Saint-Pierre</option>
          <option value="Salazie">Salazie</option>
        </select>
      </div>

      <div>
        <label for="password" class="block mb-1 font-semibold">Mot de passe</label>
        <input type="password" name="password" id="password" required class="w-full border px-4 py-2 rounded">
      </div>

      <div>
        <label for="confirm_password" class="block mb-1 font-semibold">Confirmer le mot de passe</label>
        <input type="password" name="confirm_password" id="confirm_password" required class="w-full border px-4 py-2 rounded">
      </div>

      <button type="submit" class="w-full bg-violet-600 text-white py-2 rounded hover:bg-violet-700">
        Créer un compte
      </button>

      <p class="text-center text-sm text-gray-500 mt-4">
        Déjà inscrit ? <a href="connexion-inscription.php" class="text-violet-600 hover:underline">Connectez-vous</a>
      </p>
    </form>
  </main>

  <footer class="text-center text-sm text-gray-400 mb-8">
    <a href="index.html" class="underline">← Retour à l'accueil</a>
  </footer>

</body>
</html>
