<?php
require_once '../includes/config.php';
require_once 'check_auth.php';

$message = '';
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT pdf_file, image FROM press WHERE id = ?");
    $stmt->execute([$id]);
    $press = $stmt->fetch();
    if ($press) {
        if ($press['pdf_file']) @unlink('../uploads/press/' . $press['pdf_file']);
        if ($press['image']) @unlink('../uploads/press/' . $press['image']);
    }
    $pdo->prepare("DELETE FROM press WHERE id = ?")->execute([$id]);
    $message = "Article supprimé";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $media = $_POST['media'] ?? '';
    $article_date = $_POST['article_date'] ?? null;
    $link = $_POST['link'] ?? '';
    
    $image = null;
    $pdf_file = null;
    
    if (!file_exists('../uploads/press')) mkdir('../uploads/press', 0755, true);
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $image = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/press/' . $image);
        }
    }
    
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['pdf_file']['name'], PATHINFO_EXTENSION));
        if ($ext === 'pdf') {
            $pdf_file = uniqid() . '.pdf';
            move_uploaded_file($_FILES['pdf_file']['tmp_name'], '../uploads/press/' . $pdf_file);
        }
    }
    
    $pdo->prepare("INSERT INTO press (title, media, article_date, image, pdf_file, link) VALUES (?, ?, ?, ?, ?, ?)")
        ->execute([$title, $media, $article_date, $image, $pdf_file, $link]);
    $message = "Article ajouté";
}

$press = $pdo->query("SELECT * FROM press ORDER BY article_date DESC, created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Presse - Administration</title>
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
        table img { width: 80px; height: 60px; object-fit: cover; border-radius: var(--radius-sm); }
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
                <a href="press.php" class="active">📄 Presse</a>
                <a href="videos.php">🎥 Vidéos</a>
                <a href="messages.php">✉️ Messages</a>
                <a href="../index.php" target="_blank">🌐 Voir le site</a>
                <a href="?logout=1" style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">🚪 Déconnexion</a>
            </nav>
        </div>
        
        <div class="admin-content">
            <div class="admin-header"><h1>Articles de presse</h1></div>
            
            <?php if ($message): ?><div class="form-message success"><?php echo $message; ?></div><?php endif; ?>
            
            <div style="background: white; padding: 2rem; border-radius: var(--radius-lg); margin-bottom: 2rem; box-shadow: var(--shadow-md);">
                <h2>Ajouter un article</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Titre de l'article *</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Média (journal, site...)</label>
                            <input type="text" name="media" class="form-control" placeholder="Ex: Le Télégramme">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date de l'article</label>
                        <input type="date" name="article_date" class="form-control">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Fichier PDF</label>
                            <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lien vers l'article en ligne</label>
                        <input type="url" name="link" class="form-control" placeholder="https://...">
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
            
            <h2>Articles (<?php echo count($press); ?>)</h2>
            <?php if (empty($press)): ?>
                <p style="text-align: center; padding: 2rem; color: var(--text-secondary);">Aucun article</p>
            <?php else: ?>
                <table>
                    <tr><th>Image</th><th>Titre</th><th>Média</th><th>Date</th><th>Fichiers</th><th>Actions</th></tr>
                    <?php foreach ($press as $p): ?>
                        <tr>
                            <td>
                                <?php if ($p['image']): ?>
                                    <img src="../uploads/press/<?php echo htmlspecialchars($p['image']); ?>">
                                <?php else: ?>
                                    <div style="width:80px;height:60px;background:var(--background-dark);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;">📄</div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo htmlspecialchars($p['title']); ?></strong></td>
                            <td><?php echo htmlspecialchars($p['media']); ?></td>
                            <td><?php echo $p['article_date'] ? date('d/m/Y', strtotime($p['article_date'])) : '-'; ?></td>
                            <td>
                                <?php if ($p['pdf_file']): ?><span style="color:var(--success);">✓ PDF</span><br><?php endif; ?>
                                <?php if ($p['link']): ?><span style="color:var(--info);">✓ Lien</span><?php endif; ?>
                            </td>
                            <td>
                                <a href="?delete=<?php echo $p['id']; ?>" onclick="return confirm('Supprimer?')" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem; background: var(--error);">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
