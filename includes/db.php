<?php
require_once __DIR__ . '/config.php';

function get_pdo(): ?PDO
{
    static $pdo = null;
    static $attempted = false;

    if ($pdo instanceof PDO) {
        return $pdo;
    }
    // Only try to connect once per request; avoids repeated slow timeouts.
    if ($attempted) {
        return null;
    }
    $attempted = true;

    try {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 5,
        ];
        if (DB_SSL) {
            if (DB_SSL_CA !== '' && is_readable(DB_SSL_CA)) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = DB_SSL_CA;
            } else {
                // Enable TLS without a local CA bundle (common on managed MySQL).
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
            }
        }
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (Throwable $e) {
        return null;
    }
}

function db_ready(): bool
{
    return get_pdo() instanceof PDO;
}

function run_query(string $sql, array $params = []): ?PDOStatement
{
    $pdo = get_pdo();
    if (!$pdo) {
        return null;
    }
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (Throwable $e) {
        // Fail safe: never leak SQL errors to visitors. Callers treat null as "no data".
        error_log('DB query failed: ' . $e->getMessage());
        return null;
    }
}

function count_table(string $table): int
{
    $allowed = ['enquiries', 'event_registrations', 'feedback_reviews', 'activity_logs'];
    if (!in_array($table, $allowed, true)) {
        return 0;
    }
    $stmt = run_query("SELECT COUNT(*) AS total FROM {$table}");
    return $stmt ? (int) $stmt->fetchColumn() : 0;
}

function log_activity(string $message): void
{
    run_query('INSERT INTO activity_logs (message, created_at) VALUES (?, NOW())', [$message]);
}
