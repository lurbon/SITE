<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Entraide Plus Iroise - Association d'entraide et de solidarité">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Entraide Plus Iroise</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpg" href="assets/images/Logo-Entraide-Plus-Iroise.jpg">
    
    <!-- Appliquer le thème sauvegardé avant le rendu -->
    <script>
    (function() {
        var t = localStorage.getItem('site-theme');
        if (t && t !== 'default') document.documentElement.setAttribute('data-theme', t);
    })();
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="header-container">
            <a href="index.php" class="logo">
                <img src="assets/images/Logo-Entraide-Plus-Iroise.jpg" alt="Logo Entraide Plus Iroise">
                <span>Entraide Plus Iroise</span>
            </a>
            
            <div style="display: flex; align-items: center; gap: 8px;">
                <div class="theme-picker">
                    <button class="theme-picker-btn" aria-label="Changer le thème de couleurs" title="Thème de couleurs">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="13.5" cy="6.5" r="2.5"/>
                            <circle cx="17.5" cy="10.5" r="2.5"/>
                            <circle cx="8.5" cy="7.5" r="2.5"/>
                            <circle cx="6.5" cy="12.5" r="2.5"/>
                            <path d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10c.55 0 1-.45 1-1v-.5c0-.25.1-.48.27-.65.17-.17.4-.27.65-.27H15c3.31 0 6-2.69 6-6 0-5.17-4.03-9.58-9-9.58z"/>
                        </svg>
                    </button>
                    <div class="theme-picker-dropdown">
                        <div class="theme-picker-dropdown-title">Thème</div>
                        <button class="theme-option active" data-theme="default">
                            <span class="theme-swatch">
                                <span style="background: #2563eb;"></span>
                                <span style="background: #10b981;"></span>
                            </span>
                            Océan
                        </button>
                        <button class="theme-option" data-theme="ardoise">
                            <span class="theme-swatch">
                                <span style="background: #475569;"></span>
                                <span style="background: #0ea5e9;"></span>
                            </span>
                            Ardoise
                        </button>
                        <button class="theme-option" data-theme="foret">
                            <span class="theme-swatch">
                                <span style="background: #166534;"></span>
                                <span style="background: #ca8a04;"></span>
                            </span>
                            Forêt
                        </button>
                        <button class="theme-option" data-theme="bordeaux">
                            <span class="theme-swatch">
                                <span style="background: #9f1239;"></span>
                                <span style="background: #d97706;"></span>
                            </span>
                            Bordeaux
                        </button>
                        <button class="theme-option" data-theme="marine">
                            <span class="theme-swatch">
                                <span style="background: #1e3a5f;"></span>
                                <span style="background: #b45309;"></span>
                            </span>
                            Marine
                        </button>
                        <button class="theme-option" data-theme="aubergine">
                            <span class="theme-swatch">
                                <span style="background: #6b21a8;"></span>
                                <span style="background: #0d9488;"></span>
                            </span>
                            Aubergine
                        </button>
                    </div>
                </div>
                <button class="mobile-menu-toggle" aria-label="Toggle menu">☰</button>
            </div>

            <nav>
                <ul class="nav-menu">
                    <li class="dropdown">
                        <a href="index.php">L'association</a>
                        <ul class="dropdown-menu">
                            <li><a href="notre-histoire.php">Notre histoire</a></li>
                            <li><a href="nos-missions.php">Nos missions</a></li>
                            <li><a href="quelques-chiffres.php">Quelques chiffres</a></li>
                            <li><a href="les-membres.php">Les membres</a></li>
                        </ul>
                    </li>
                    <li><a href="actualites.php">Les news</a></li>
                    <li class="dropdown">
                        <a href="#">Médias</a>
                        <ul class="dropdown-menu">
                            <li><a href="photos.php">Photos</a></li>
                            <li><a href="presse.php">Presse</a></li>
                            <li><a href="videos.php">Vidéos</a></li>
                        </ul>
                    </li>
                    <li><a href="nous-rejoindre.php">Nous rejoindre</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="https://entraide-plus-iroise.fr/login.php" class="membre-link">Accès membre</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
