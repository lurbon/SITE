<?php
require_once 'includes/config.php';

// Recuperer toutes les photos
$photos = $pdo->query("SELECT * FROM gallery ORDER BY category, created_at DESC")->fetchAll();

// Grouper par categorie
$categories = [];
foreach ($photos as $photo) {
    $cat = $photo['category'] ?: 'Sans categorie';
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
        <p>Decouvrez nos moments en images</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (empty($photos)): ?>
            <div style="text-align: center; padding: 4rem 1rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">+</div>
                <h2 style="color: var(--text-secondary); font-weight: 400;">Galerie en cours de creation</h2>
                <p style="color: var(--text-secondary); margin-top: 1rem;">Revenez bientot pour decouvrir nos photos !</p>
            </div>
        <?php else: ?>
            <!-- Filtres par categorie -->
            <?php if (count($categories) > 1): ?>
            <div class="gallery-filters">
                <button class="gallery-filter active" data-filter="all">Toutes</button>
                <?php foreach (array_keys($categories) as $cat_name): ?>
                    <button class="gallery-filter" data-filter="<?php echo htmlspecialchars($cat_name); ?>">
                        <?php echo htmlspecialchars($cat_name); ?>
                        <span class="filter-count"><?php echo count($categories[$cat_name]); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Galeries par categorie -->
            <?php foreach ($categories as $category => $cat_photos): ?>
                <div class="gallery-category" data-category="<?php echo htmlspecialchars($category); ?>">
                    <div class="gallery-category-header">
                        <h2><?php echo htmlspecialchars($category); ?></h2>
                        <span class="gallery-category-count"><?php echo count($cat_photos); ?> photo<?php echo count($cat_photos) > 1 ? 's' : ''; ?></span>
                    </div>
                    <div class="gallery-grid">
                        <?php foreach ($cat_photos as $index => $photo): ?>
                            <div class="gallery-card"
                                 data-src="uploads/gallery/<?php echo htmlspecialchars($photo['image']); ?>"
                                 data-title="<?php echo htmlspecialchars($photo['title'] ?: ''); ?>"
                                 data-category="<?php echo htmlspecialchars($category); ?>"
                                 onclick="openGalleryLightbox('<?php echo htmlspecialchars($category); ?>', <?php echo $index; ?>)">
                                <div class="gallery-card-image">
                                    <img src="uploads/gallery/<?php echo htmlspecialchars($photo['image']); ?>"
                                         alt="<?php echo htmlspecialchars($photo['title'] ?: $category); ?>"
                                         loading="lazy"
                                         onerror="this.parentElement.innerHTML='<div style=\'display:flex;align-items:center;justify-content:center;height:100%;background:var(--background-light);color:var(--text-secondary);\'>Image indisponible</div>'">
                                    <div class="gallery-card-overlay">
                                        <span class="gallery-card-zoom">Voir</span>
                                    </div>
                                </div>
                                <?php if ($photo['title'] || $photo['description']): ?>
                                    <div class="gallery-card-info">
                                        <?php if ($photo['title']): ?>
                                            <h3><?php echo htmlspecialchars($photo['title']); ?></h3>
                                        <?php endif; ?>
                                        <?php if ($photo['description']): ?>
                                            <p><?php echo htmlspecialchars($photo['description']); ?></p>
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

<style>
/* Filtres */
.gallery-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 2.5rem;
    justify-content: center;
}
.gallery-filter {
    padding: 0.5rem 1.25rem;
    border: 2px solid var(--border-color);
    background: white;
    border-radius: 999px;
    cursor: pointer;
    font-family: var(--font-main);
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text-secondary);
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.gallery-filter:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}
.gallery-filter.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}
.gallery-filter.active .filter-count {
    background: rgba(255,255,255,0.3);
    color: white;
}
.filter-count {
    background: var(--background-light);
    color: var(--text-secondary);
    font-size: 0.75rem;
    padding: 0.1rem 0.4rem;
    border-radius: 999px;
    font-weight: 600;
}

/* Categorie */
.gallery-category {
    margin-bottom: 3rem;
    transition: opacity 0.4s, transform 0.4s;
}
.gallery-category.hidden {
    display: none;
}
.gallery-category-header {
    display: flex;
    align-items: baseline;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 3px solid var(--primary-color);
}
.gallery-category-header h2 {
    color: var(--text-primary);
    font-size: 1.5rem;
    margin: 0;
}
.gallery-category-count {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

/* Grille de photos */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.25rem;
}

/* Card photo */
.gallery-card {
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: white;
    box-shadow: var(--shadow-md);
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
}
.gallery-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
}
.gallery-card-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}
.gallery-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s;
}
.gallery-card:hover .gallery-card-image img {
    transform: scale(1.05);
}
.gallery-card-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}
.gallery-card:hover .gallery-card-overlay {
    opacity: 1;
}
.gallery-card-zoom {
    color: white;
    font-size: 1rem;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
    border: 2px solid white;
    border-radius: var(--radius-md);
    transition: background 0.2s;
}
.gallery-card:hover .gallery-card-zoom {
    background: rgba(255,255,255,0.15);
}
.gallery-card-info {
    padding: 0.75rem 1rem;
}
.gallery-card-info h3 {
    font-size: 0.95rem;
    margin: 0 0 0.25rem;
    color: var(--text-primary);
    font-weight: 600;
}
.gallery-card-info p {
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.4;
}

/* Lightbox */
.gallery-lightbox {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.95);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: lbFadeIn 0.3s;
}
.gallery-lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.gallery-lightbox-content img {
    max-width: 100%;
    max-height: 80vh;
    border-radius: var(--radius-lg);
    object-fit: contain;
}
.gallery-lightbox-caption {
    color: white;
    margin-top: 1rem;
    font-size: 1.1rem;
    text-align: center;
}
.gallery-lightbox-counter {
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
    margin-top: 0.25rem;
}
.gallery-lightbox-close {
    position: fixed;
    top: 1.5rem; right: 1.5rem;
    color: white;
    font-size: 2rem;
    cursor: pointer;
    width: 44px; height: 44px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    transition: background 0.2s;
    background: rgba(255,255,255,0.1);
    border: none;
    line-height: 1;
}
.gallery-lightbox-close:hover {
    background: rgba(255,255,255,0.25);
}
.gallery-lightbox-nav {
    position: fixed;
    top: 50%;
    transform: translateY(-50%);
    color: white;
    font-size: 2.5rem;
    cursor: pointer;
    width: 54px; height: 54px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    transition: background 0.2s;
    background: rgba(255,255,255,0.1);
    border: none;
    line-height: 1;
    user-select: none;
}
.gallery-lightbox-nav:hover {
    background: rgba(255,255,255,0.25);
}
.gallery-lightbox-prev { left: 1.5rem; }
.gallery-lightbox-next { right: 1.5rem; }

@keyframes lbFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Responsive */
@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 0.75rem;
    }
    .gallery-card-image {
        height: 160px;
    }
    .gallery-card-info {
        padding: 0.5rem 0.75rem;
    }
    .gallery-card-info h3 {
        font-size: 0.85rem;
    }
    .gallery-lightbox-nav {
        width: 40px; height: 40px;
        font-size: 1.5rem;
    }
    .gallery-lightbox-prev { left: 0.5rem; }
    .gallery-lightbox-next { right: 0.5rem; }
    .gallery-category-header h2 {
        font-size: 1.25rem;
    }
    .gallery-filters {
        gap: 0.35rem;
    }
    .gallery-filter {
        padding: 0.4rem 0.9rem;
        font-size: 0.8rem;
    }
}
</style>

<script>
// Donnees des galeries pour la lightbox
var galleryData = {};
<?php foreach ($categories as $category => $cat_photos): ?>
galleryData[<?php echo json_encode($category); ?>] = [
    <?php foreach ($cat_photos as $photo): ?>
    {
        src: <?php echo json_encode('uploads/gallery/' . $photo['image']); ?>,
        title: <?php echo json_encode($photo['title'] ?: ''); ?>
    },
    <?php endforeach; ?>
];
<?php endforeach; ?>

// Filtrage par categorie
document.querySelectorAll('.gallery-filter').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var filter = this.getAttribute('data-filter');

        // Mettre a jour le bouton actif
        document.querySelectorAll('.gallery-filter').forEach(function(b) {
            b.classList.remove('active');
        });
        this.classList.add('active');

        // Filtrer les categories
        document.querySelectorAll('.gallery-category').forEach(function(cat) {
            if (filter === 'all' || cat.getAttribute('data-category') === filter) {
                cat.classList.remove('hidden');
            } else {
                cat.classList.add('hidden');
            }
        });
    });
});

// Lightbox avec navigation
var currentLightbox = null;

function openGalleryLightbox(category, index) {
    var photos = galleryData[category];
    if (!photos || !photos.length) return;

    closeLightbox();

    var lightbox = document.createElement('div');
    lightbox.className = 'gallery-lightbox';
    lightbox.setAttribute('data-category', category);
    lightbox.setAttribute('data-index', index);

    function render(idx) {
        var photo = photos[idx];
        lightbox.setAttribute('data-index', idx);
        lightbox.innerHTML =
            '<button class="gallery-lightbox-close" aria-label="Fermer">&times;</button>' +
            (photos.length > 1 ? '<button class="gallery-lightbox-nav gallery-lightbox-prev" aria-label="Precedent">&#8249;</button>' : '') +
            (photos.length > 1 ? '<button class="gallery-lightbox-nav gallery-lightbox-next" aria-label="Suivant">&#8250;</button>' : '') +
            '<div class="gallery-lightbox-content">' +
                '<img src="' + photo.src + '" alt="' + photo.title + '">' +
                (photo.title ? '<div class="gallery-lightbox-caption">' + photo.title + '</div>' : '') +
                (photos.length > 1 ? '<div class="gallery-lightbox-counter">' + (idx + 1) + ' / ' + photos.length + '</div>' : '') +
            '</div>';

        // Events
        lightbox.querySelector('.gallery-lightbox-close').onclick = closeLightbox;

        var prevBtn = lightbox.querySelector('.gallery-lightbox-prev');
        var nextBtn = lightbox.querySelector('.gallery-lightbox-next');
        if (prevBtn) {
            prevBtn.onclick = function(e) {
                e.stopPropagation();
                render((idx - 1 + photos.length) % photos.length);
            };
        }
        if (nextBtn) {
            nextBtn.onclick = function(e) {
                e.stopPropagation();
                render((idx + 1) % photos.length);
            };
        }

        lightbox.querySelector('.gallery-lightbox-content').onclick = function(e) {
            e.stopPropagation();
        };
    }

    lightbox.onclick = closeLightbox;
    render(index);
    document.body.appendChild(lightbox);
    document.body.style.overflow = 'hidden';
    currentLightbox = lightbox;

    // Navigation clavier
    document.addEventListener('keydown', handleLightboxKey);
}

function closeLightbox() {
    if (currentLightbox) {
        currentLightbox.remove();
        currentLightbox = null;
        document.body.style.overflow = '';
        document.removeEventListener('keydown', handleLightboxKey);
    }
}

function handleLightboxKey(e) {
    if (!currentLightbox) return;
    var category = currentLightbox.getAttribute('data-category');
    var index = parseInt(currentLightbox.getAttribute('data-index'));
    var photos = galleryData[category];

    if (e.key === 'Escape') {
        closeLightbox();
    } else if (e.key === 'ArrowLeft' && photos.length > 1) {
        closeLightbox();
        openGalleryLightbox(category, (index - 1 + photos.length) % photos.length);
    } else if (e.key === 'ArrowRight' && photos.length > 1) {
        closeLightbox();
        openGalleryLightbox(category, (index + 1) % photos.length);
    }
}
</script>

<?php include 'includes/footer.php'; ?>