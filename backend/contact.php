<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom     = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $email   = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (!$nom || !$email || !$message) {
        http_response_code(400);
        echo "❌ Tous les champs sont obligatoires.";
        exit;
    }

    $to      = "contact@tatienounou.fr";
    $subject = "Message de contact via le site";
    $body    = "Nom : $nom\nEmail : $email\n\nMessage :\n$message";
    $headers = "From: contact@tatienounou.fr\r\n" .
               "Reply-To: $email\r\n" .
               "Content-Type: text/plain; charset=utf-8";

    if (mail($to, $subject, $body, $headers)) {
        http_response_code(200);
        echo "✅ Merci pour votre message. Nous vous répondrons rapidement.";
    } else {
        http_response_code(500);
        echo "❌ Une erreur est survenue. Merci de réessayer plus tard.";
    }
} else {
    http_response_code(405);
    echo "⛔ Méthode non autorisée.";
}
