<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$event = get_event_by_id($id) ?: events()[0];
$pageTitle = $event['title'] . ' | AI-Solutions Events';
include __DIR__ . '/includes/header.php';
?>
<section class="section">
    <div class="container">
        <div class="breadcrumb"><a href="index.php">Home</a> · <a href="events.php">Events</a> · <?= e($event['title']) ?></div>
        <article class="feature-band">
            <img src="<?= e($event['image']) ?>" alt="<?= e($event['title']) ?>">
            <div>
                <span class="pill"><?= e(ucfirst($event['status'])) ?> · <?= e($event['category']) ?></span>
                <h1><?= e($event['title']) ?></h1>
                <p><?= e($event['summary']) ?></p>
                <div class="grid two">
                    <p class="notice"><strong>Date:</strong> <?= e($event['date']) ?><br><strong>Time:</strong> <?= e($event['time']) ?></p>
                    <p class="notice"><strong>Location:</strong> <?= e($event['location']) ?><br><strong>Category:</strong> <?= e($event['category']) ?></p>
                </div>
                <p>The event will demonstrate software solutions, AI assistant concepts and customer-friendly ways to submit job requirements. It supports the requirement for promotional events and customer registration.</p>
                <?php if ($event['status'] === 'upcoming'): ?>
                    <a class="btn" href="register-event.php?event=<?= e($event['id']) ?>">Register for this event</a>
                <?php else: ?>
                    <span class="pill">Registration closed for past event</span>
                <?php endif; ?>
            </div>
        </article>
        <section class="section">
            <h2>Location Map Placeholder</h2>
            <div class="form-card" style="height:240px; display:grid; place-items:center;">
                <strong><?= e($event['location']) ?></strong>
            </div>
        </section>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
