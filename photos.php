<?php
require_once 'includes/config.php';

// Récupérer toutes les photos
$photos = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC")->fetchAll();

// Grouper par catégorie
$categories = [];
foreach ($photos as $photo) {
    $cat = $photo['category'] ?: 'Sans catégorie';
    if (!isset($categories[$cat])) {
        $categories[$cat] = [];
    }
    $categories[$cat][] = $photo;
}

$page_title = "Galerie photos";
include 'includes/header.php';
?>

<section class="hero" style="padding: 4rem 1rem;">
    <div class="hero-content">
        <h1>Galerie photos</h1>
        <p>Découvrez nos moments en images</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (empty($photos)): ?>
            <div style="text-align: center; padding: 4rem 1rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📸</div>
                <h2 style="color: var(--text-secondary); font-weight: 400;">Galerie en cours de création</h2>
                <p style="color: var(--text-secondary); margin-top: 1rem;">Revenez bientôt pour découvrir nos photos !</p>
            </div>
        <?php else: ?>
            <?php foreach ($categories as $category => $cat_photos): ?>
                <div style="margin-bottom: 4rem;">
                    <h2 style="color: var(--primary-color); margin-bottom: 2rem;"><?php echo htmlspecialchars($category); ?></h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                        <?php foreach ($cat_photos as $photo): ?>
                            <div class="card" style="cursor: pointer;" onclick="openLightbox('uploads/gallery/<?php echo htmlspecialchars($photo['image']); ?>', '<?php echo htmlspecialchars($photo['title'] ?: ''); ?>')">
                                <img src="uploads/gallery/<?php echo htmlspecialchars($photo['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($photo['title'] ?: ''); ?>" 
                                     class="card-image gallery-image" 
                                     style="height: 250px; width: 100%; object-fit: cover;">
                                <?php if ($photo['title'] || $photo['description']): ?>
                                    <div class="card-content">
                                        <?php if ($photo['title']): ?>
                                            <h3 class="card-title" style="font-size: 1.125rem;"><?php echo htmlspecialchars($photo['title']); ?></h3>
                                        <?php endif; ?>
                                        <?php if ($photo['description']): ?>
                                            <p class="card-text"><?php echo htmlspecialchars($photo['description']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<script>
function openLightbox(src, title) {
    const lightbox = document.createElement('div');
    lightbox.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.95);display:flex;align-items:center;justify-content:center;z-index:9999;cursor:pointer;';
    lightbox.innerHTML = '<div style="max-width:90%;max-height:90%;text-align:center;"><img src="' + src + '" style="max-width:100%;max-height:90vh;border-radius:var(--radius-lg);"><div style="color:white;margin-top:1rem;font-size:1.25rem;">' + title + '</div></div>';
    lightbox.onclick = () => lightbox.remove();
    document.body.appendChild(lightbox);
}
</script>

<?php include 'includes/footer.php'; ?>
