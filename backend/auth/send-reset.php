<?php
require_once('../config/db.php');
require_once('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$email) {
        http_response_code(400);
        echo "❌ Adresse email invalide.";
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, nom, prenom FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            http_response_code(404);
            echo "❌ Aucun utilisateur avec cet e-mail.";
            exit;
        }

        $token   = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?");
        $stmt->execute([$token, $expires, $user['id']]);

        $link = BASE_URL . "/frontend/reset-password.php?token=" . urlencode($token);

        $subject = "Réinitialisation de votre mot de passe";
        $message = "Bonjour " . htmlspecialchars($user['prenom']) . " " . htmlspecialchars($user['nom']) . ",\n\n";
        $message .= "Vous avez demandé à réinitialiser votre mot de passe.\n";
        $message .= "Cliquez sur le lien suivant pour choisir un nouveau mot de passe :\n";
        $message .= "$link\n\n";
        $message .= "⚠️ Ce lien est valable pendant 1 heure.";

        $headers = "From: contact@tatienounou.fr\r\n" .
                   "Content-Type: text/plain; charset=utf-8";

        mail($email, $subject, $message, $headers);

        http_response_code(200);
        echo "📨 Un lien de réinitialisation a été envoyé par email.";
    } catch (PDOException $e) {
        http_response_code(500);
        echo "❌ Erreur serveur : " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "⛔ Méthode non autorisée.";
}
