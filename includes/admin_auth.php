<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

function require_admin(): void
{
    if (empty($_SESSION['admin_logged_in'])) {
        header('Location: admin-login.php?required=1');
        exit;
    }
}

function admin_login(string $username, string $password): bool
{
    $success = false;

    // 1) Demo credentials from configuration (works even before the DB is set up).
    if (hash_equals(ADMIN_USERNAME, $username) && hash_equals(ADMIN_PASSWORD, $password)) {
        $success = true;
    }

    // 2) Database-backed admin accounts (supports bcrypt or legacy SHA-256 hashes).
    if (!$success && db_ready()) {
        $stmt = run_query('SELECT * FROM admin_users WHERE username = ? LIMIT 1', [$username]);
        $admin = $stmt ? $stmt->fetch() : null;
        if ($admin && !empty($admin['password_hash'])) {
            $stored = (string) $admin['password_hash'];
            if (str_starts_with($stored, '$2y$') || str_starts_with($stored, '$argon')) {
                $success = password_verify($password, $stored);
            } else {
                // Legacy SHA-256 fallback.
                $success = hash_equals($stored, hash('sha256', $password));
            }
        }
    }

    if ($success) {
        // Prevent session fixation.
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['login_time'] = time();
        $_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
        log_activity('Admin logged in');
        return true;
    }
    return false;
}

/**
 * Return the current CSRF token, creating one if needed.
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Hidden input markup for embedding the CSRF token in a form.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Validate a submitted CSRF token against the session token.
 */
function csrf_verify(?string $token): bool
{
    return !empty($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

function admin_nav(string $active = ''): string
{
    $items = [
        'admin-dashboard.php' => 'Dashboard',
        'admin-enquiries.php' => 'Customer Enquiries',
        'admin-registrations.php' => 'Event Registrations',
        'admin-reviews.php' => 'Review Moderation',
        'admin-logout.php' => 'Logout'
    ];
    $html = '<aside class="admin-sidebar"><h2>Admin Area</h2><p>Protected dashboard</p>';
    foreach ($items as $href => $label) {
        $class = $href === $active ? 'active' : '';
        $html .= '<a class="' . $class . '" href="' . $href . '">' . $label . '</a>';
    }
    return $html . '</aside>';
}
