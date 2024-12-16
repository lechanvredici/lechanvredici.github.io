<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $commentaire = $_POST['commentaire'];

    // Destinataire de l'email
    $to = "Lechanvredici@gmail.com";

    // Sujet de l'email
    $subject = "Formulaire de contact - $nom $prenom";

    // Corps du message
    $message = "Nom: $nom\n";
    $message .= "Prénom: $prenom\n";
    $message .= "Téléphone: $telephone\n";
    $message .= "Commentaire: $commentaire\n";

    // En-têtes de l'email
    $headers = "From: $nom <$nom@domain.com>\r\n";
    $headers .= "Reply-To: $nom <$nom@domain.com>\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Envoi de l'email
    if (mail($to, $subject, $message, $headers)) {
        echo "Votre message a été envoyé avec succès.";
    } else {
        echo "Il y a eu une erreur lors de l'envoi de votre message.";
    }
}
?>
