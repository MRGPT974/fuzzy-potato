<?php
$password = 'pro123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash local de pro123 :<br><code>$hash</code>";
?>
