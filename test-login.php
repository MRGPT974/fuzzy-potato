<?php
$mdp = 'parent123';
$hash = '$2y$10$ZSyWdN6S94NPOoCjN8Jlx.WPCoYRM4mXYGi/jZdXT/U7prhFCDlre'; // Celui dans ta BDD

if (password_verify($mdp, $hash)) {
    echo "✅ Le mot de passe est correct.";
} else {
    echo "❌ Le mot de passe est incorrect.";
}
