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
    $message = "Photo supprimée avec succès";
    $message_type = 'success';
}

// Ajouter une photo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? '';
    
    if ($_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            
            if (!file_exists('../uploads/gallery')) {
                mkdir('../uploads/gallery', 0755, true);
            }
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/gallery/' . $new_filename)) {
                $stmt = $pdo->prepare("INSERT INTO gallery (title, description, image, category) VALUES (?, ?, ?, ?)");
                $stmt->execute([$title, $description, $new_filename, $category]);
                $message = "Photo ajoutée avec succès";
                $message_type = 'success';
            }
        }
    }
}

$photos = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC")->fetchAll();
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
        .gallery-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem; margin-top: 2rem;
        }
        .gallery-item {
            background: white; border-radius: var(--radius-lg); overflow: hidden;
            box-shadow: var(--shadow-md); position: relative;
        }
        .gallery-item img {
            width: 100%; height: 200px; object-fit: cover;
        }
        .gallery-item-info {
            padding: 1rem;
        }
        .gallery-item-actions {
            padding: 0.5rem 1rem; border-top: 1px solid var(--border-color);
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
            </div>
            
            <?php if ($message): ?>
                <div class="form-message <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <div style="background: white; padding: 2rem; border-radius: var(--radius-lg); margin-bottom: 2rem; box-shadow: var(--shadow-md);">
                <h2>Ajouter une photo</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Titre</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Catégorie</label>
                            <input type="text" name="category" class="form-control" placeholder="Ex: Événements 2024">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Photo *</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter la photo</button>
                </form>
            </div>
            
            <h2>Photos (<?php echo count($photos); ?>)</h2>
            <?php if (empty($photos)): ?>
                <p style="text-align: center; padding: 2rem; color: var(--text-secondary);">Aucune photo</p>
            <?php else: ?>
                <div class="gallery-grid">
                    <?php foreach ($photos as $photo): ?>
                        <div class="gallery-item">
                            <img src="../uploads/gallery/<?php echo htmlspecialchars($photo['image']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>">
                            <div class="gallery-item-info">
                                <?php if ($photo['title']): ?>
                                    <strong><?php echo htmlspecialchars($photo['title']); ?></strong><br>
                                <?php endif; ?>
                                <?php if ($photo['category']): ?>
                                    <small style="color: var(--text-secondary);"><?php echo htmlspecialchars($photo['category']); ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="gallery-item-actions">
                                <a href="?delete=<?php echo $photo['id']; ?>" onclick="return confirm('Supprimer?')" 
                                   class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem; background: var(--error);">
                                    Supprimer
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
