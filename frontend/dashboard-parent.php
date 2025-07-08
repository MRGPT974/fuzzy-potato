<?php
require_once('../backend/includes/session.php');
requireLogin('PARENT');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tableau de bord - Parent</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-violet-600 text-white py-6 text-center shadow relative">
    <h1 class="text-2xl font-semibold">Espace Parent</h1>
    <div class="absolute top-4 right-6">
      <a href="../backend/auth/logout.php" class="text-sm bg-white text-violet-700 px-4 py-1 rounded shadow hover:bg-gray-100 transition">
        Se déconnecter
      </a>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-4xl mx-auto px-4 py-8">
    <h2 class="text-xl font-bold mb-4">Vos demandes de garde</h2>

    <div id="demandes-container" class="space-y-4">
      <!-- Les demandes seront insérées ici -->
    </div>

    <!-- Formulaire création -->
    <form action="../backend/requests/create.php" method="POST" class="mt-10 space-y-4 bg-white p-6 rounded-xl shadow">
      <h3 class="text-lg font-semibold mb-2">Créer une nouvelle demande</h3>
      <input type="text" name="titre" placeholder="Titre de la demande" required class="w-full border px-4 py-2 rounded" />
      <textarea name="description" placeholder="Description" required class="w-full border px-4 py-2 rounded"></textarea>
      <button type="submit" class="bg-violet-600 text-white py-2 px-6 rounded hover:bg-violet-700 transition">Envoyer</button>
    </form>
  </main>

  <!-- Script de chargement des demandes -->
  <script>
    fetch('../backend/dashboard/parent.php')
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById('demandes-container');
        if (!data || data.length === 0) {
          container.innerHTML = '<p class="text-gray-500">Aucune demande enregistrée pour le moment.</p>';
        } else {
          data.forEach(demande => {
            const card = document.createElement('div');
            card.className = "bg-white shadow p-4 rounded flex justify-between items-start gap-4";

            const blocTextes = document.createElement('div');
            blocTextes.innerHTML = `
              <h4 class="font-bold">${demande.titre}</h4>
              <p class="text-sm text-gray-600">${demande.description}</p>
              <p class="text-xs text-gray-400 italic">Ville : ${demande.ville ?? 'Non spécifiée'}</p>
            `;

            const supprimer = document.createElement('a');
            supprimer.href = `../backend/requests/delete.php?id=${demande.id}`;
            supprimer.textContent = "Supprimer";
            supprimer.className = "text-red-600 font-semibold hover:underline text-sm";

            card.appendChild(blocTextes);
            card.appendChild(supprimer);
            container.appendChild(card);
          });
        }
      })
      .catch(error => {
        document.getElementById('demandes-container').innerHTML = '<p class="text-red-500">Erreur lors du chargement des demandes.</p>';
        console.error(error);
      });
  </script>

</body>
</html>
