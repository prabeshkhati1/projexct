<?php
$pageTitle = 'Solutions / Past Work | AI-Solutions';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
$services = services();
$projects = projects();
$categories = array_unique(array_merge(array_column($services, 'category'), array_column($projects, 'category')));
$reviews = seeded_reviews();
?>
<section class="section" id="past-work">
    <div class="container">
        <div class="section-title">
            <div>
                <h1>Solutions / Past Work</h1>
                <p class="section-subtitle">Search and filter AI-Solutions services and previous project examples. Each detail modal includes overview, benefits, technology tags and a contact call-to-action.</p>
            </div>
            <select class="form-select" data-filter-sort="solutions" aria-label="Sort solutions">
                <option value="newest">Sort: Newest</option>
                <option value="rating">Sort: Top rated</option>
                <option value="oldest">Sort: Oldest</option>
            </select>
        </div>

        <div class="layout-with-sidebar">
            <aside class="sidebar">
                <h3>Filters</h3>
                <label for="solutionSearch" class="sr-only">Search solutions</label>
                <input id="solutionSearch" class="filter-input" data-filter-search="solutions" type="search" placeholder="Search by title or service...">
                <div class="filter-group">
                    <strong>Categories</strong>
                    <?php foreach ($categories as $category): ?>
                        <label><input type="checkbox" data-filter-check="solutions" value="<?= e($category) ?>"> <?= e($category) ?></label>
                    <?php endforeach; ?>
                </div>
                <p class="notice" data-filter-count="solutions">Showing results</p>
            </aside>

            <div>
                <h2>Software Services</h2>
                <div class="grid three" data-filter-container="solutions">
                    <?php foreach ($services as $index => $service): ?>
                        <article class="card" data-filter-card data-title="<?= e($service['title']) ?>" data-category="<?= e($service['category']) ?>" data-rating="5" data-date="2026-06-<?= 20 + $index ?>">
                            <img class="card-image" src="<?= e($service['image']) ?>" alt="<?= e($service['title']) ?>">
                            <div class="card-body">
                                <span class="pill"><?= e($service['category']) ?></span>
                                <h3><?= e($service['title']) ?></h3>
                                <p><?= e($service['summary']) ?></p>
                                <div class="actions">
                                    <button class="btn small" type="button" data-modal-open="service-<?= e($service['id']) ?>">View Details</button>
                                    <a class="btn small secondary" href="contact.php?service=<?= urlencode($service['title']) ?>">Register Interest</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <h2 style="margin-top: 34px;">Previous Projects</h2>
                <div class="grid three" data-filter-container="solutions">
                    <?php foreach ($projects as $index => $project): ?>
                        <article class="card" data-filter-card data-title="<?= e($project['title']) ?>" data-category="<?= e($project['category']) ?>" data-rating="<?= e($project['rating']) ?>" data-date="2026-05-<?= 10 + $index ?>">
                            <img class="card-image" src="<?= e($project['image']) ?>" alt="<?= e($project['title']) ?>">
                            <div class="card-body">
                                <span class="pill"><?= e($project['category']) ?></span>
                                <h3><?= e($project['title']) ?></h3>
                                <p><?= e($project['summary']) ?></p>
                                <p><strong>Client:</strong> <?= e($project['client']) ?></p>
                                <p class="rating"><?= e(star_rating(round($project['rating']))) ?> <span class="pill"><?= e($project['rating']) ?> / 5 · <?= e($project['reviews']) ?> reviews</span></p>
                                <div class="actions">
                                    <button class="btn small" type="button" data-modal-open="project-<?= e($project['id']) ?>">View Details</button>
                                    <a class="btn small secondary" href="#client-feedback">Read Feedback</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="pagination" aria-label="Pagination"><button>‹</button><button class="active">1</button><button>2</button><button>3</button><button>›</button></div>
            </div>
        </div>

        <section class="section" id="client-feedback">
            <div class="section-title">
                <h2>Client Feedback on Past Projects</h2>
                <a class="btn secondary" href="feedback.php">Submit Feedback</a>
            </div>
            <div class="grid three">
                <?php foreach ($reviews as $review): ?>
                    <article class="review-item">
                        <p class="rating"><?= e(star_rating($review['rating'])) ?></p>
                        <h3><?= e($review['subject']) ?></h3>
                        <p><?= e($review['review']) ?></p>
                        <strong>— <?= e($review['name']) ?></strong>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</section>

<?php foreach ($services as $service): ?>
    <div class="solution-modal" id="service-<?= e($service['id']) ?>" aria-hidden="true">
        <div class="modal-card">
            <button class="close-modal" data-modal-close type="button" aria-label="Close">×</button>
            <h2><?= e($service['title']) ?></h2>
            <img class="card-image" src="<?= e($service['image']) ?>" alt="<?= e($service['title']) ?> image">
            <h3>Overview</h3><p><?= e($service['details']) ?></p>
            <h3>Business benefits</h3><ul><?php foreach ($service['benefits'] as $benefit): ?><li><?= e($benefit) ?></li><?php endforeach; ?></ul>
            <h3>Technologies</h3><div class="actions"><?php foreach ($service['technologies'] as $tech): ?><span class="pill"><?= e($tech) ?></span><?php endforeach; ?></div>
            <div class="actions"><a class="btn" href="contact.php?service=<?= urlencode($service['title']) ?>">Contact Us for this service</a><button class="btn secondary" data-modal-close type="button">Close</button></div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($projects as $project): ?>
    <div class="solution-modal" id="project-<?= e($project['id']) ?>" aria-hidden="true">
        <div class="modal-card">
            <button class="close-modal" data-modal-close type="button" aria-label="Close">×</button>
            <h2><?= e($project['title']) ?></h2>
            <img class="card-image" src="<?= e($project['image']) ?>" alt="<?= e($project['title']) ?> image">
            <h3>Project overview</h3>
            <p><?= e($project['summary']) ?> The project demonstrates how AI-Solutions can promote technical solutions to real business users and collect structured feedback for improvement.</p>
            <h3>Technologies</h3>
            <div class="actions"><span class="pill">PHP</span><span class="pill">MySQL</span><span class="pill">JavaScript</span><span class="pill">Responsive UI</span></div>
            <div class="actions"><a class="btn" href="contact.php?project=<?= urlencode($project['title']) ?>">Ask for a similar solution</a><button class="btn secondary" data-modal-close type="button">Close</button></div>
        </div>
    </div>
<?php endforeach; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
