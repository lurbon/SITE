<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Entraide Plus Iroise - Association d'entraide et de solidarité">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Entraide Plus Iroise</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpg" href="assets/images/Logo-Entraide-Plus-Iroise.jpg">
    
    <!-- Appliquer le thème sauvegardé avant le rendu -->
    <script>
    (function() {
        var t = localStorage.getItem('site-theme');
        if (t && t !== 'default') {
            var themes = {
                'ardoise':   {pc:'#475569',pd:'#334155',pl:'#64748b',sc:'#0ea5e9',sd:'#0284c7',sl:'#38bdf8'},
                'foret':     {pc:'#166534',pd:'#14532d',pl:'#15803d',sc:'#ca8a04',sd:'#a16207',sl:'#eab308'},
                'bordeaux':  {pc:'#9f1239',pd:'#881337',pl:'#be123c',sc:'#d97706',sd:'#b45309',sl:'#f59e0b'},
                'marine':    {pc:'#1e3a5f',pd:'#172e4a',pl:'#2563eb',sc:'#b45309',sd:'#92400e',sl:'#d97706'},
                'aubergine': {pc:'#6b21a8',pd:'#581c87',pl:'#7c3aed',sc:'#0d9488',sd:'#0f766e',sl:'#14b8a6'}
            };
            var c = themes[t];
            if (c) {
                var s = document.documentElement.style;
                s.setProperty('--primary-color',c.pc);
                s.setProperty('--primary-dark',c.pd);
                s.setProperty('--primary-light',c.pl);
                s.setProperty('--secondary-color',c.sc);
                s.setProperty('--secondary-dark',c.sd);
                s.setProperty('--secondary-light',c.sl);
            }
        }
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
            
            <button class="mobile-menu-toggle" aria-label="Toggle menu">☰</button>

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
