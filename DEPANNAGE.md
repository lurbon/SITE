# 🆘 Guide de résolution des erreurs

## Erreur 500 - Internal Server Error

Cette erreur est généralement causée par le fichier `.htaccess`. Voici comment la résoudre :

### Solution 1 : Renommer le .htaccess temporairement

1. Connectez-vous à votre serveur (FTP ou cPanel)
2. Renommez `.htaccess` en `.htaccess.bak`
3. Testez votre site - il devrait fonctionner
4. Si ça fonctionne, le problème vient bien du .htaccess

### Solution 2 : Utiliser le .htaccess minimaliste

1. Supprimez le fichier `.htaccess`
2. Renommez `.htaccess.minimal` en `.htaccess`
3. Testez votre site

### Solution 3 : Pas de .htaccess du tout

Si les solutions ci-dessus ne fonctionnent pas :
1. Supprimez complètement le fichier `.htaccess`
2. Le site fonctionnera sans, mais sans certaines protections

Le .htaccess n'est PAS obligatoire pour que le site fonctionne !

---

## Autres erreurs courantes

### Page blanche (White Screen)

**Causes possibles :**
1. Erreur PHP
2. Problème de connexion à la base de données
3. Fichier config.php mal configuré

**Solutions :**
1. Activez l'affichage des erreurs PHP temporairement :
   - Ajoutez en haut de `index.php` :
   ```php
   <?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ?>
   ```

2. Vérifiez `includes/config.php` :
   - Les identifiants de base de données sont-ils corrects ?
   - Le nom de la base existe-t-il ?

3. Vérifiez les logs d'erreur de votre hébergeur

### Erreur de connexion à la base de données

**Message type :** "Erreur de connexion à la base de données"

**Solutions :**
1. Vérifiez dans `includes/config.php` :
   ```php
   define('DB_HOST', 'localhost');  // Parfois 'localhost', parfois 'mysql' ou une IP
   define('DB_NAME', 'nom_base');   // Le nom de votre base
   define('DB_USER', 'utilisateur'); // Votre utilisateur MySQL
   define('DB_PASS', 'motdepasse'); // Votre mot de passe MySQL
   ```

2. Testez la connexion avec un script simple :
   ```php
   <?php
   $conn = new mysqli('localhost', 'user', 'pass', 'dbname');
   if ($conn->connect_error) {
       die("Erreur: " . $conn->connect_error);
   }
   echo "Connexion réussie !";
   ?>
   ```

### Les images ne s'affichent pas

**Causes :**
1. Chemin incorrect
2. Permissions insuffisantes

**Solutions :**
1. Vérifiez les permissions du dossier `uploads/` :
   ```bash
   chmod 755 uploads/
   chmod 755 uploads/news/
   chmod 755 uploads/gallery/
   chmod 755 uploads/press/
   ```

2. Vérifiez que le chemin est correct dans le code

### Le formulaire de contact ne fonctionne pas

**Causes :**
1. Fonction `mail()` désactivée
2. Serveur mal configuré

**Solutions :**
1. Testez la fonction mail() :
   ```php
   <?php
   if (mail('test@exemple.com', 'Test', 'Message de test')) {
       echo "Mail envoyé !";
   } else {
       echo "Erreur d'envoi";
   }
   ?>
   ```

2. Contactez votre hébergeur pour activer la fonction mail()

3. Alternative : utilisez un service SMTP externe (Gmail, SendGrid, etc.)

### CSS/JavaScript ne se chargent pas

**Causes :**
1. Chemins incorrects
2. Fichiers manquants

**Solutions :**
1. Vérifiez que les dossiers existent :
   - `assets/css/style.css`
   - `assets/js/main.js`

2. Vérifiez dans le code source HTML (clic droit > Code source) que les chemins sont corrects

3. Videz le cache de votre navigateur (Ctrl+F5)

### L'installation ne fonctionne pas

**Solutions :**
1. Vérifiez que vous avez bien accès à `install.php`
2. Assurez-vous que PHP et MySQL sont installés
3. Vérifiez les permissions en écriture sur les dossiers

### Erreur lors de l'upload d'images

**Causes :**
1. Taille de fichier trop grande
2. Permissions insuffisantes
3. Limite PHP dépassée

**Solutions :**
1. Vérifiez les permissions des dossiers uploads/
2. Augmentez les limites dans `php.ini` ou `.htaccess` :
   ```
   php_value upload_max_filesize 10M
   php_value post_max_size 10M
   ```
3. Contactez votre hébergeur si nécessaire

---

## Vérifications de base

### Liste de contrôle rapide

- [ ] PHP 7.4+ installé ?
- [ ] MySQL/MariaDB installé ?
- [ ] Base de données créée ?
- [ ] Fichier `includes/config.php` configuré correctement ?
- [ ] Dossiers `uploads/` créés avec bonnes permissions ?
- [ ] .htaccess compatible avec votre serveur ?

### Commandes utiles (SSH)

Vérifier la version PHP :
```bash
php -v
```

Vérifier les extensions PHP :
```bash
php -m
```

Créer les dossiers uploads :
```bash
mkdir -p uploads/{news,gallery,press,members}
chmod -R 755 uploads/
```

---

## Configuration selon les hébergeurs

### OVH
- DB_HOST : Généralement votre domaine.mysql.db
- Les emails peuvent nécessiter une configuration SMTP

### O2Switch
- DB_HOST : localhost
- Mail() fonctionne généralement bien

### Ionos (1&1)
- DB_HOST : Vérifier dans le panneau de contrôle
- Peut nécessiter .htaccess minimal

### Hostinger
- DB_HOST : localhost
- Supporte bien les .htaccess complets

---

## Besoin d'aide supplémentaire ?

1. **Consultez les logs** :
   - Logs d'erreur PHP
   - Logs d'erreur Apache/Nginx
   - Logs de votre hébergeur

2. **Testez étape par étape** :
   - Créez un fichier `test.php` avec `<?php phpinfo(); ?>`
   - Vérifiez que PHP fonctionne
   - Testez la connexion MySQL

3. **Contactez votre hébergeur** :
   - Demandez si le .htaccess est supporté
   - Vérifiez que la fonction mail() est active
   - Demandez les bonnes valeurs pour DB_HOST

---

## Derniers recours

Si rien ne fonctionne :

1. **Réinstallez depuis zéro** :
   - Supprimez tout
   - Re-uploadez les fichiers
   - Recréez la base de données

2. **Testez sur un autre hébergeur** :
   - Certains hébergeurs gratuits ont des limitations
   - Testez en local avec XAMPP/MAMP d'abord

3. **Version simplifiée** :
   - Supprimez le .htaccess
   - Commentez les sections problématiques

---

*N'oubliez pas : 90% des problèmes viennent de la configuration de la base de données ou du .htaccess !*
