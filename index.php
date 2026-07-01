<?php
$pageTitle = 'AI-Solutions | Home';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
$services = array_slice(services(), 0, 3);
$projects = array_slice(projects(), 0, 3);
$articles = array_slice(articles(), 0, 3);
$events = array_values(array_filter(events(), fn($event) => $event['status'] === 'upcoming'));
$events = array_slice($events, 0, 3);
$reviews = seeded_reviews();
if (db_ready()) {
    $stmt = run_query("SELECT full_name AS name, subject, rating, review FROM feedback_reviews WHERE status = 'approved' ORDER BY created_at DESC LIMIT 3");
    $dbReviews = $stmt ? $stmt->fetchAll() : [];
    if ($dbReviews) { $reviews = $dbReviews; }
}
?>
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-card">
            <span class="pill">AI-powered software start-up based in Sunderland</span>
            <h1>Smart software solutions for modern businesses.</h1>
            <p>AI-Solutions promotes AI virtual assistants, automation systems, analytics dashboards and affordable prototypes. Customers can view services, read articles, register for events, submit feedback and send job requirements through validated online forms.</p>
            <div class="hero-actions">
                <a class="btn" href="solutions.php">Explore Solutions</a>
                <a class="btn secondary" href="contact.php">Contact Us</a>
            </div>
        </div>
        <img class="card" src="assets/img/hero.svg" alt="AI-Solutions hero illustration">
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-title">
            <div>
                <h2>Our Services</h2>
                <p class="section-subtitle">Main software solutions offered to clients, matching the required company service showcase.</p>
            </div>
            <a class="btn secondary" href="solutions.php">View All →</a>
        </div>
        <div class="grid three">
            <?php foreach ($services as $service): ?>
                <article class="card">
                    <img class="card-image" src="<?= e($service['image']) ?>" alt="<?= e($service['title']) ?>">
                    <div class="card-body">
                        <span class="pill"><?= e($service['category']) ?></span>
                        <h3><?= e($service['title']) ?></h3>
                        <p><?= e($service['summary']) ?></p>
                        <button class="btn small" type="button" data-modal-open="service-<?= e($service['id']) ?>">Learn More</button>
                    </div>
                </article>
                <div class="solution-modal" id="service-<?= e($service['id']) ?>" aria-hidden="true">
                    <div class="modal-card">
                        <button class="close-modal" data-modal-close type="button" aria-label="Close">×</button>
                        <h2><?= e($service['title']) ?></h2>
                        <img class="card-image" src="<?= e($service['image']) ?>" alt="<?= e($service['title']) ?> detail image">
                        <h3>Overview</h3>
                        <p><?= e($service['details']) ?></p>
                        <h3>Business benefits</h3>
                        <ul><?php foreach ($service['benefits'] as $benefit): ?><li><?= e($benefit) ?></li><?php endforeach; ?></ul>
                        <h3>Technologies</h3>
                        <div class="actions"><?php foreach ($service['technologies'] as $tech): ?><span class="pill"><?= e($tech) ?></span><?php endforeach; ?></div>
                        <div class="actions"><a class="btn" href="contact.php?service=<?= urlencode($service['title']) ?>">Contact Us for this service</a></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-title">
            <div>
                <h2>Featured Past Work</h2>
                <p class="section-subtitle">Examples of past software solutions delivered to industries.</p>
            </div>
            <a class="btn secondary" href="solutions.php#past-work">View All →</a>
        </div>
        <div class="grid three">
            <?php foreach ($projects as $project): ?>
                <article class="card">
                    <img class="card-image" src="<?= e($project['image']) ?>" alt="<?= e($project['title']) ?>">
                    <div class="card-body">
                        <span class="pill"><?= e($project['category']) ?></span>
                        <h3><?= e($project['title']) ?></h3>
                        <p><?= e($project['summary']) ?></p>
                        <p class="rating"><?= e(star_rating(round($project['rating']))) ?> <span class="pill"><?= e($project['rating']) ?> / 5</span></p>
                        <a class="btn small" href="solutions.php#past-work">View Case</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-title">
            <div>
                <h2>Upcoming Events</h2>
                <p class="section-subtitle">Customers can view promotional events and register online.</p>
            </div>
            <a class="btn secondary" href="events.php">View Events →</a>
        </div>
        <div class="grid three">
            <?php foreach ($events as $event): ?>
                <article class="card">
                    <img class="card-image" src="<?= e($event['image']) ?>" alt="<?= e($event['title']) ?>">
                    <div class="card-body">
                        <span class="pill"><?= e($event['date']) ?> · <?= e($event['time']) ?></span>
                        <h3><?= e($event['title']) ?></h3>
                        <p><?= e($event['summary']) ?></p>
                        <div class="actions"><a class="btn small" href="event-detail.php?id=<?= e($event['id']) ?>">View Details</a><a class="btn small secondary" href="register-event.php?event=<?= e($event['id']) ?>">Register</a></div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-title">
            <div>
                <h2>Latest Articles</h2>
                <p class="section-subtitle">Promotional articles explaining AI services, prototyping and business automation.</p>
            </div>
            <a class="btn secondary" href="articles.php">View Articles →</a>
        </div>
        <div class="grid three">
            <?php foreach ($articles as $article): ?>
                <article class="card">
                    <img class="card-image" src="<?= e($article['image']) ?>" alt="<?= e($article['title']) ?>">
                    <div class="card-body">
                        <span class="pill"><?= e($article['category']) ?></span>
                        <h3><?= e($article['title']) ?></h3>
                        <p><?= e($article['summary']) ?></p>
                        <a class="btn small" href="article-detail.php?id=<?= e($article['id']) ?>">Read More</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-title">
            <div>
                <h2>Customer Feedback</h2>
                <p class="section-subtitle">Approved customer feedback with star ratings.</p>
            </div>
            <a class="btn secondary" href="feedback.php">Leave Feedback →</a>
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
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
