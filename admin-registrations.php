<?php
$pageTitle = 'Admin Registrations | AI-Solutions';
require_once __DIR__ . '/includes/admin_auth.php';
require_once __DIR__ . '/includes/functions.php';
require_admin();
include __DIR__ . '/includes/header.php';
$q = trim($_GET['q'] ?? '');
$rows = [];
if (db_ready()) {
    $sql = 'SELECT er.*, er.event_id FROM event_registrations er';
    if ($q !== '') {
        $stmt = run_query($sql . ' WHERE er.full_name LIKE ? OR er.email LIKE ? OR er.phone LIKE ? ORDER BY er.created_at DESC', ['%'.$q.'%','%'.$q.'%','%'.$q.'%']);
    } else {
        $stmt = run_query($sql . ' ORDER BY er.created_at DESC');
    }
    $rows = $stmt ? $stmt->fetchAll() : [];
}
$eventMap = [];
foreach (events() as $event) { $eventMap[(int)$event['id']] = $event['title']; }
?>
<section class="container admin-shell">
    <?= admin_nav('admin-registrations.php') ?>
    <div>
        <div class="section-title"><div><h1>Event Registrations</h1><p class="section-subtitle">Admin can monitor customers interested in upcoming promotional events.</p></div></div>
        <form class="actions" method="get"><input class="filter-input" style="max-width:420px;" name="q" value="<?= e($q) ?>" placeholder="Search by name, email or phone"><button class="btn" type="submit">Search</button><a class="btn secondary" href="admin-registrations.php">Reset</a></form>
        <div class="table-wrap" style="margin-top:18px;">
            <table>
                <thead><tr><th>Date</th><th>Event</th><th>Name</th><th>Email</th><th>Phone</th></tr></thead>
                <tbody>
                <?php if (!$rows): ?><tr><td colspan="5">No event registrations found.</td></tr><?php endif; ?>
                <?php foreach ($rows as $row): ?>
                    <tr><td><?= e($row['created_at']) ?></td><td><?= e($eventMap[(int)$row['event_id']] ?? 'Event #' . $row['event_id']) ?></td><td><?= e($row['full_name']) ?></td><td><?= e($row['email']) ?></td><td><?= e($row['phone']) ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
