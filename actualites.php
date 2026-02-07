<?php
require_once 'includes/config.php';

// Récupérer une actualité spécifique si ID fourni
$single_news = null;
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ? AND published = 1");
    $stmt->execute([$_GET['id']]);
    $single_news = $stmt->fetch();
}

// Si pas d'actualité spécifique, récupérer toutes les actualités
if (!$single_news) {
    $stmt = $pdo->query("SELECT * FROM news WHERE published = 1 ORDER BY created_at DESC");
    $all_news = $stmt->fetchAll();
}

$page_title = $single_news ? $single_news['title'] : "Actualités";
include 'includes/header.php';
?>

<?php if ($single_news): ?>
    <!-- Vue d'une actualité -->
    <section class="hero" style="padding: 4rem 1rem;">
        <div class="hero-content">
            <p style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 1rem;">
                <?php echo date('d/m/Y', strtotime($single_news['created_at'])); ?>
            </p>
            <h1><?php echo htmlspecialchars($single_news['title']); ?></h1>
        </div>
    </section>
    
    <section class="section">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto;">
                <a href="actualites.php" style="display: inline-flex; align-items: center; gap: 0.5rem; 
                                                 color: var(--primary-color); margin-bottom: 2rem;">
                    ← Retour aux actualités
                </a>
                
                <?php if ($single_news['image']): ?>
                    <img src="uploads/news/<?php echo htmlspecialchars($single_news['image']); ?>" 
                         alt="<?php echo htmlspecialchars($single_news['title']); ?>"
                         style="width: 100%; border-radius: var(--radius-lg); margin-bottom: 2rem;">
                <?php endif; ?>
                
                <div style="font-size: 1.125rem; line-height: 1.8; color: var(--text-secondary);">
                    <?php echo nl2br(htmlspecialchars($single_news['content'])); ?>
                </div>
                
                <div style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid var(--border-color);">
                    <a href="actualites.php" class="btn btn-primary">← Voir toutes les actualités</a>
                </div>
            </div>
        </div>
    </section>
    
<?php else: ?>
    <!-- Liste des actualités -->
    <section class="hero" style="padding: 4rem 1rem;">
        <div class="hero-content">
            <h1>Nos actualités</h1>
            <p>Suivez les dernières nouvelles de l'association</p>
        </div>
    </section>
    
    <section class="section">
        <div class="container">
            <?php if (empty($all_news)): ?>
                <div style="text-align: center; padding: 4rem 1rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📰</div>
                    <h2 style="color: var(--text-secondary); font-weight: 400;">Aucune actualité pour le moment</h2>
                    <p style="color: var(--text-secondary); margin-top: 1rem;">Revenez bientôt pour découvrir nos dernières nouvelles !</p>
                </div>
            <?php else: ?>
                <div class="cards-grid">
                    <?php foreach ($all_news as $news): ?>
                        <div class="card">
                            <?php if ($news['image']): ?>
                                <img src="uploads/news/<?php echo htmlspecialchars($news['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($news['title']); ?>" 
                                     class="card-image">
                            <?php else: ?>
                                <div class="card-image" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); 
                                                                display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem;">
                                    📰
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-content">
                                <div class="card-date">
                                    <?php echo date('d/m/Y', strtotime($news['created_at'])); ?>
                                </div>
                                <h3 class="card-title"><?php echo htmlspecialchars($news['title']); ?></h3>
                                <p class="card-text">
                                    <?php 
                                    $content = strip_tags($news['content']);
                                    echo htmlspecialchars(substr($content, 0, 200)) . '...'; 
                                    ?>
                                </p>
                                <a href="actualites.php?id=<?php echo $news['id']; ?>" class="btn btn-primary">
                                    Lire la suite
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
