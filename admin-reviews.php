<?php
$pageTitle = 'Admin Review Moderation | AI-Solutions';
require_once __DIR__ . '/includes/admin_auth.php';
require_once __DIR__ . '/includes/functions.php';
require_admin();
$message = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && db_ready()) {
    $id = (int)($_POST['review_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $message = 'Your session expired. Please try again.';
    } elseif ($id > 0 && in_array($action, ['approved', 'rejected'], true)) {
        run_query('UPDATE feedback_reviews SET status = ? WHERE id = ?', [$action, $id]);
        log_activity('Admin marked review #' . $id . ' as ' . $action);
        $message = 'Review updated successfully.';
    }
}
include __DIR__ . '/includes/header.php';
$status = $_GET['status'] ?? 'all';
$rows = [];
if (db_ready()) {
    if (in_array($status, ['pending','approved','rejected'], true)) {
        $stmt = run_query('SELECT * FROM feedback_reviews WHERE status = ? ORDER BY created_at DESC', [$status]);
    } else {
        $stmt = run_query('SELECT * FROM feedback_reviews ORDER BY created_at DESC');
    }
    $rows = $stmt ? $stmt->fetchAll() : [];
}
?>
<section class="container admin-shell">
    <?= admin_nav('admin-reviews.php') ?>
    <div>
        <div class="section-title"><div><h1>Review Moderation</h1><p class="section-subtitle">Admin can approve or reject customer reviews before they are displayed publicly.</p></div></div>
        <?php if ($message): ?><div class="form-success"><?= e($message) ?></div><?php endif; ?>
        <div class="actions"><a class="btn secondary" href="admin-reviews.php?status=all">All</a><a class="btn secondary" href="admin-reviews.php?status=pending">Pending</a><a class="btn secondary" href="admin-reviews.php?status=approved">Approved</a><a class="btn secondary" href="admin-reviews.php?status=rejected">Rejected</a></div>
        <div class="table-wrap" style="margin-top:18px;">
            <table>
                <thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Subject</th><th>Rating</th><th>Review</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                <?php if (!$rows): ?><tr><td colspan="8">No reviews found.</td></tr><?php endif; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= e($row['created_at']) ?></td><td><?= e($row['full_name']) ?></td><td><?= e($row['email']) ?></td><td><?= e($row['subject']) ?></td><td class="rating"><?= e(star_rating($row['rating'])) ?></td><td><?= e($row['review']) ?></td><td><span class="status <?= e($row['status']) ?>"><?= e($row['status']) ?></span></td>
                        <td>
                            <form method="post" class="actions" style="margin:0;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="review_id" value="<?= e($row['id']) ?>">
                                <button class="btn small" type="submit" name="action" value="approved">Approve</button>
                                <button class="btn small danger" type="submit" name="action" value="rejected">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
