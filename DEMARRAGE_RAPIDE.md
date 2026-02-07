# 🚀 Guide de démarrage rapide - Entraide Plus Iroise

## ✨ Félicitations !

Vous disposez maintenant d'un site web moderne et professionnel pour votre association !

## 📦 Ce qui est inclus

### Site public
- ✅ Page d'accueil dynamique
- ✅ Notre histoire
- ✅ Nos missions
- ✅ Actualités (blog)
- ✅ Galerie photos
- ✅ Articles de presse
- ✅ Vidéos
- ✅ Nous rejoindre
- ✅ Contact avec formulaire fonctionnel
- ✅ Design responsive (mobile, tablette, ordinateur)

### Panel d'administration
- ✅ Gestion des actualités
- ✅ Gestion des membres du bureau
- ✅ Gestion de la galerie
- ✅ Gestion des articles de presse
- ✅ Gestion des vidéos
- ✅ Visualisation des messages

## 🎯 Installation en 3 étapes

### Étape 1 : Uploader les fichiers
Uploadez tous les fichiers sur votre serveur web (via FTP, cPanel, etc.)

### Étape 2 : Lancer l'installation
Ouvrez votre navigateur et allez sur : `http://votre-domaine.com/install.php`

L'assistant d'installation vous guidera automatiquement :
1. Vérification des prérequis
2. Configuration de la base de données
3. Création des tables
4. Finalisation

### Étape 3 : Connexion admin
Allez sur `http://votre-domaine.com/admin/`

**Identifiants par défaut :**
- Username: `admin`
- Password: `admin123`

⚠️ **IMPORTANT : Changez ces identifiants immédiatement !**

## 🎨 Personnalisation

### Changer les couleurs
Ouvrez `assets/css/style.css` et modifiez les variables au début du fichier :

```css
:root {
    --primary-color: #2563eb;      /* Votre couleur principale */
    --secondary-color: #10b981;    /* Votre couleur secondaire */
}
```

Voir le fichier `PERSONNALISATION_COULEURS.md` pour plus de détails et des exemples.

### Ajouter votre logo
1. Placez votre logo dans `assets/images/logo.png`
2. Format recommandé : PNG transparent, 200x60px environ

### Modifier le contenu
Connectez-vous au panel admin pour :
- Ajouter des actualités
- Gérer les membres du bureau
- Uploader des photos
- Ajouter des vidéos

## 📧 Configuration des emails

Le formulaire de contact envoie des emails à l'adresse définie dans `includes/config.php` :

```php
define('ADMIN_EMAIL', 'votre-email@exemple.com');
```

Assurez-vous que votre serveur peut envoyer des emails (fonction `mail()` de PHP).

## 🔒 Sécurité

### Après l'installation
1. ✅ Supprimez le fichier `install.php`
2. ✅ Changez le mot de passe admin
3. ✅ Activez HTTPS si possible
4. ✅ Sauvegardez régulièrement votre base de données

### Permissions des dossiers
```bash
chmod 755 uploads/
chmod 755 uploads/news/
chmod 755 uploads/gallery/
chmod 755 uploads/press/
```

## 📱 Fonctionnalités modernes

- ✨ Design responsive (s'adapte à tous les écrans)
- ⚡ Navigation fluide
- 🎨 Animations élégantes
- 📸 Galerie photos avec lightbox
- 🔍 Optimisé pour le référencement (SEO)
- ♿ Accessible
- 🚀 Rapide et performant

## 🆘 Besoin d'aide ?

### Problèmes courants

**La page est blanche**
- Vérifiez les logs d'erreur PHP
- Assurez-vous que la connexion BDD est correcte

**Les images ne s'affichent pas**
- Vérifiez les permissions du dossier uploads/
- Vérifiez les chemins des images

**Les emails ne partent pas**
- Vérifiez que la fonction mail() fonctionne sur votre serveur
- Contactez votre hébergeur

**Erreur de base de données**
- Vérifiez les identifiants dans includes/config.php
- Assurez-vous que la base de données existe

## 📚 Documentation complète

- `README.md` - Documentation complète
- `PERSONNALISATION_COULEURS.md` - Guide des couleurs
- `database.sql` - Structure de la base de données

## 🎯 Prochaines étapes

1. [ ] Installer le site sur votre serveur
2. [ ] Changer les identifiants admin
3. [ ] Personnaliser les couleurs
4. [ ] Ajouter votre logo
5. [ ] Remplir les actualités
6. [ ] Ajouter les membres du bureau
7. [ ] Uploader des photos
8. [ ] Tester le formulaire de contact
9. [ ] Supprimer install.php
10. [ ] Faire une sauvegarde

## 🌟 Astuces

- Ajoutez régulièrement des actualités pour tenir vos visiteurs informés
- Utilisez des photos de bonne qualité (mais optimisées pour le web)
- Testez votre site sur mobile
- Activez HTTPS pour plus de sécurité
- Faites des sauvegardes régulières

## 💡 Idées d'amélioration future

- Ajouter un système de don en ligne
- Créer une newsletter
- Ajouter un calendrier des événements
- Intégrer Google Analytics
- Ajouter un chat en direct

---

## 📞 Support

Pour toute question technique, consultez :
- La documentation complète dans README.md
- Le guide de personnalisation des couleurs
- Les commentaires dans le code

**Bon courage avec votre nouveau site ! 🎉**

---

Développé avec ❤️ pour Entraide Plus Iroise
Version 1.0 - Février 2025
