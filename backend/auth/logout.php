<?php
session_start();
session_unset();
session_destroy();
header('Location: ../../frontend/connexion-inscription.php');
exit;
