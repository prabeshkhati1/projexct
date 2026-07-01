<?php
$pageTitle = 'Events & Gallery | AI-Solutions';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
$events = events();
$upcoming = array_values(array_filter($events, fn($event) => $event['status'] === 'upcoming'));
$past = array_values(array_filter($events, fn($event) => $event['status'] === 'past'));
$categories = array_unique(array_column($events, 'category'));
?>
<section class="section">
    <div class="container">
        <div class="section-title">
            <div>
                <h1>Events & Gallery</h1>
                <p class="section-subtitle">Upcoming promotional events are open for registration. Past events remain viewable, but registration is disabled.</p>
            </div>
        </div>

        <div class="tabs" role="tablist">
            <button class="tab-btn active" data-tab="upcoming-panel" type="button">Upcoming Events</button>
            <button class="tab-btn" data-tab="past-panel" type="button">Past Events</button>
            <button class="tab-btn" data-tab="gallery-panel" type="button">Photo Gallery</button>
        </div>

        <div class="tab-panel active" id="upcoming-panel">
            <div class="layout-with-sidebar">
                <aside class="sidebar">
                    <h3>Event Filters</h3>
                    <input class="filter-input" data-filter-search="events-upcoming" type="search" placeholder="Search upcoming events..." aria-label="Search upcoming events">
                    <div class="filter-group">
                        <?php foreach ($categories as $category): ?><label><input type="checkbox" data-filter-check="events-upcoming" value="<?= e($category) ?>"> <?= e($category) ?></label><?php endforeach; ?>
                    </div>
                    <p class="notice" data-filter-count="events-upcoming">Showing upcoming events</p>
                </aside>
                <div class="grid three" data-filter-container="events-upcoming">
                    <?php foreach ($upcoming as $event): ?>
                        <article class="card" data-filter-card data-title="<?= e($event['title']) ?>" data-category="<?= e($event['category']) ?>" data-date="<?= e($event['date']) ?>">
                            <img class="card-image" src="<?= e($event['image']) ?>" alt="<?= e($event['title']) ?>">
                            <div class="card-body">
                                <span class="pill"><?= e($event['date']) ?> · <?= e($event['time']) ?></span>
                                <h3><?= e($event['title']) ?></h3>
                                <p><?= e($event['summary']) ?></p>
                                <p><strong>Location:</strong> <?= e($event['location']) ?></p>
                                <div class="actions"><a class="btn small" href="event-detail.php?id=<?= e($event['id']) ?>">View Details</a><a class="btn small secondary" href="register-event.php?event=<?= e($event['id']) ?>">Register</a></div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="tab-panel" id="past-panel">
            <div class="layout-with-sidebar">
                <aside class="sidebar">
                    <h3>Past Event Filters</h3>
                    <input class="filter-input" data-filter-search="events-past" type="search" placeholder="Search past events..." aria-label="Search past events">
                    <p class="notice" data-filter-count="events-past">Showing past events</p>
                </aside>
                <div class="grid three" data-filter-container="events-past">
                    <?php foreach ($past as $event): ?>
                        <article class="card" data-filter-card data-title="<?= e($event['title']) ?>" data-category="<?= e($event['category']) ?>" data-date="<?= e($event['date']) ?>">
                            <img class="card-image" src="<?= e($event['image']) ?>" alt="<?= e($event['title']) ?>">
                            <div class="card-body">
                                <span class="pill">Past event · <?= e($event['date']) ?></span>
                                <h3><?= e($event['title']) ?></h3>
                                <p><?= e($event['summary']) ?></p>
                                <p class="notice">Registration closed because this event has already finished.</p>
                                <a class="btn small secondary" href="event-detail.php?id=<?= e($event['id']) ?>">View Details</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="tab-panel" id="gallery-panel">
            <p class="notice">Click any image to open the zoomable gallery preview.</p>
            <div class="gallery-grid">
                <?php foreach (gallery_images() as $item): ?>
                    <button class="gallery-item" type="button" data-image="<?= e($item['image']) ?>" data-title="<?= e($item['title']) ?>">
                        <img src="<?= e($item['image']) ?>" alt="<?= e($item['title']) ?>">
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<div class="lightbox" aria-hidden="true">
    <div class="lightbox-inner">
        <button class="close-lightbox" type="button" aria-label="Close gallery preview">×</button>
        <img src="assets/img/gallery-1.svg" alt="Gallery preview">
        <h3 class="lightbox-caption">Gallery image</h3>
        <p class="notice">Click the image to zoom in or zoom out.</p>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
