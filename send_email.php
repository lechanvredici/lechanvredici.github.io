<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure PHPMailer
require 'send_email.php'; // Assurez-vous que le chemin est correct si vous avez téléchargé PHPMailer

// Récupérer les données du formulaire
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone = $_POST['phone'];
$comment = $_POST['comment'];

// Créer une nouvelle instance de PHPMailer
$mail = new PHPMailer(true);

try {
    // Paramètres du serveur SMTP
    $mail->isSMTP();                                           // Envoyer via SMTP
    $mail->Host       = 'smtp.gmail.com';                        // Serveur SMTP de Gmail
    $mail->SMTPAuth   = true;                                    // Activer l'authentification SMTP
    $mail->Username   = 'votre_email@gmail.com';                 // Votre adresse email Gmail
    $mail->Password   = 'votre_mot_de_passe';                    // Votre mot de passe Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Chiffrement TLS
    $mail->Port       = 587;                                     // Port SMTP (587 pour TLS)

    // Destinataire
    $mail->setFrom('votre_email@gmail.com', 'Nom de votre site');
    $mail->addAddress('Lechanvredici@gmail.com');                 // L'adresse de destination

    // Contenu de l'email
    $mail->isHTML(true);                                         // Configurer l'email au format HTML
    $mail->Subject = 'Nouveau message de contact';
    $mail->Body    = "<h3>Message reçu de {$firstname} {$lastname}</h3>
                      <p><strong>Téléphone:</strong> {$phone}</p>
                      <p><strong>Commentaire:</strong><br>{$comment}</p>";

    // Envoi de l'email
    $mail->send();
    echo 'Le message a été envoyé avec succès.';
} catch (Exception $e) {
    echo "L'email n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
}
?>
