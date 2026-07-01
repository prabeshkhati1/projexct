<?php
$pageTitle = 'Admin Login | AI-Solutions';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/admin_auth.php';
$error = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $error = 'Your session expired. Please try logging in again.';
    } elseif ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } elseif (admin_login($username, $password)) {
        header('Location: admin-dashboard.php');
        exit;
    } else {
        $error = 'Invalid admin credentials. Please check the username and password.';
    }
}
include __DIR__ . '/includes/header.php';
?>
<section class="section">
    <div class="container" style="max-width:620px;">
        <form class="form-card" method="post" data-live-validation novalidate>
            <?= csrf_field() ?>
            <h1>Admin Login</h1>
            <p class="section-subtitle">Password-protected area for reviewing enquiries, event registrations and customer reviews.</p>
            <?php if (isset($_GET['required'])): ?><div class="form-errors" style="display:block;">Please login before accessing the admin dashboard.</div><?php endif; ?>
            <?php if ($error): ?><div class="form-errors" style="display:block;"><?= e($error) ?></div><?php endif; ?>
            <div class="form-group">
                <label for="username">Username <span class="required">*</span></label>
                <input class="form-control" id="username" name="username" data-label="Username" data-validate="required|min:3|max:30" autocomplete="username">
                <div class="field-errors"></div>
            </div>
            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input class="form-control" type="password" id="password" name="password" data-label="Password" data-validate="required|min:6|max:50" autocomplete="current-password">
                <div class="field-errors"></div>
            </div>
            <label><input type="checkbox" name="remember"> Remember me on this browser</label>
            <div class="actions"><button class="btn" type="submit">Login</button><a class="btn secondary" href="index.php">Back to website</a></div>
            <p class="notice"><strong>Demo credentials:</strong> username <strong>admin</strong>, password <strong>Admin@123</strong>. Change these for real deployment.</p>
        </form>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
