<?php
require_once('../config/db.php');
require_once(__DIR__ . '/../includes/session.php');
require_once('../config/config.php'); // 🔧 ENV & BASE_URL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom     = trim($_POST['nom']);
    $prenom  = trim($_POST['prenom']);
    $email   = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $ville   = trim($_POST['ville']);
    $pass    = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (!$email || empty($nom) || empty($prenom) || empty($ville) || empty($pass) || empty($confirm)) {
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
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            http_response_code(409);
            echo "❌ Un compte avec cet email existe déjà.";
            exit;
        }

        $hashedPassword  = password_hash($pass, PASSWORD_DEFAULT);
        $token           = bin2hex(random_bytes(16));
        $emailConfirmed  = (ENV === 'prod') ? 0 : 1;

        $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, role, email_confirmed, confirmation_token, ville)
                               VALUES (?, ?, ?, ?, 'PARENT', ?, ?, ?)");
        $success = $stmt->execute([
            $nom, $prenom, $email, $hashedPassword,
            $emailConfirmed, $token, $ville
        ]);

        if ($success) {
            if (ENV === 'prod') {
                $confirmationLink = BASE_URL . "/backend/auth/confirm.php?token=" . urlencode($token);

                $subject = "Confirmation de votre inscription sur Tatienounou.fr";
                $message = "Bonjour " . htmlspecialchars($prenom) . " " . htmlspecialchars($nom) . ",\n\n";
                $message .= "Merci pour votre inscription sur Tatienounou.fr.\n";
                $message .= "Veuillez confirmer votre adresse email en cliquant sur ce lien :\n";
                $message .= $confirmationLink . "\n\n";
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
