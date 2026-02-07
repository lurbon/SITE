<?php
// Configuration de la base de données
define('DB_HOST', 'kerbedq849.mysql.db');
define('DB_NAME', 'kerbedq849');
define('DB_USER', 'kerbedq849');
define('DB_PASS', 'IagoNougat29');

// Configuration du site
define('SITE_NAME', 'Entraide Plus Iroise');
define('SITE_URL', 'http://testing.kerbediez.fr');
define('ADMIN_EMAIL', 'contact@entraide-plus-iroise.fr');

// Connexion à la base de données
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Démarrer la session
session_start();
?>
