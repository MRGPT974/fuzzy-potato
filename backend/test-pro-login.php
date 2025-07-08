<?php
require_once('config/db.php');

$email = 'pro@tatienounou.fr';
$password = 'pro123';

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
  echo "❌ Utilisateur non trouvé.";
} elseif (!password_verify($password, $user['password'])) {
  echo "❌ Mot de passe invalide.";
} else {
  echo "✅ Connexion OK - rôle : " . $user['role'];
}
?>
