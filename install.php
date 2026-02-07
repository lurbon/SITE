<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Entraide Plus Iroise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #2563eb, #10b981);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            max-width: 800px;
            width: 100%;
            padding: 3rem;
        }
        h1 {
            color: #2563eb;
            margin-bottom: 1rem;
            font-size: 2rem;
        }
        .step {
            display: none;
            animation: fadeIn 0.5s;
        }
        .step.active { display: block; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }
        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #3b82f6;
        }
        .check-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            margin: 0.5rem 0;
            background: #f9fafb;
            border-radius: 0.5rem;
        }
        .check-ok { background: #d1fae5; }
        .check-error { background: #fee2e2; }
        .icon {
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            font-size: 1.25rem;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            margin-top: 1.5rem;
        }
        .btn:hover {
            background: #1e40af;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #10b981;
        }
        .btn-secondary:hover {
            background: #059669;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }
        input, select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #2563eb;
        }
        code {
            background: #f3f4f6;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-family: monospace;
            color: #dc2626;
        }
        .progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }
        .progress::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e5e7eb;
            z-index: 0;
        }
        .progress-step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            font-weight: bold;
            color: #6b7280;
        }
        .progress-step.active {
            background: #2563eb;
            color: white;
        }
        .progress-step.completed {
            background: #10b981;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="progress">
            <div class="progress-step active" id="progress1">1</div>
            <div class="progress-step" id="progress2">2</div>
            <div class="progress-step" id="progress3">3</div>
            <div class="progress-step" id="progress4">4</div>
        </div>

        <?php
        session_start();
        
        // Étape 1 : Vérification
        if (!isset($_GET['step']) || $_GET['step'] == 1):
        ?>
        <div class="step active">
            <h1>🚀 Installation du site</h1>
            <p style="color: #6b7280; margin-bottom: 2rem;">Bienvenue ! Vérifions que votre serveur est prêt.</p>
            
            <?php
            $checks = [];
            $all_ok = true;
            
            // Vérifier PHP
            $php_version = phpversion();
            $checks['php'] = version_compare($php_version, '7.4.0', '>=');
            if (!$checks['php']) $all_ok = false;
            
            // Vérifier PDO
            $checks['pdo'] = extension_loaded('pdo') && extension_loaded('pdo_mysql');
            if (!$checks['pdo']) $all_ok = false;
            
            // Vérifier dossiers uploads
            $upload_dirs = ['uploads/news', 'uploads/gallery', 'uploads/press'];
            $checks['uploads'] = true;
            foreach ($upload_dirs as $dir) {
                if (!is_writable($dir)) {
                    $checks['uploads'] = false;
                    $all_ok = false;
                }
            }
            ?>
            
            <div class="check-item <?php echo $checks['php'] ? 'check-ok' : 'check-error'; ?>">
                <span class="icon"><?php echo $checks['php'] ? '✓' : '✗'; ?></span>
                <span>PHP <?php echo $php_version; ?> <?php echo $checks['php'] ? '(OK)' : '(Minimum 7.4 requis)'; ?></span>
            </div>
            
            <div class="check-item <?php echo $checks['pdo'] ? 'check-ok' : 'check-error'; ?>">
                <span class="icon"><?php echo $checks['pdo'] ? '✓' : '✗'; ?></span>
                <span>Extensions PDO MySQL <?php echo $checks['pdo'] ? '(Installées)' : '(Manquantes)'; ?></span>
            </div>
            
            <div class="check-item <?php echo $checks['uploads'] ? 'check-ok' : 'check-error'; ?>">
                <span class="icon"><?php echo $checks['uploads'] ? '✓' : '✗'; ?></span>
                <span>Dossiers uploads <?php echo $checks['uploads'] ? '(Accessibles en écriture)' : '(Permissions insuffisantes)'; ?></span>
            </div>
            
            <?php if ($all_ok): ?>
                <div class="alert alert-success">
                    ✓ Tous les prérequis sont satisfaits ! Vous pouvez continuer l'installation.
                </div>
                <a href="?step=2" class="btn">Continuer →</a>
            <?php else: ?>
                <div class="alert alert-error">
                    ✗ Certains prérequis ne sont pas satisfaits. Veuillez corriger les problèmes avant de continuer.
                </div>
            <?php endif; ?>
        </div>
        
        <?php
        // Étape 2 : Configuration BDD
        elseif ($_GET['step'] == 2):
        ?>
        <div class="step active">
            <h1>🗄️ Configuration de la base de données</h1>
            <p style="color: #6b7280; margin-bottom: 2rem;">Configurez votre connexion à la base de données MySQL.</p>
            
            <form method="POST" action="?step=3">
                <div class="form-group">
                    <label for="db_host">Hôte de la base de données</label>
                    <input type="text" id="db_host" name="db_host" value="localhost" required>
                </div>
                
                <div class="form-group">
                    <label for="db_name">Nom de la base de données</label>
                    <input type="text" id="db_name" name="db_name" value="entraide_plus_iroise" required>
                </div>
                
                <div class="form-group">
                    <label for="db_user">Utilisateur</label>
                    <input type="text" id="db_user" name="db_user" value="root" required>
                </div>
                
                <div class="form-group">
                    <label for="db_pass">Mot de passe</label>
                    <input type="password" id="db_pass" name="db_pass">
                </div>
                
                <div class="alert alert-info">
                    💡 La base de données sera créée automatiquement si elle n'existe pas.
                </div>
                
                <button type="submit" class="btn">Tester la connexion →</button>
            </form>
        </div>
        
        <?php
        // Étape 3 : Test connexion et création BDD
        elseif ($_GET['step'] == 3 && $_SERVER['REQUEST_METHOD'] === 'POST'):
            $_SESSION['db_host'] = $_POST['db_host'];
            $_SESSION['db_name'] = $_POST['db_name'];
            $_SESSION['db_user'] = $_POST['db_user'];
            $_SESSION['db_pass'] = $_POST['db_pass'];
        ?>
        <div class="step active">
            <h1>⚙️ Création de la base de données</h1>
            
            <?php
            try {
                // Connexion sans spécifier la BDD
                $pdo = new PDO(
                    "mysql:host=" . $_SESSION['db_host'],
                    $_SESSION['db_user'],
                    $_SESSION['db_pass']
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                echo '<div class="alert alert-success">✓ Connexion à MySQL réussie !</div>';
                
                // Créer la base de données
                $pdo->exec("CREATE DATABASE IF NOT EXISTS " . $_SESSION['db_name'] . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                echo '<div class="alert alert-success">✓ Base de données créée !</div>';
                
                // Se connecter à la nouvelle BDD
                $pdo->exec("USE " . $_SESSION['db_name']);
                
                // Exécuter le script SQL
                $sql = file_get_contents('database.sql');
                $statements = explode(';', $sql);
                
                foreach ($statements as $statement) {
                    $statement = trim($statement);
                    if (!empty($statement)) {
                        $pdo->exec($statement);
                    }
                }
                
                echo '<div class="alert alert-success">✓ Tables créées avec succès !</div>';
                echo '<div class="alert alert-info">✓ Données de test ajoutées !</div>';
                
                // Mettre à jour le fichier config.php
                $config_content = file_get_contents('includes/config.php');
                $config_content = preg_replace("/define\('DB_HOST', '.*?'\);/", "define('DB_HOST', '" . $_SESSION['db_host'] . "');", $config_content);
                $config_content = preg_replace("/define\('DB_NAME', '.*?'\);/", "define('DB_NAME', '" . $_SESSION['db_name'] . "');", $config_content);
                $config_content = preg_replace("/define\('DB_USER', '.*?'\);/", "define('DB_USER', '" . $_SESSION['db_user'] . "');", $config_content);
                $config_content = preg_replace("/define\('DB_PASS', '.*?'\);/", "define('DB_PASS', '" . $_SESSION['db_pass'] . "');", $config_content);
                file_put_contents('includes/config.php', $config_content);
                
                echo '<div class="alert alert-success">✓ Configuration sauvegardée !</div>';
                echo '<a href="?step=4" class="btn">Terminer l\'installation →</a>';
                
            } catch (PDOException $e) {
                echo '<div class="alert alert-error">✗ Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
                echo '<a href="?step=2" class="btn btn-secondary">← Retour</a>';
            }
            ?>
        </div>
        
        <?php
        // Étape 4 : Terminé
        elseif ($_GET['step'] == 4):
        ?>
        <div class="step active">
            <h1>🎉 Installation terminée !</h1>
            <p style="color: #6b7280; margin-bottom: 2rem;">Votre site est prêt à être utilisé !</p>
            
            <div class="alert alert-success">
                <strong>✓ Installation réussie !</strong><br>
                Le site Entraide Plus Iroise est maintenant opérationnel.
            </div>
            
            <div class="alert alert-info">
                <strong>📝 Identifiants administrateur par défaut :</strong><br>
                Nom d'utilisateur : <code>admin</code><br>
                Mot de passe : <code>admin123</code><br><br>
                ⚠️ <strong>Important :</strong> Changez ces identifiants dès votre première connexion !
            </div>
            
            <div style="margin-top: 2rem;">
                <h3 style="margin-bottom: 1rem;">Prochaines étapes :</h3>
                <ol style="line-height: 2; color: #6b7280;">
                    <li>Connectez-vous au panel d'administration</li>
                    <li>Changez le mot de passe administrateur</li>
                    <li>Ajoutez vos actualités et contenus</li>
                    <li>Personnalisez les couleurs du site</li>
                    <li>Ajoutez le logo de votre association</li>
                </ol>
            </div>
            
            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <a href="index.php" class="btn">Voir le site →</a>
                <a href="admin/login.php" class="btn btn-secondary">Panel admin →</a>
            </div>
            
            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #e5e7eb;">
                <p style="color: #6b7280; font-size: 0.875rem;">
                    ⚠️ <strong>Sécurité :</strong> Supprimez le fichier <code>install.php</code> après l'installation.
                </p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <script>
        // Mettre à jour la barre de progression
        const step = <?php echo $_GET['step'] ?? 1; ?>;
        for (let i = 1; i <= step; i++) {
            const el = document.getElementById('progress' + i);
            if (i < step) {
                el.classList.add('completed');
                el.classList.remove('active');
            } else {
                el.classList.add('active');
            }
        }
    </script>
</body>
</html>
