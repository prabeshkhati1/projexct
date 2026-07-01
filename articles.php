<?php
$pageTitle = 'Articles & Insights | AI-Solutions';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
$articles = articles();
$featured = $articles[0];
$categories = array_unique(array_column($articles, 'category'));
?>
<section class="section">
    <div class="container">
        <div class="section-title">
            <div>
                <h1>Articles & Insights</h1>
                <p class="section-subtitle">Company articles promoting AI-Solutions services, prototypes and business benefits.</p>
            </div>
        </div>

        <article class="feature-band">
            <img src="<?= e($featured['image']) ?>" alt="<?= e($featured['title']) ?>">
            <div>
                <span class="pill">Featured · <?= e($featured['category']) ?></span>
                <h2><?= e($featured['title']) ?></h2>
                <p><?= e($featured['summary']) ?></p>
                <a class="btn" href="article-detail.php?id=<?= e($featured['id']) ?>">Read Article</a>
            </div>
        </article>

        <div class="layout-with-sidebar" style="margin-top:24px;">
            <aside class="sidebar">
                <h3>Filters</h3>
                <input class="filter-input" data-filter-search="articles" type="search" placeholder="Search articles..." aria-label="Search articles">
                <div class="filter-group">
                    <strong>Categories</strong>
                    <?php foreach ($categories as $category): ?>
                        <label><input type="checkbox" data-filter-check="articles" value="<?= e($category) ?>"> <?= e($category) ?></label>
                    <?php endforeach; ?>
                </div>
                <p class="notice" data-filter-count="articles">Showing articles</p>
            </aside>

            <div>
                <div class="grid three" data-filter-container="articles">
                    <?php foreach ($articles as $article): ?>
                        <article class="card" data-filter-card data-title="<?= e($article['title']) ?>" data-category="<?= e($article['category']) ?>" data-date="<?= e($article['date']) ?>">
                            <img class="card-image" src="<?= e($article['image']) ?>" alt="<?= e($article['title']) ?>">
                            <div class="card-body">
                                <span class="pill"><?= e($article['category']) ?> · <?= e($article['date']) ?></span>
                                <h3><?= e($article['title']) ?></h3>
                                <p><?= e($article['summary']) ?></p>
                                <a class="btn small" href="article-detail.php?id=<?= e($article['id']) ?>">Read More</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="pagination" aria-label="Article pagination"><button>‹</button><button class="active">1</button><button>2</button><button>›</button></div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
