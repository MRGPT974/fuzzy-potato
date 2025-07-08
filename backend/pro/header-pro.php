<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userName = $_SESSION['nom'] ?? 'Professionnel';
$initiales = strtoupper(substr($userName, 0, 1));
?>

<header class="bg-violet-700 text-white px-6 py-4 shadow flex justify-between items-center">
  <div class="text-xl font-semibold">👩‍👧‍👦 Espace Professionnel</div>

  <div class="flex items-center gap-4">
    <!-- Avatar avec initiales -->
    <div class="w-10 h-10 rounded-full bg-violet-500 flex items-center justify-center font-bold text-white">
      <?= $initiales ?>
    </div>

    <!-- Nom -->
    <span class="hidden sm:inline text-sm font-medium"><?= htmlspecialchars($userName) ?></span>

    <!-- Déconnexion -->
    <a href="../logout.php" class="bg-white text-violet-700 hover:bg-gray-200 px-3 py-1 rounded text-sm font-semibold">
      Déconnexion
    </a>
  </div>
</header>
