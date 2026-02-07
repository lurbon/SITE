# Site Web Entraide Plus Iroise

Site web moderne développé en PHP avec base de données MySQL pour l'association Entraide Plus Iroise.

## 🚀 Fonctionnalités

- **Site public moderne et responsive**
  - Page d'accueil dynamique
  - Présentation de l'association (histoire, missions, membres)
  - Système d'actualités
  - Galerie photos
  - Articles de presse
  - Vidéos
  - Formulaire de contact fonctionnel
  - Design moderne et personnalisable

- **Panel d'administration**
  - Gestion des actualités
  - Gestion des membres du bureau
  - Gestion de la galerie photos
  - Gestion des articles de presse
  - Gestion des vidéos
  - Visualisation des messages de contact
  - Statistiques

## 📋 Prérequis

- Serveur web (Apache/Nginx)
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Extension PHP : PDO, PDO_MySQL

## 🔧 Installation

### 1. Télécharger les fichiers

Copiez tous les fichiers du projet dans le dossier de votre serveur web (par exemple `/var/www/html/` ou `htdocs/`).

### 2. Créer la base de données

1. Connectez-vous à votre serveur MySQL
2. Exécutez le fichier SQL pour créer la base de données :

```bash
mysql -u root -p < database.sql
```

Ou via phpMyAdmin :
- Créez une nouvelle base de données nommée `entraide_plus_iroise`
- Importez le fichier `database.sql`

### 3. Configuration

Éditez le fichier `includes/config.php` et modifiez les paramètres de connexion à la base de données si nécessaire :

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'entraide_plus_iroise');
define('DB_USER', 'root');        // Votre utilisateur MySQL
define('DB_PASS', '');            // Votre mot de passe MySQL
define('ADMIN_EMAIL', 'contact@entraide-plus-iroise.fr'); // Email pour recevoir les messages
```

### 4. Permissions des dossiers

Assurez-vous que le dossier `uploads/` et ses sous-dossiers sont accessibles en écriture :

```bash
chmod -R 755 uploads/
```

### 5. Accéder au site

- **Site public** : http://votre-domaine.com/
- **Administration** : http://votre-domaine.com/admin/

**Identifiants admin par défaut :**
- Username : `admin`
- Password : `admin123`

⚠️ **Important** : Changez ces identifiants dès la première connexion !

## 🎨 Personnalisation des couleurs

Les couleurs du site sont facilement modifiables dans le fichier `assets/css/style.css`.

Toutes les couleurs sont définies en haut du fichier avec des variables CSS :

```css
:root {
    /* Couleurs principales */
    --primary-color: #2563eb;        /* Bleu principal */
    --primary-dark: #1e40af;         /* Bleu foncé */
    --primary-light: #3b82f6;        /* Bleu clair */
    
    /* Couleurs secondaires */
    --secondary-color: #10b981;      /* Vert */
    --secondary-dark: #059669;       /* Vert foncé */
    --secondary-light: #34d399;      /* Vert clair */
    
    /* ... */
}
```

Modifiez simplement ces valeurs pour changer les couleurs de tout le site instantanément !

## 📁 Structure du projet

```
entraide-plus-iroise/
├── admin/                      # Panel d'administration
│   ├── index.php              # Tableau de bord
│   ├── login.php              # Page de connexion
│   ├── check_auth.php         # Vérification authentification
│   ├── news.php               # Gestion des actualités
│   ├── members.php            # Gestion des membres
│   ├── gallery.php            # Gestion de la galerie
│   ├── press.php              # Gestion de la presse
│   ├── videos.php             # Gestion des vidéos
│   └── messages.php           # Gestion des messages
├── assets/
│   ├── css/
│   │   └── style.css          # Styles CSS (avec variables)
│   ├── js/
│   │   └── main.js            # JavaScript
│   └── images/                # Images du site
├── includes/
│   ├── config.php             # Configuration BDD
│   ├── header.php             # En-tête du site
│   └── footer.php             # Pied de page du site
├── pages/                      # Pages additionnelles
├── uploads/                    # Dossier des uploads
│   ├── news/                  # Images des actualités
│   ├── gallery/               # Photos de la galerie
│   └── press/                 # Fichiers presse
├── index.php                   # Page d'accueil
├── notre-histoire.php          # Page Notre histoire
├── nos-missions.php            # Page Nos missions
├── quelques-chiffres.php       # Page Quelques chiffres
├── les-membres.php             # Page Les membres
├── actualites.php              # Page Actualités
├── photos.php                  # Page Galerie photos
├── presse.php                  # Page Presse
├── videos.php                  # Page Vidéos
├── nous-rejoindre.php          # Page Nous rejoindre
├── contact.php                 # Page Contact
├── database.sql                # Script SQL
└── README.md                   # Ce fichier
```

## 🔐 Sécurité

1. **Changez les identifiants admin** dès la première connexion
2. **Modifiez le mot de passe** dans la base de données :
   ```sql
   UPDATE admins SET password = ? WHERE username = 'admin';
   ```
   (utilisez `password_hash()` en PHP pour générer le hash)

3. **Configurez HTTPS** sur votre serveur pour sécuriser les connexions

## 📧 Configuration de l'envoi d'emails

Le formulaire de contact utilise la fonction PHP `mail()`. Assurez-vous que votre serveur est configuré pour envoyer des emails.

Pour tester l'envoi d'emails, modifiez `ADMIN_EMAIL` dans `includes/config.php`.

## 🆘 Support

Pour toute question ou problème :
- Vérifiez que tous les prérequis sont installés
- Vérifiez les permissions des dossiers
- Consultez les logs d'erreur PHP
- Vérifiez la connexion à la base de données

## 📝 Notes importantes

- Les images doivent être optimisées avant upload (max 2MB recommandé)
- Les vidéos utilisent YouTube (ID de la vidéo)
- Le site est entièrement responsive (mobile, tablette, desktop)
- Tous les formulaires incluent une validation côté client et serveur

## 🎯 Pages à créer ou compléter

Les pages suivantes peuvent être ajoutées via le panel admin :
- Quelques chiffres (statistiques de l'association)
- Les membres du bureau (avec photos et descriptions)
- Galerie photos (albums photos)
- Articles de presse
- Vidéos

## 🔄 Mises à jour

Pour mettre à jour le site :
1. Sauvegardez votre base de données
2. Sauvegardez vos fichiers uploadés (`uploads/`)
3. Remplacez les fichiers du site
4. Vérifiez que tout fonctionne correctement

---

Développé avec ❤️ pour Entraide Plus Iroise
