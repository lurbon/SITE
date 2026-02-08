<?php
require_once '../includes/config.php';
require_once 'check_auth.php';

$message = '';
$message_type = '';

// Supprimer une photo
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $photo = $stmt->fetch();

    if ($photo && $photo['image']) {
        @unlink('../uploads/gallery/' . $photo['image']);
    }

    $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Photo supprimee avec succes";
    $message_type = 'success';
}

// Supprimer une categorie entiere
if (isset($_GET['delete_category'])) {
    $cat = $_GET['delete_category'];
    $stmt = $pdo->prepare("SELECT image FROM gallery WHERE category = ?");
    $stmt->execute([$cat]);
    $cat_photos = $stmt->fetchAll();

    foreach ($cat_photos as $p) {
        if ($p['image']) {
            @unlink('../uploads/gallery/' . $p['image']);
        }
    }

    $stmt = $pdo->prepare("DELETE FROM gallery WHERE category = ?");
    $stmt->execute([$cat]);
    $message = "Categorie et toutes ses photos supprimees avec succes";
    $message_type = 'success';
}

// Ajouter des photos (supporte upload multiple)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $uploaded = 0;
    $errors = 0;

    if (!file_exists('../uploads/gallery')) {
        mkdir('../uploads/gallery', 0755, true);
    }

    $files = $_FILES['images'];
    $file_count = count($files['name']);

    for ($i = 0; $i < $file_count; $i++) {
        if ($files['error'][$i] !== 0) {
            $errors++;
            continue;
        }

        $filename = $files['name'][$i];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $errors++;
            continue;
        }

        $new_filename = uniqid() . '.' . $ext;
        $title = pathinfo($filename, PATHINFO_FILENAME);

        if (move_uploaded_file($files['tmp_name'][$i], '../uploads/gallery/' . $new_filename)) {
            $stmt = $pdo->prepare("INSERT INTO gallery (title, description, image, category) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $description, $new_filename, $category]);
            $uploaded++;
        } else {
            $errors++;
        }
    }

    if ($uploaded > 0) {
        $message = $uploaded . " photo(s) ajoutee(s) avec succes";
        if ($errors > 0) {
            $message .= " ($errors fichier(s) en erreur)";
        }
        $message_type = 'success';
    } else {
        $message = "Aucune photo n'a pu etre ajoutee";
        $message_type = 'error';
    }
}

// Recuperer les categories existantes pour l'autocompletion
$existing_categories = $pdo->query("SELECT DISTINCT category FROM gallery WHERE category IS NOT NULL AND category != '' ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);

// Recuperer les photos groupees par categorie
$photos = $pdo->query("SELECT * FROM gallery ORDER BY category, created_at DESC")->fetchAll();
$categories = [];
foreach ($photos as $photo) {
    $cat = $photo['category'] ?: 'Sans categorie';
    if (!isset($categories[$cat])) {
        $categories[$cat] = [];
    }
    $categories[$cat][] = $photo;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Galerie - Administration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { display: flex; min-height: 100vh; }
        .admin-sidebar { width: 250px; background: var(--text-primary); color: white; padding: 2rem 0; }
        .admin-sidebar h2 { color: white; padding: 0 1.5rem; margin-bottom: 2rem; }
        .admin-menu a {
            display: block; padding: 1rem 1.5rem; color: rgba(255,255,255,0.8);
            text-decoration: none; transition: all 0.3s; border-left: 3px solid transparent;
        }
        .admin-menu a:hover, .admin-menu a.active {
            background: rgba(255,255,255,0.1); color: white; border-left-color: var(--primary-color);
        }
        .admin-content { flex: 1; padding: 2rem; background: var(--background-light); }
        .admin-header {
            background: white; padding: 1.5rem 2rem; margin: -2rem -2rem 2rem;
            box-shadow: var(--shadow-sm); display: flex; justify-content: space-between; align-items: center;
        }

        /* Zone de drop */
        .upload-zone {
            border: 2px dashed var(--border-color);
            border-radius: var(--radius-lg);
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: var(--background-light);
            position: relative;
        }
        .upload-zone:hover, .upload-zone.dragover {
            border-color: var(--primary-color);
            background: rgba(37, 99, 235, 0.05);
        }
        .upload-zone input[type="file"] {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0; cursor: pointer;
        }
        .upload-zone-icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
        .upload-zone-text {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }
        .upload-zone-text strong {
            color: var(--primary-color);
        }

        /* Preview des fichiers */
        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 0.75rem;
            margin-top: 1rem;
        }
        .preview-item {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            aspect-ratio: 1;
        }
        .preview-item img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .preview-item .remove-preview {
            position: absolute; top: 4px; right: 4px;
            background: rgba(0,0,0,0.6); color: white;
            border: none; border-radius: 50%;
            width: 24px; height: 24px;
            cursor: pointer; font-size: 14px;
            display: flex; align-items: center; justify-content: center;
        }

        /* Categorie section admin */
        .category-section {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }
        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background: var(--background-light);
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
        }
        .category-header h3 {
            margin: 0;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .category-header .photo-count {
            background: var(--primary-color);
            color: white;
            font-size: 0.75rem;
            padding: 0.15rem 0.5rem;
            border-radius: 999px;
            font-weight: 600;
        }
        .category-photos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            padding: 1.5rem;
        }
        .gallery-item {
            background: white; border-radius: var(--radius-md); overflow: hidden;
            box-shadow: var(--shadow-sm); position: relative;
            border: 1px solid var(--border-color);
        }
        .gallery-item img {
            width: 100%; height: 150px; object-fit: cover;
        }
        .gallery-item-info {
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }
        .gallery-item-actions {
            padding: 0.5rem 0.75rem;
            border-top: 1px solid var(--border-color);
        }
        .btn-delete {
            padding: 0.3rem 0.75rem;
            font-size: 0.8rem;
            background: var(--error);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-delete:hover {
            background: #dc2626;
            color: white;
        }
        .btn-delete-category {
            padding: 0.3rem 0.75rem;
            font-size: 0.8rem;
            background: transparent;
            color: var(--error);
            border: 1px solid var(--error);
            border-radius: var(--radius-sm);
            cursor: pointer;
            text-decoration: none;
        }
        .btn-delete-category:hover {
            background: var(--error);
            color: white;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-sidebar">
            <h2>📊 Admin Panel</h2>
            <nav class="admin-menu">
                <a href="index.php">🏠 Tableau de bord</a>
                <a href="news.php">📰 Actualités</a>
                <a href="cinema.php">🎬 Cinema</a>
                <a href="members.php">👥 Membres</a>
                <a href="gallery.php" class="active">📸 Galerie</a>
                <a href="press.php">📄 Presse</a>
                <a href="videos.php">🎥 Vidéos</a>
                <a href="messages.php">✉️ Messages</a>
                <a href="../index.php" target="_blank">🌐 Voir le site</a>
                <a href="?logout=1" style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">🚪 Déconnexion</a>
            </nav>
        </div>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Galerie photos</h1>
                <span style="color: var(--text-secondary);"><?php echo count($photos); ?> photo(s) dans <?php echo count($categories); ?> categorie(s)</span>
            </div>

            <?php if ($message): ?>
                <div class="form-message <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire d'upload -->
            <div style="background: white; padding: 2rem; border-radius: var(--radius-lg); margin-bottom: 2rem; box-shadow: var(--shadow-md);">
                <h2 style="margin-bottom: 1.5rem;">Ajouter des photos</h2>
                <form method="POST" enctype="multipart/form-data" id="upload-form">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Categorie *</label>
                            <input type="text" name="category" class="form-control"
                                   list="categories-list"
                                   placeholder="Choisir ou creer une categorie"
                                   required>
                            <datalist id="categories-list">
                                <?php foreach ($existing_categories as $cat): ?>
                                    <option value="<?php echo htmlspecialchars($cat); ?>">
                                <?php endforeach; ?>
                            </datalist>
                            <small style="color: var(--text-secondary);">Les photos avec la meme categorie seront regroupees ensemble</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description (optionnelle)</label>
                            <input type="text" name="description" class="form-control" placeholder="Description commune aux photos">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Photos *</label>
                        <div class="upload-zone" id="upload-zone">
                            <input type="file" name="images[]" id="file-input" multiple accept="image/jpeg,image/png,image/gif,image/webp" required>
                            <div class="upload-zone-icon">+</div>
                            <div class="upload-zone-text">
                                <strong>Cliquez ou glissez-deposez</strong> vos photos ici<br>
                                <small>JPG, PNG, GIF, WebP - Plusieurs fichiers possibles</small>
                            </div>
                        </div>
                        <div class="preview-grid" id="preview-grid"></div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submit-btn" style="margin-top: 1rem;">
                        Ajouter les photos
                    </button>
                </form>
            </div>

            <!-- Liste des photos par categorie -->
            <h2 style="margin-bottom: 1.5rem;">Photos par categorie</h2>

            <?php if (empty($categories)): ?>
                <p style="text-align: center; padding: 2rem; color: var(--text-secondary);">Aucune photo dans la galerie</p>
            <?php else: ?>
                <?php foreach ($categories as $cat_name => $cat_photos): ?>
                    <div class="category-section">
                        <div class="category-header">
                            <h3>
                                <?php echo htmlspecialchars($cat_name); ?>
                                <span class="photo-count"><?php echo count($cat_photos); ?> photo(s)</span>
                            </h3>
                            <?php if ($cat_name !== 'Sans categorie'): ?>
                                <a href="?delete_category=<?php echo urlencode($cat_name); ?>"
                                   onclick="return confirm('Supprimer la categorie &laquo; <?php echo htmlspecialchars($cat_name); ?> &raquo; et toutes ses photos ?')"
                                   class="btn-delete-category">
                                    Supprimer la categorie
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="category-photos">
                            <?php foreach ($cat_photos as $photo): ?>
                                <div class="gallery-item">
                                    <img src="../uploads/gallery/<?php echo htmlspecialchars($photo['image']); ?>"
                                         alt="<?php echo htmlspecialchars($photo['title']); ?>"
                                         onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22150%22><rect fill=%22%23f3f4f6%22 width=%22200%22 height=%22150%22/><text x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 fill=%22%239ca3af%22 font-size=%2214%22>Image manquante</text></svg>'">
                                    <div class="gallery-item-info">
                                        <?php if ($photo['title']): ?>
                                            <strong><?php echo htmlspecialchars($photo['title']); ?></strong>
                                        <?php endif; ?>
                                    </div>
                                    <div class="gallery-item-actions">
                                        <a href="?delete=<?php echo $photo['id']; ?>"
                                           onclick="return confirm('Supprimer cette photo ?')"
                                           class="btn-delete">
                                            Supprimer
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
    // Preview des images avant upload
    const fileInput = document.getElementById('file-input');
    const previewGrid = document.getElementById('preview-grid');
    const uploadZone = document.getElementById('upload-zone');

    fileInput.addEventListener('change', function() {
        previewGrid.innerHTML = '';
        const files = this.files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!file.type.startsWith('image/')) continue;

            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                previewGrid.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag & drop visual feedback
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    uploadZone.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });
    uploadZone.addEventListener('drop', function() {
        this.classList.remove('dragover');
    });
    </script>
</body>
</html>
