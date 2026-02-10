<?php
session_start();
require_once 'includes/config.php';

// Générer une question mathématique simple pour le CAPTCHA
if (!isset($_SESSION['captcha_num1']) || !isset($_SESSION['captcha_num2'])) {
    $_SESSION['captcha_num1'] = rand(1, 10);
    $_SESSION['captcha_num2'] = rand(1, 10);
}

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $user_message = $_POST['message'] ?? '';
    $captcha_answer = $_POST['captcha'] ?? '';
    
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
    
    // Validation du CAPTCHA
    $expected_answer = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
    if (empty($captcha_answer)) {
        $errors[] = "Veuillez répondre à la question de sécurité";
    } elseif ((int)$captcha_answer !== $expected_answer) {
        $errors[] = "La réponse à la question de sécurité est incorrecte";
        // Régénérer une nouvelle question
        $_SESSION['captcha_num1'] = rand(1, 10);
        $_SESSION['captcha_num2'] = rand(1, 10);
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
                
                // Régénérer une nouvelle question CAPTCHA
                $_SESSION['captcha_num1'] = rand(1, 10);
                $_SESSION['captcha_num2'] = rand(1, 10);
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
        <!-- Coordonnées en grille -->
        <h2 style="color: var(--primary-color); margin-bottom: 2rem; text-align: center;">Nos coordonnées</h2>
        
        <!-- Présidente -->
        <div style="max-width: 600px; margin: 0 auto 3rem auto;">
            <div style="background: var(--background-light); padding: 2.5rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                <h3 style="color: var(--secondary-color); margin-bottom: 1rem; white-space: nowrap;">Présidente, Secteur LANDUNVEZ</h3>
                <p style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Christiane Le Guen</p>
                <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                    <strong>📞 Téléphone :</strong><br>
                    <a href="tel:0662487642" style="font-size: 1.125rem;">06.62.48.76.42</a>
                </p>
                <p style="color: var(--text-secondary);">
                    <strong>✉️ Email :</strong><br>
                    <a href="mailto:entraideplusiroise@gmail.com">entraideplusiroise@gmail.com</a>
                </p>
            </div>
        </div>
        
        <!-- Autres secteurs -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
            <div style="background: var(--background-light); padding: 2rem; border-radius: var(--radius-lg);">
                <h3 style="color: var(--secondary-color); margin-bottom: 1rem; white-space: nowrap;">Secteur PORTSALL</h3>
                <p style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Jules Claerbout</p>
                <p style="color: var(--text-secondary);">
                    <strong>📞 Téléphone :</strong><br>
                    <a href="tel:0687234512" style="font-size: 1.125rem;">06.95.68.98.11</a>
                </p>
            </div>
            
            <div style="background: var(--background-light); padding: 2rem; border-radius: var(--radius-lg);">
                <h3 style="color: var(--secondary-color); margin-bottom: 1rem; white-space: nowrap;">Secteur PLOUDALMÉZEAU</h3>
                <p style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Béatrice Ducamp</p>
                <p style="color: var(--text-secondary);">
                    <strong>📞 Téléphone :</strong><br>
                    <a href="tel:0695187436" style="font-size: 1.125rem;">06.51.82.40.72</a>
                </p>
            </div>
            
            <div style="background: var(--background-light); padding: 2rem; border-radius: var(--radius-lg);">
                <h3 style="color: var(--secondary-color); margin-bottom: 1rem; white-space: nowrap;">Secteur PORSPODER</h3>
                <p style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Pierre Lambert</p>
                <p style="color: var(--text-secondary);">
                    <strong>📞 Téléphone :</strong><br>
                    <a href="tel:0683456729" style="font-size: 1.125rem;">06.51.44.17.46</a>
                </p>
            </div>
        </div>
        
        

        
        <!-- Formulaire de contact -->
        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 2rem; text-align: center;">Envoyez-nous un message</h2>
            
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
                
                <!-- CAPTCHA -->
                <div class="form-group">
                    <label for="captcha" class="form-label">
                        Question de sécurité <span style="color: var(--error);">*</span>
                    </label>
                    <p style="background: var(--background-light); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 0.5rem; font-weight: 600;">
                        Combien font <?php echo $_SESSION['captcha_num1']; ?> + <?php echo $_SESSION['captcha_num2']; ?> ?
                    </p>
                    <input type="number" 
                           id="captcha" 
                           name="captcha" 
                           class="form-control" 
                           placeholder="Votre réponse"
                           required
                           style="max-width: 150px;">
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.125rem;">
                    Envoyer le message
                </button>
                
                <p style="margin-top: 1rem; font-size: 0.875rem; color: var(--text-secondary); text-align: center;">
                    <span style="color: var(--error);">*</span> Champs obligatoires
                </p>
            </form>
        </div>
		        <!-- Lien Facebook -->
        <div style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); 
                    color: white; padding: 3rem 2rem; border-radius: var(--radius-lg); margin-bottom: 3rem; text-align: center;">
            <h3 style="margin-bottom: 1rem; font-size: 1.5rem;">Suivez-nous</h3>
            <p style="margin-bottom: 1.5rem; opacity: 0.9; font-size: 1.125rem;">Retrouvez nos actualités sur Facebook</p>
            <a href="https://www.facebook.com/groups/1378419443105675/" target="_blank" 
               class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Rejoignez notre groupe
            </a>
        </div>
    </div>
</section>

<style>
@media (max-width: 768px) {
    /* Réduire les paddings sur mobile */
    .hero {
        padding: 2rem 1rem !important;
    }
    
    /* Bloc présidente */
    section .container > div[style*="max-width: 600px"] > div {
        padding: 1.5rem !important;
    }
    
    /* Cartes de secteurs */
    section .container > div[style*="grid-template-columns"] > div {
        padding: 1.5rem !important;
    }
    
    /* Formulaire */
    #contact-form {
        padding: 1.5rem !important;
    }
    
    /* Titres */
    h2 {
        font-size: 1.5rem !important;
    }
    
    h3 {
        font-size: 1.1rem !important;
        white-space: normal !important;
    }
    
    /* Noms */
    p[style*="font-size: 1.25rem"] {
        font-size: 1.1rem !important;
    }
    
    /* Grille responsive */
    div[style*="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))"] {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }
    
    /* Bloc Facebook */
    div[style*="linear-gradient"] {
        padding: 2rem 1.5rem !important;
    }
    
    div[style*="linear-gradient"] h3 {
        font-size: 1.3rem !important;
    }
    
    div[style*="linear-gradient"] p {
        font-size: 1rem !important;
    }
}

@media (max-width: 480px) {
    /* Encore plus petit sur très petit écran */
    .hero {
        padding: 1.5rem 0.5rem !important;
    }
    
    .hero h1 {
        font-size: 1.75rem !important;
    }
    
    section .container > div[style*="max-width: 600px"] > div,
    section .container > div[style*="grid-template-columns"] > div,
    #contact-form {
        padding: 1rem !important;
    }
    
    h2 {
        font-size: 1.3rem !important;
    }
    
    h3 {
        font-size: 1rem !important;
    }
    
    div[style*="linear-gradient"] {
        padding: 1.5rem 1rem !important;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
