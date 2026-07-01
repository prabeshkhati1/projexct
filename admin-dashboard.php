<?php
$pageTitle = 'Admin Dashboard | AI-Solutions';
require_once __DIR__ . '/includes/admin_auth.php';
require_once __DIR__ . '/includes/functions.php';
require_admin();
include __DIR__ . '/includes/header.php';
$enquiries = count_table('enquiries');
$registrations = count_table('event_registrations');
$reviews = count_table('feedback_reviews');
$activities = [];
if (db_ready()) {
    $stmt = run_query('SELECT message, created_at FROM activity_logs ORDER BY created_at DESC LIMIT 6');
    $activities = $stmt ? $stmt->fetchAll() : [];
}
?>
<section class="container admin-shell">
    <?= admin_nav('admin-dashboard.php') ?>
    <div>
        <div class="section-title">
            <div><h1>Admin Dashboard</h1><p class="section-subtitle">KPI cards, quick actions, recent activity and data overview for customer demand analysis.</p></div>
        </div>
        <div class="kpi-grid">
            <div class="kpi"><span>Customer enquiries</span><strong><?= e($enquiries) ?></strong></div>
            <div class="kpi"><span>Event registrations</span><strong><?= e($registrations) ?></strong></div>
            <div class="kpi"><span>Total reviews</span><strong><?= e($reviews) ?></strong></div>
            <div class="kpi"><span>Approved reviews</span><strong><?php if (db_ready()) { $stmt=run_query("SELECT COUNT(*) FROM feedback_reviews WHERE status='approved'"); echo e($stmt ? $stmt->fetchColumn() : 0); } else { echo '0'; } ?></strong></div>
        </div>

        <section class="section">
            <div class="grid two">
                <div class="form-card">
                    <h2>Mini Engagement Chart</h2>
                    <div class="chart-box" aria-label="Simple engagement chart">
                        <?php $bars = [$enquiries, $registrations, $reviews, max(1, $enquiries + $registrations)]; $max = max(1, ...$bars); foreach ($bars as $bar): $h = 30 + (int)(160 * ($bar / $max)); ?>
                            <div class="bar" style="height:<?= $h ?>px"><span><?= e($bar) ?></span></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="form-card">
                    <h2>Quick Actions</h2>
                    <div class="actions">
                        <a class="btn" href="admin-enquiries.php">View Enquiries</a>
                        <a class="btn secondary" href="admin-registrations.php">View Registrations</a>
                        <a class="btn secondary" href="admin-reviews.php">Moderate Reviews</a>
                    </div>
                    <p class="notice">All admin pages require login. If the user logs out or tries to access a page directly, the login page appears again.</p>
                </div>
            </div>
        </section>

        <section>
            <h2>Recent Activity</h2>
            <?php if (!$activities): ?><p class="notice">No activity yet. Submit a contact form, event registration or review to populate this area.</p><?php endif; ?>
            <?php foreach ($activities as $activity): ?>
                <div class="activity-item"><strong><?= e($activity['message']) ?></strong><br><span class="section-subtitle"><?= e($activity['created_at']) ?></span></div>
            <?php endforeach; ?>
        </section>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
