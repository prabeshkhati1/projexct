<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$article = get_article_by_id($id) ?: articles()[0];
$pageTitle = $article['title'] . ' | AI-Solutions';
include __DIR__ . '/includes/header.php';
$related = array_values(array_filter(articles(), fn($item) => $item['id'] !== $article['id']));
?>
<section class="section">
    <div class="container article-layout">
        <article class="form-card">
            <div class="breadcrumb"><a href="index.php">Home</a> · <a href="articles.php">Articles</a> · <?= e($article['title']) ?></div>
            <h1><?= e($article['title']) ?></h1>
            <p><span class="pill"><?= e($article['category']) ?></span> <span class="pill"><?= e($article['date']) ?></span></p>
            <img class="card-image" src="<?= e($article['image']) ?>" alt="<?= e($article['title']) ?>">
            <p style="font-size:1.08rem; line-height:1.85;"><?= e($article['body']) ?></p>
            <p style="font-size:1.08rem; line-height:1.85;">The article connects to the wider prototype by explaining how the website promotes services, captures job requirements, stores customer data and helps the administrator review activity through a secure dashboard.</p>
            <div class="actions"><span>Share:</span><button class="btn small secondary" type="button">f</button><button class="btn small secondary" type="button">in</button><button class="btn small secondary" type="button">✉</button></div>
        </article>
        <aside>
            <div class="form-card">
                <h2>Related Articles</h2>
                <?php foreach (array_slice($related, 0, 3) as $item): ?>
                    <div class="activity-item">
                        <img src="<?= e($item['image']) ?>" alt="<?= e($item['title']) ?>">
                        <h3><?= e($item['title']) ?></h3>
                        <a class="btn small" href="article-detail.php?id=<?= e($item['id']) ?>">Read</a>
                    </div>
                <?php endforeach; ?>
                <h3>Categories</h3>
                <div class="actions"><?php foreach (array_unique(array_column(articles(), 'category')) as $category): ?><span class="pill"><?= e($category) ?></span><?php endforeach; ?></div>
            </div>
        </aside>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
