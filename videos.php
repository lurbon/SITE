<?php
require_once 'includes/config.php';

$videos = $pdo->query("SELECT * FROM videos ORDER BY created_at DESC")->fetchAll();

$page_title = "Videos";
include 'includes/header.php';
?>

<section class="hero" style="padding: 4rem 1rem;">
    <div class="hero-content">
        <h1>Nos videos</h1>
        <p>Retrouvez nos moments en video</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (empty($videos)): ?>
            <div style="text-align: center; padding: 4rem 1rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">&#9654;</div>
                <h2 style="color: var(--text-secondary); font-weight: 400;">Aucune video pour le moment</h2>
                <p style="color: var(--text-secondary); margin-top: 1rem;">Revenez bientot pour decouvrir nos videos !</p>
            </div>
        <?php else: ?>
            <div class="videos-list">
                <?php foreach ($videos as $video): ?>
                    <div class="video-card">
                        <div class="video-player">
                            <iframe
                                src="https://www.youtube.com/embed/<?php echo htmlspecialchars($video['youtube_id']); ?>"
                                title="<?php echo htmlspecialchars($video['title']); ?>"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                loading="lazy">
                            </iframe>
                        </div>
                        <div class="video-info">
                            <h2 class="video-title"><?php echo htmlspecialchars($video['title']); ?></h2>
                            <?php if ($video['description']): ?>
                                <p class="video-desc"><?php echo nl2br(htmlspecialchars($video['description'])); ?></p>
                            <?php endif; ?>
                            <div class="video-date">
                                Ajoutee le <?php echo date('d/m/Y', strtotime($video['created_at'])); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.videos-list {
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}

.video-card {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: transform 0.3s, box-shadow 0.3s;
}
.video-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.video-player {
    position: relative;
    width: 100%;
    padding-bottom: 56.25%; /* 16:9 */
    background: #000;
}
.video-player iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.video-info {
    padding: 1.5rem 2rem;
}
.video-title {
    font-size: 1.4rem;
    margin: 0 0 0.5rem;
    color: var(--text-primary);
    line-height: 1.3;
}
.video-desc {
    font-size: 0.95rem;
    color: var(--text-secondary);
    line-height: 1.7;
    margin: 0 0 0.75rem;
}
.video-date {
    font-size: 0.8rem;
    color: var(--text-secondary);
    opacity: 0.7;
}

@media (max-width: 768px) {
    .video-info {
        padding: 1rem 1.25rem;
    }
    .video-title {
        font-size: 1.15rem;
    }
    .video-desc {
        font-size: 0.85rem;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
