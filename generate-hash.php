<?php
$mdp = "admin1234";
$hash = password_hash($mdp, PASSWORD_DEFAULT);
echo "Mot de passe : $mdp<br>";
echo "Hash généré : $hash";
