<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? APP_NAME) ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script defer src="assets/js/app.js"></script>
    <script defer src="assets/js/validation.js"></script>
    <script defer src="assets/js/filters.js"></script>
    <script defer src="assets/js/gallery.js"></script>
</head>
<body>
<header class="site-header">
    <a class="brand" href="index.php" aria-label="AI-Solutions home">
        <img src="assets/img/logo.svg" alt="AI-Solutions logo">
        <span>AI-Solutions</span>
    </a>

    <button class="menu-toggle" type="button" aria-label="Open navigation" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>

    <nav class="main-nav" aria-label="Primary navigation">
        <a class="<?= is_active('index.php') ?>" href="index.php">Home</a>
        <a class="<?= is_active('solutions.php') ?>" href="solutions.php">Solutions</a>
        <a class="<?= is_active('articles.php') ?>" href="articles.php">Articles</a>
        <a class="<?= is_active('events.php') ?>" href="events.php">Events</a>
        <a class="<?= is_active('feedback.php') ?>" href="feedback.php">Feedback</a>
        <a class="<?= is_active('contact.php') ?>" href="contact.php">Contact</a>
        <a class="admin-pill <?= is_active('admin-login.php') ?>" href="admin-login.php">Admin</a>
    </nav>

    <div class="site-search" role="search">
        <label class="sr-only" for="globalSearch">Search website</label>
        <input id="globalSearch" type="search" placeholder="Search or type admin..." autocomplete="off">
        <div class="search-help" aria-live="polite"></div>
    </div>
</header>

<main>
<?php if (!db_ready() && current_page() !== 'install.php'): ?>
    <div class="setup-alert" role="status">
        Database is not connected yet. Import <strong>database/ai_solutions.sql</strong> in phpMyAdmin or run <a href="install.php">install.php</a> after placing the folder in XAMPP htdocs.
    </div>
<?php endif; ?>
