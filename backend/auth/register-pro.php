<?php
require_once('../config/db.php');
require_once(__DIR__ . '/../includes/session.php');
require_once('../config/config.php'); // 🔧 ENV & BASE_URL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom       = trim($_POST['nom']);
    $prenom    = trim($_POST['prenom']);
    $email     = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $type_pro  = trim($_POST['type_pro']);
    $ville     = trim($_POST['ville']);
    $pass      = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    if (!$email || empty($nom) || empty($prenom) || empty($type_pro) || empty($ville) || empty($pass) || empty($confirm)) {
        http_response_code(400);
        echo "❌ Tous les champs sont obligatoires.";
        exit;
    }

    if ($pass !== $confirm) {
        http_response_code(400);
        echo "❌ Les mots de passe ne correspondent pas.";
        exit;
    }

    if (strlen($pass) < 6) {
        http_response_code(400);
        echo "❌ Le mot de passe doit contenir au moins 6 caractères.";
        exit;
    }

    try {
        // Vérifie si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            http_response_code(409);
            echo "❌ Un compte avec cet email existe déjà.";
            exit;
        }

        // Préparation des données
        $nom        = mb_convert_encoding($nom, 'UTF-8', 'auto');
        $prenom     = mb_convert_encoding($prenom, 'UTF-8', 'auto');
        $type_pro   = mb_convert_encoding($type_pro, 'UTF-8', 'auto');
        $ville      = mb_convert_encoding($ville, 'UTF-8', 'auto');
        $password   = password_hash($pass, PASSWORD_DEFAULT);
        $token      = bin2hex(random_bytes(16));
        $confirmed  = (ENV === 'prod') ? 0 : 1;

        // Insertion en base
        $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, role, type_pro, ville, is_confirmed, confirmation_token)
                               VALUES (?, ?, ?, ?, 'PRO', ?, ?, ?, ?)");
        $success = $stmt->execute([
            $nom, $prenom, $email, $password,
            $type_pro, $ville, $confirmed, $token
        ]);

        if ($success) {
            if (ENV === 'prod') {
                $confirmationLink = BASE_URL . "/backend/auth/confirm.php?token=" . urlencode($token);

                $subject = "Confirmation de votre inscription sur Tatienounou.fr";
                $message = "Bonjour " . htmlspecialchars($prenom) . " " . htmlspecialchars($nom) . ",\n\n";
                $message .= "Merci pour votre inscription en tant que " . htmlspecialchars($type_pro) . " sur Tatienounou.fr.\n";
                $message .= "Veuillez confirmer votre adresse email en cliquant sur ce lien :\n";
                $message .= "$confirmationLink\n\n";
                $message .= "Sans cette validation, votre compte restera inactif.\n\n";
                $message .= "L’équipe Tatienounou";

                $headers = "From: inscription@tatienounou.fr\r\n" .
                           "Reply-To: contact@tatienounou.fr\r\n" .
                           "Content-Type: text/plain; charset=utf-8";

                mail($email, $subject, $message, $headers);
            }

            header('Location: ../../frontend/connexion-inscription.php');
            exit;
        } else {
            http_response_code(500);
            echo "❌ Une erreur est survenue lors de l’inscription.";
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo "❌ Erreur serveur : " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "⛔ Méthode non autorisée.";
}
