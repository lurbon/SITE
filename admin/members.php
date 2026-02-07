<?php
require_once '../includes/config.php';
require_once 'check_auth.php';

$message = '';
$message_type = '';

// Supprimer un membre
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT photo FROM members WHERE id = ?");
    $stmt->execute([$id]);
    $member = $stmt->fetch();
    
    if ($member && $member['photo']) {
        @unlink('../uploads/members/' . $member['photo']);
    }
    
    $stmt = $pdo->prepare("DELETE FROM members WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Membre supprimé avec succès";
    $message_type = 'success';
}

// Ajouter ou modifier un membre
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $role = $_POST['role'] ?? '';
    $bio = $_POST['bio'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $display_order = (int)($_POST['display_order'] ?? 0);
    $current_photo = $_POST['current_photo'] ?? '';
    
    $photo = $current_photo;
    
    // Upload de la photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['photo']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            
            // Créer le dossier s'il n'existe pas
            if (!file_exists('../uploads/members')) {
                mkdir('../uploads/members', 0755, true);
            }
            
            if (move_uploaded_file($_FILES['photo']['tmp_name'], '../uploads/members/' . $new_filename)) {
                if ($current_photo && file_exists('../uploads/members/' . $current_photo)) {
                    @unlink('../uploads/members/' . $current_photo);
                }
                $photo = $new_filename;
            }
        }
    }
    
    try {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE members SET name = ?, role = ?, photo = ?, bio = ?, email = ?, phone = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$name, $role, $photo, $bio, $email, $phone, $display_order, $id]);
            $message = "Membre modifié avec succès";
        } else {
            $stmt = $pdo->prepare("INSERT INTO members (name, role, photo, bio, email, phone, display_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $role, $photo, $bio, $email, $phone, $display_order]);
            $message = "Membre ajouté avec succès";
        }
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
        $message_type = 'error';
    }
}

$edit_member = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM members WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_member = $stmt->fetch();
}

$members = $pdo->query("SELECT * FROM members ORDER BY display_order ASC, id ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des membres - Administration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { display: flex; min-height: 100vh; }
        .admin-sidebar {
            width: 250px;
            background: var(--text-primary);
            color: white;
            padding: 2rem 0;
        }
        .admin-sidebar h2 {
            color: white;
            padding: 0 1.5rem;
            margin-bottom: 2rem;
        }
        .admin-menu a {
            display: block;
            padding: 1rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .admin-menu a:hover,
        .admin-menu a.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--primary-color);
        }
        .admin-content {
            flex: 1;
            padding: 2rem;
            background: var(--background-light);
        }
        .admin-header {
            background: white;
            padding: 1.5rem 2rem;
            margin: -2rem -2rem 2rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-image-preview {
            max-width: 150px;
            margin-top: 1rem;
            border-radius: 50%;
            aspect-ratio: 1;
            object-fit: cover;
        }
        table {
            width: 100%;
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }
        table th, table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        table th {
            background: var(--background-dark);
            font-weight: 600;
        }
        table tr:last-child td {
            border-bottom: none;
        }
        table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
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
                <a href="members.php" class="active">👥 Membres</a>
                <a href="gallery.php">📸 Galerie</a>
                <a href="press.php">📄 Presse</a>
                <a href="videos.php">🎥 Vidéos</a>
                <a href="messages.php">✉️ Messages</a>
                <a href="../index.php" target="_blank">🌐 Voir le site</a>
                <a href="?logout=1" style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">
                    🚪 Déconnexion
                </a>
            </nav>
        </div>
        
        <div class="admin-content">
            <div class="admin-header">
                <h1>Gestion des membres du bureau</h1>
            </div>
            
            <?php if ($message): ?>
                <div class="form-message <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <div style="background: white; padding: 2rem; border-radius: var(--radius-lg); margin-bottom: 2rem; box-shadow: var(--shadow-md);">
                <h2><?php echo $edit_member ? 'Modifier le membre' : 'Ajouter un membre'; ?></h2>
                <form method="POST" enctype="multipart/form-data">
                    <?php if ($edit_member): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_member['id']; ?>">
                        <input type="hidden" name="current_photo" value="<?php echo htmlspecialchars($edit_member['photo']); ?>">
                    <?php endif; ?>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Nom complet *</label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?php echo htmlspecialchars($edit_member['name'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Fonction *</label>
                            <input type="text" name="role" class="form-control" 
                                   value="<?php echo htmlspecialchars($edit_member['role'] ?? ''); ?>" 
                                   placeholder="Ex: Président(e)" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Biographie</label>
                        <textarea name="bio" class="form-control" rows="4"><?php echo htmlspecialchars($edit_member['bio'] ?? ''); ?></textarea>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?php echo htmlspecialchars($edit_member['email'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="phone" class="form-control" 
                                   value="<?php echo htmlspecialchars($edit_member['phone'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Ordre d'affichage</label>
                            <input type="number" name="display_order" class="form-control" 
                                   value="<?php echo htmlspecialchars($edit_member['display_order'] ?? 0); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        <?php if ($edit_member && $edit_member['photo']): ?>
                            <img src="../uploads/members/<?php echo htmlspecialchars($edit_member['photo']); ?>" 
                                 class="form-image-preview">
                        <?php endif; ?>
                    </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $edit_member ? 'Modifier' : 'Ajouter'; ?>
                        </button>
                        <?php if ($edit_member): ?>
                            <a href="members.php" class="btn btn-secondary">Annuler</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            
            <h2>Liste des membres</h2>
            <?php if (empty($members)): ?>
                <p style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                    Aucun membre pour le moment
                </p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Nom</th>
                            <th>Fonction</th>
                            <th>Contact</th>
                            <th>Ordre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td>
                                    <?php if ($member['photo']): ?>
                                        <img src="../uploads/members/<?php echo htmlspecialchars($member['photo']); ?>">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; background: var(--primary-color); 
                                                    border-radius: 50%; display: flex; align-items: center; 
                                                    justify-content: center; color: white; font-size: 1.5rem;">👤</div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?php echo htmlspecialchars($member['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($member['role']); ?></td>
                                <td>
                                    <?php if ($member['email']): ?>
                                        <div><?php echo htmlspecialchars($member['email']); ?></div>
                                    <?php endif; ?>
                                    <?php if ($member['phone']): ?>
                                        <div><?php echo htmlspecialchars($member['phone']); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $member['display_order']; ?></td>
                                <td>
                                    <a href="?edit=<?php echo $member['id']; ?>" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                        Modifier
                                    </a>
                                    <a href="?delete=<?php echo $member['id']; ?>" 
                                       onclick="return confirm('Supprimer ce membre ?')"
                                       class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem; background: var(--error);">
                                        Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
