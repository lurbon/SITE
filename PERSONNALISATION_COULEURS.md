# 🎨 Guide de personnalisation des couleurs

Ce guide vous explique comment modifier facilement les couleurs du site Entraide Plus Iroise.

## 📍 Où modifier les couleurs ?

Ouvrez le fichier : `assets/css/style.css`

Les couleurs sont définies au tout début du fichier dans la section `:root { ... }`

## 🎯 Variables de couleurs disponibles

### Couleurs principales (thème général)

```css
--primary-color: #2563eb;        /* Couleur principale (boutons, liens, titres) */
--primary-dark: #1e40af;         /* Version foncée de la couleur principale */
--primary-light: #3b82f6;        /* Version claire de la couleur principale */
```

**Utilisée pour :** Boutons principaux, liens, headers du menu, titres de sections

### Couleurs secondaires (accents)

```css
--secondary-color: #10b981;      /* Couleur secondaire (accents, boutons alternatifs) */
--secondary-dark: #059669;       /* Version foncée de la couleur secondaire */
--secondary-light: #34d399;      /* Version claire de la couleur secondaire */
```

**Utilisée pour :** Boutons secondaires, icônes, éléments d'accentuation

### Couleurs de fond et texte

```css
--background: #ffffff;           /* Fond principal du site */
--background-light: #f9fafb;     /* Fond clair (sections alternées) */
--background-dark: #f3f4f6;      /* Fond gris clair */
--text-primary: #111827;         /* Texte principal (noir) */
--text-secondary: #6b7280;       /* Texte secondaire (gris) */
--border-color: #e5e7eb;         /* Couleur des bordures */
```

### Couleurs de statut

```css
--success: #10b981;              /* Messages de succès */
--error: #ef4444;                /* Messages d'erreur */
--warning: #f59e0b;              /* Avertissements */
--info: #3b82f6;                 /* Informations */
```

## 💡 Exemples de personnalisation

### Exemple 1 : Thème bleu et orange

```css
:root {
    --primary-color: #1e40af;
    --primary-dark: #1e3a8a;
    --primary-light: #3b82f6;
    
    --secondary-color: #f97316;
    --secondary-dark: #ea580c;
    --secondary-light: #fb923c;
}
```

### Exemple 2 : Thème vert et jaune

```css
:root {
    --primary-color: #059669;
    --primary-dark: #047857;
    --primary-light: #10b981;
    
    --secondary-color: #eab308;
    --secondary-dark: #ca8a04;
    --secondary-light: #facc15;
}
```

### Exemple 3 : Thème violet et rose

```css
:root {
    --primary-color: #7c3aed;
    --primary-dark: #6d28d9;
    --primary-light: #8b5cf6;
    
    --secondary-color: #ec4899;
    --secondary-dark: #db2777;
    --secondary-light: #f472b6;
}
```

### Exemple 4 : Thème rouge et gris

```css
:root {
    --primary-color: #dc2626;
    --primary-dark: #b91c1c;
    --primary-light: #ef4444;
    
    --secondary-color: #64748b;
    --secondary-dark: #475569;
    --secondary-light: #94a3b8;
}
```

## 🛠️ Comment choisir de bonnes couleurs ?

### 1. Couleur principale
Choisissez une couleur qui représente votre association :
- **Bleu** : Confiance, professionnalisme, sérénité
- **Vert** : Nature, santé, croissance
- **Orange** : Énergie, convivialité, chaleur
- **Violet** : Créativité, sagesse, dignité
- **Rouge** : Passion, urgence, importance

### 2. Couleur secondaire
Choisissez une couleur complémentaire qui s'accorde bien :
- Utilisez un cercle chromatique
- Choisissez une couleur adjacente ou complémentaire
- Assurez-vous qu'elle contraste bien avec la principale

### 3. Testez le contraste
- Le texte doit être lisible sur tous les fonds
- Utilisez des outils comme [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)

### 4. Restez cohérent
- N'utilisez pas plus de 2-3 couleurs principales
- Gardez des variations (dark/light) cohérentes

## 🎨 Outils recommandés

### Générateurs de palettes
- [Coolors.co](https://coolors.co/) - Générateur de palettes
- [Adobe Color](https://color.adobe.com/) - Roue chromatique
- [Material Design Colors](https://materialui.co/colors) - Palettes prédéfinies

### Vérificateurs de contraste
- [WebAIM](https://webaim.org/resources/contrastchecker/)
- [Contrast Ratio](https://contrast-ratio.com/)

### Extracteurs de couleurs
- [Paletton](https://paletton.com/) - Créer des schémas de couleurs
- [Color Hunt](https://colorhunt.co/) - Palettes tendances

## 📝 Astuces supplémentaires

### Créer des variations de couleurs

Pour créer une version plus foncée d'une couleur :
1. Allez sur [Coolors.co](https://coolors.co/)
2. Entrez votre code couleur
3. Utilisez les curseurs pour l'assombrir/éclaircir

### Mode sombre (optionnel)

Pour ajouter un mode sombre, ajoutez ceci après les variables existantes :

```css
@media (prefers-color-scheme: dark) {
    :root {
        --background: #1f2937;
        --background-light: #111827;
        --background-dark: #374151;
        --text-primary: #f9fafb;
        --text-secondary: #d1d5db;
        --border-color: #4b5563;
    }
}
```

## 🔄 Appliquer les changements

1. Ouvrez `assets/css/style.css`
2. Modifiez les valeurs dans la section `:root { ... }`
3. Sauvegardez le fichier
4. Rafraîchissez votre navigateur (Ctrl+F5 ou Cmd+Shift+R)
5. Les changements sont immédiatement visibles !

## ⚠️ Attention

- Gardez toujours une copie de backup avant de modifier
- Testez sur différents navigateurs
- Vérifiez sur mobile et tablette
- Assurez-vous que le contraste reste bon pour l'accessibilité

---

Besoin d'aide ? N'hésitez pas à expérimenter - vous pouvez toujours revenir aux couleurs d'origine !
