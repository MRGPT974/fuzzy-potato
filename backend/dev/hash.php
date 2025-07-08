<?php
$password = 'pro123'; // 🔒 Change ici le mot de passe que tu veux hasher

$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Mot de passe : $password\n";
echo "Hash généré :\n$hash\n";
?>
