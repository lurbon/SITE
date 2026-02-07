<?php
require_once 'includes/config.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $user_message = $_POST['message'] ?? '';
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Le nom est requis";
    }
    
    if (empty($email)) {
        $errors[] = "L'email est requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide";
    }
    
    if (empty($user_message)) {
        $errors[] = "Le message est requis";
    }
    
    if (empty($errors)) {
        // Enregistrer dans la base de données
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $user_message]);
            
            // Envoyer l'email
            $to = ADMIN_EMAIL;
            $email_subject = "Nouveau message de contact - " . ($subject ?: 'Sans objet');
            $email_body = "Nouveau message de contact\n\n";
            $email_body .= "Nom: $name\n";
            $email_body .= "Email: $email\n";
            $email_body .= "Sujet: $subject\n\n";
            $email_body .= "Message:\n$user_message\n";
            
            $headers = "From: $email\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            
            if (mail($to, $email_subject, $email_body, $headers)) {
                $message = "Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.";
                $message_type = 'success';
                
                // Réinitialiser les champs
                $name = $email = $subject = $user_message = '';
            } else {
                $message = "Votre message a été enregistré mais l'email n'a pas pu être envoyé. Nous vous contacterons rapidement.";
                $message_type = 'success';
            }
        } catch (PDOException $e) {
            $message = "Une erreur s'est produite lors de l'envoi du message. Veuillez réessayer.";
            $message_type = 'error';
        }
    } else {
        $message = implode('<br>', $errors);
        $message_type = 'error';
    }
}

$page_title = "Contact";
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero" style="padding: 4rem 1rem;">
    <div class="hero-content">
        <h1>Contactez-nous</h1>
        <p>Nous sommes à votre écoute</p>
    </div>
</section>

<!-- Contenu -->
<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; max-width: 1000px; margin: 0 auto;">
            
            <!-- Informations de contact -->
            <div>
                <h2 style="color: var(--primary-color); margin-bottom: 2rem;">Nos coordonnées</h2>
                
                <div style="background: var(--background-light); padding: 2rem; border-radius: var(--radius-lg); margin-bottom: 2rem;">
                    <h3 style="color: var(--secondary-color); margin-bottom: 1rem;">Présidente</h3>
                    <p style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Christiane Le Guen</p>
                    <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                        <strong>📞 Téléphone :</strong><br>
                        <a href="tel:0662487642" style="font-size: 1.125rem;">06.62.48.76.42</a>
                    </p>
                    <p style="color: var(--text-secondary);">
                        <strong>✉️ Email :</strong><br>
                        <a href="mailto:contact@entraide-plus-iroise.fr">contact@entraide-plus-iroise.fr</a>
                    </p>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin-bottom: 2rem;">
                    <h3 style="color: var(--primary-color); margin-bottom: 1rem;">Disponibilité</h3>
                    <p style="color: var(--text-secondary); line-height: 1.8;">
                        L'association fonctionne grâce à ses bénévoles. Pour toute demande, 
                        contactez-nous par téléphone ou via le formulaire ci-contre.
                    </p>
                </div>
                
                <div style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); 
                            color: white; padding: 2rem; border-radius: var(--radius-lg);">
                    <h3 style="margin-bottom: 1rem;">Suivez-nous</h3>
                    <p style="margin-bottom: 1rem; opacity: 0.9;">Retrouvez nos actualités sur Facebook</p>
                    <a href="https://www.facebook.com/groups/1378419443105675/" target="_blank" 
                       class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Rejoignez notre groupe
                    </a>
                </div>
            </div>
            
            <!-- Formulaire de contact -->
            <div>
                <h2 style="color: var(--primary-color); margin-bottom: 2rem;">Envoyez-nous un message</h2>
                
                <?php if ($message): ?>
                    <div class="form-message <?php echo $message_type; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                
                <form id="contact-form" method="POST" action="" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                    <div class="form-group">
                        <label for="name" class="form-label">Nom complet <span style="color: var(--error);">*</span></label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($name ?? ''); ?>"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email <span style="color: var(--error);">*</span></label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-control"
                               value="<?php echo htmlspecialchars($email ?? ''); ?>"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject" class="form-label">Sujet</label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               class="form-control"
                               value="<?php echo htmlspecialchars($subject ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">Message <span style="color: var(--error);">*</span></label>
                        <textarea id="message" 
                                  name="message" 
                                  class="form-control" 
                                  rows="6" 
                                  required><?php echo htmlspecialchars($user_message ?? ''); ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.125rem;">
                        Envoyer le message
                    </button>
                    
                    <p style="margin-top: 1rem; font-size: 0.875rem; color: var(--text-secondary); text-align: center;">
                        <span style="color: var(--error);">*</span> Champs obligatoires
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
@media (max-width: 768px) {
    section > div > div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
