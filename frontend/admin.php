<?php
require_once('../backend/includes/session.php');
requireLogin('ADMIN');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Tatienounou</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Header -->
  <header class="bg-gray-800 text-white text-center py-6 shadow relative">
    <h1 class="text-2xl font-semibold">Espace Administrateur</h1>
    <div class="absolute top-6 right-6">
      <a href="../backend/auth/logout.php" class="bg-white text-violet-700 border border-violet-600 px-4 py-1 rounded shadow hover:bg-gray-100 text-sm">
        Déconnexion
      </a>
    </div>
  </header>

  <main class="max-w-7xl mx-auto px-6 py-10 space-y-12">

    <!-- Statistiques -->
    <section>
      <h2 class="text-xl font-semibold mb-4">Statistiques globales</h2>
      <div id="stats" class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center text-white">
        <div class="bg-violet-600 p-6 rounded-xl shadow">
          <p class="text-4xl font-bold" id="nb-parents">-</p>
          <p>Parents inscrits</p>
        </div>
        <div class="bg-emerald-600 p-6 rounded-xl shadow">
          <p class="text-4xl font-bold" id="nb-pros">-</p>
          <p>Professionnels</p>
        </div>
        <div class="bg-orange-500 p-6 rounded-xl shadow">
          <p class="text-4xl font-bold" id="nb-demandes">-</p>
          <p>Demandes de garde</p>
        </div>
      </div>
    </section>

    <!-- Utilisateurs -->
    <section>
      <h2 class="text-xl font-semibold mb-4">Utilisateurs</h2>
      <div id="user-list" class="space-y-2"></div>
    </section>

    <!-- Demandes -->
    <section>
      <h2 class="text-xl font-semibold mb-4">Demandes de garde</h2>
      <div id="demandes-list" class="space-y-2"></div>
    </section>

  </main>

  <script>
    // Statistiques
    fetch('../backend/admin/stats.php')
      .then(res => res.json())
      .then(data => {
        document.getElementById('nb-parents').textContent = data.parents;
        document.getElementById('nb-pros').textContent = data.pros;
        document.getElementById('nb-demandes').textContent = data.demandes;
      });

    // Utilisateurs
    fetch('../backend/admin/users.php')
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById('user-list');
        data.forEach(user => {
          const nomComplet = `${user.nom} ${user.prenom}`;
          let lien = "#";
          let classe = "text-gray-700";
          if (user.role === 'PRO') {
            lien = `fiche-pro.php?id=${user.id}`;
            classe = "text-violet-700";
          } else if (user.role === 'PARENT') {
            lien = `fiche-parent.php?id=${user.id}`;
            classe = "text-blue-700";
          }

          container.innerHTML += `
            <div class="bg-white p-4 shadow rounded-xl flex justify-between items-center">
              <div>
                <p class="font-bold"><a href="${lien}" class="${classe} hover:underline">${nomComplet}</a></p>
                <p class="text-sm text-gray-500">${user.email}</p>
              </div>
              <span class="px-2 py-1 rounded-full text-xs font-semibold ${
                user.role === 'PRO' ? 'bg-green-100 text-green-800' :
                user.role === 'PARENT' ? 'bg-blue-100 text-blue-800' :
                'bg-red-100 text-red-800'
              }">${user.role}</span>
            </div>
          `;
        });
      });

    // Demandes
    fetch('../backend/admin/demandes.php')
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById('demandes-list');
        data.forEach(demande => {
          container.innerHTML += `
            <div class="bg-white p-4 shadow rounded-xl">
              <p class="font-bold">${demande.titre}</p>
              <p class="text-sm text-gray-600">${demande.description}</p>
              <p class="text-xs text-gray-400 mt-2">ID: ${demande.id} – Parent ID: ${demande.user_id}</p>
            </div>
          `;
        });
      });
  </script>
</body>
</html>
