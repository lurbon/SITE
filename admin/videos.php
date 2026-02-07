<?php
require_once '../includes/config.php';
require_once 'check_auth.php';

$message = '';
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM videos WHERE id = ?")->execute([$_GET['delete']]);
    $message = "Vidéo supprimée";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $youtube_id = $_POST['youtube_id'] ?? '';
    
    $pdo->prepare("INSERT INTO videos (title, description, youtube_id) VALUES (?, ?, ?)")
        ->execute([$title, $description, $youtube_id]);
    $message = "Vidéo ajoutée";
}

$videos = $pdo->query("SELECT * FROM videos ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vidéos - Administration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { display: flex; min-height: 100vh; }
        .admin-sidebar { width: 250px; background: var(--text-primary); color: white; padding: 2rem 0; }
        .admin-sidebar h2 { color: white; padding: 0 1.5rem; margin-bottom: 2rem; }
        .admin-menu a {display: block; padding: 1rem 1.5rem; color: rgba(255,255,255,0.8); text-decoration: none; transition: all 0.3s; border-left: 3px solid transparent;}
        .admin-menu a:hover, .admin-menu a.active {background: rgba(255,255,255,0.1); color: white; border-left-color: var(--primary-color);}
        .admin-content { flex: 1; padding: 2rem; background: var(--background-light); }
        .admin-header {background: white; padding: 1.5rem 2rem; margin: -2rem -2rem 2rem; box-shadow: var(--shadow-sm);}
        table {width: 100%; background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md);}
        table th, table td {padding: 1rem; text-align: left; border-bottom: 1px solid var(--border-color);}
        table th {background: var(--background-dark); font-weight: 600;}
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
                <a href="gallery.php">📸 Galerie</a>
                <a href="press.php">📄 Presse</a>
                <a href="videos.php" class="active">🎥 Vidéos</a>
                <a href="messages.php">✉️ Messages</a>
                <a href="../index.php" target="_blank">🌐 Voir le site</a>
                <a href="?logout=1" style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">🚪 Déconnexion</a>
            </nav>
        </div>
        
        <div class="admin-content">
            <div class="admin-header"><h1>Gestion des vidéos</h1></div>
            
            <?php if ($message): ?><div class="form-message success"><?php echo $message; ?></div><?php endif; ?>
            
            <div style="background: white; padding: 2rem; border-radius: var(--radius-lg); margin-bottom: 2rem; box-shadow: var(--shadow-md);">
                <h2>Ajouter une vidéo YouTube</h2>
                <form method="POST">
                    <div class="form-group">
                        <label class="form-label">Titre *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ID YouTube * (ex: dQw4w9WgXcQ)</label>
                        <input type="text" name="youtube_id" class="form-control" placeholder="dQw4w9WgXcQ" required>
                        <small style="color: var(--text-secondary);">L'ID se trouve dans l'URL YouTube après "v=" ou "youtu.be/"</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
            
            <h2>Vidéos (<?php echo count($videos); ?>)</h2>
            <?php if (empty($videos)): ?>
                <p style="text-align: center; padding: 2rem; color: var(--text-secondary);">Aucune vidéo</p>
            <?php else: ?>
                <table>
                    <tr><th>Aperçu</th><th>Titre</th><th>ID YouTube</th><th>Actions</th></tr>
                    <?php foreach ($videos as $v): ?>
                        <tr>
                            <td><img src="https://img.youtube.com/vi/<?php echo htmlspecialchars($v['youtube_id']); ?>/mqdefault.jpg" style="width:120px; border-radius: var(--radius-sm);"></td>
                            <td><strong><?php echo htmlspecialchars($v['title']); ?></strong></td>
                            <td><code><?php echo htmlspecialchars($v['youtube_id']); ?></code></td>
                            <td>
                                <a href="?delete=<?php echo $v['id']; ?>" onclick="return confirm('Supprimer?')" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem; background: var(--error);">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
