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
        $stmt = $pdo->prepare("SELECT id, nom, prenom, is_confirmed FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            http_response_code(404);
            echo "❌ Aucun compte associé à cet email.";
            exit;
        }

        if ($user['is_confirmed']) {
            http_response_code(200);
            echo "✅ Ce compte est déjà activé. Vous pouvez vous connecter.";
            exit;
        }

        // Générer un nouveau token
        $token = bin2hex(random_bytes(16));
        $stmt = $pdo->prepare("UPDATE users SET confirmation_token = ? WHERE id = ?");
        $stmt->execute([$token, $user['id']]);

        $confirmationLink = BASE_URL . "/backend/auth/confirm.php?token=" . urlencode($token);

        $subject = "Nouveau lien de confirmation - Tatienounou.fr";
        $message = "Bonjour " . htmlspecialchars($user['prenom']) . " " . htmlspecialchars($user['nom']) . ",\n\n";
        $message .= "Voici un nouveau lien pour confirmer votre adresse email :\n";
        $message .= "$confirmationLink\n\n";
        $message .= "L’équipe Tatienounou";

        $headers = "From: inscription@tatienounou.fr\r\n" .
                   "Reply-To: contact@tatienounou.fr\r\n" .
                   "Content-Type: text/plain; charset=utf-8";

        mail($email, $subject, $message, $headers);

        http_response_code(200);
        echo "📨 Un nouvel e-mail de confirmation a été envoyé.";
    } catch (PDOException $e) {
        http_response_code(500);
        echo "❌ Erreur serveur : " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "⛔ Méthode non autorisée.";
}
