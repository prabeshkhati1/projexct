<?php
$pageTitle = 'Install Database | AI-Solutions';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$messages = [];
$ok = false;
if (DISABLE_INSTALL) {
    $messages[] = 'The installer is disabled (DISABLE_INSTALL=1). Import database/ai_solutions.sql manually instead.';
    include __DIR__ . '/includes/header.php';
    echo '<section class="section"><div class="container" style="max-width:760px;"><div class="form-card"><h1>Installer disabled</h1><p class="form-errors" style="display:block;">' . e($messages[0]) . '</p></div></div></section>';
    include __DIR__ . '/includes/footer.php';
    return;
}
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $pdo->exec('USE `' . DB_NAME . '`');
    $statements = [
        "CREATE TABLE IF NOT EXISTS enquiries (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(80) NOT NULL,
            email VARCHAR(120) NOT NULL,
            phone VARCHAR(10) NOT NULL,
            company_name VARCHAR(100) NOT NULL,
            country VARCHAR(80) NOT NULL,
            job_title VARCHAR(80) NOT NULL,
            job_details TEXT NOT NULL,
            created_at DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        "CREATE TABLE IF NOT EXISTS event_registrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            event_id INT NOT NULL,
            full_name VARCHAR(80) NOT NULL,
            email VARCHAR(120) NOT NULL,
            phone VARCHAR(10) NOT NULL,
            created_at DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        "CREATE TABLE IF NOT EXISTS feedback_reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(80) NOT NULL,
            email VARCHAR(120) NOT NULL,
            subject VARCHAR(120) NOT NULL,
            rating TINYINT NOT NULL,
            review TEXT NOT NULL,
            status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
            created_at DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        "CREATE TABLE IF NOT EXISTS admin_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            created_at DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        "CREATE TABLE IF NOT EXISTS activity_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            message VARCHAR(255) NOT NULL,
            created_at DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    ];
    foreach ($statements as $sql) { $pdo->exec($sql); }
    $adminHash = password_hash(ADMIN_PASSWORD, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT IGNORE INTO admin_users (username, password_hash, created_at) VALUES (?, ?, NOW())');
    $stmt->execute([ADMIN_USERNAME, $adminHash]);
    $pdo->exec("INSERT INTO activity_logs (message, created_at) SELECT 'Database installed successfully', NOW() WHERE NOT EXISTS (SELECT 1 FROM activity_logs WHERE message = 'Database installed successfully')");
    $ok = true;
    $messages[] = 'Database and all required tables are ready.';
} catch (Throwable $e) {
    $messages[] = 'Installation failed: ' . $e->getMessage();
}
include __DIR__ . '/includes/header.php';
?>
<section class="section">
    <div class="container" style="max-width:760px;">
        <div class="form-card">
            <h1>AI-Solutions Database Install</h1>
            <?php foreach ($messages as $message): ?><p class="<?= $ok ? 'form-success' : 'form-errors' ?>" style="display:block;"><?= e($message) ?></p><?php endforeach; ?>
            <p>This installer creates the <strong><?= e(DB_NAME) ?></strong> MySQL database for XAMPP and adds tables for contact enquiries, event registrations, feedback reviews, admin users and activity logs.</p>
            <div class="actions"><a class="btn" href="index.php">Go to Website</a><a class="btn secondary" href="admin-login.php">Admin Login</a></div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
