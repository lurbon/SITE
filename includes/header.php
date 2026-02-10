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
                    <li><a href="actualites.php">News</a></li>
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
                    <li><a href="https://entraide-plus-iroise.fr/login.php" class="membre-link">Membres</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>