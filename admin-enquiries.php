<?php
$pageTitle = 'Admin Enquiries | AI-Solutions';
require_once __DIR__ . '/includes/admin_auth.php';
require_once __DIR__ . '/includes/functions.php';
require_admin();
include __DIR__ . '/includes/header.php';
$q = trim($_GET['q'] ?? '');
$rows = [];
if (db_ready()) {
    if ($q !== '') {
        $stmt = run_query('SELECT * FROM enquiries WHERE full_name LIKE ? OR email LIKE ? OR company_name LIKE ? OR country LIKE ? OR job_title LIKE ? ORDER BY created_at DESC', array_fill(0,5,'%'.$q.'%'));
    } else {
        $stmt = run_query('SELECT * FROM enquiries ORDER BY created_at DESC');
    }
    $rows = $stmt ? $stmt->fetchAll() : [];
}
?>
<section class="container admin-shell">
    <?= admin_nav('admin-enquiries.php') ?>
    <div>
        <div class="section-title"><div><h1>Customer Enquiries</h1><p class="section-subtitle">Admin can search and review all Contact Us records stored in the database.</p></div></div>
        <form class="actions" method="get"><input class="filter-input" style="max-width:420px;" name="q" value="<?= e($q) ?>" placeholder="Search by name, email, company, country or job title"><button class="btn" type="submit">Search</button><a class="btn secondary" href="admin-enquiries.php">Reset</a></form>
        <div class="table-wrap" style="margin-top:18px;">
            <table>
                <thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Phone</th><th>Company</th><th>Country</th><th>Job Title</th><th>Details</th></tr></thead>
                <tbody>
                <?php if (!$rows): ?><tr><td colspan="8">No enquiry records found.</td></tr><?php endif; ?>
                <?php foreach ($rows as $row): ?>
                    <tr><td><?= e($row['created_at']) ?></td><td><?= e($row['full_name']) ?></td><td><?= e($row['email']) ?></td><td><?= e($row['phone']) ?></td><td><?= e($row['company_name']) ?></td><td><?= e($row['country']) ?></td><td><?= e($row['job_title']) ?></td><td><?= e($row['job_details']) ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
