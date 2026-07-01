<?php
// AI-Solutions CET333 prototype configuration.
//
// Values are read from environment variables so the same code runs on:
//   - XAMPP / localhost (uses the defaults below)
//   - GitHub + a hosting platform (Vercel, Railway, Render, InfinityFree, ...)
//     where you set the variables in a .env file or the host dashboard.
//
// Nothing sensitive is hard-coded. Copy .env.example to .env and adjust it,
// or leave everything blank to use the XAMPP defaults.

/**
 * Minimal .env loader (no external dependency).
 * Only fills variables that are not already provided by the real environment.
 */
(static function (): void {
    $envFile = __DIR__ . '/../.env';
    if (!is_readable($envFile)) {
        return;
    }
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }
        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }
        $key = trim($parts[0]);
        $value = trim($parts[1]);
        // Strip surrounding quotes if present.
        if (strlen($value) >= 2 && ($value[0] === '"' || $value[0] === "'")) {
            $value = substr($value, 1, -1);
        }
        if ($key !== '' && getenv($key) === false && !isset($_ENV[$key]) && !isset($_SERVER[$key])) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
})();

/**
 * Read an environment value with a fallback default.
 */
function env_val(string $key, string $default = ''): string
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? $default;
    }
    return (string) $value;
}

// Database connection (XAMPP defaults: host=localhost, user=root, blank password).
define('DB_HOST', env_val('DB_HOST', 'localhost'));
define('DB_PORT', env_val('DB_PORT', '3306'));
define('DB_NAME', env_val('DB_NAME', 'ai_solutions'));
define('DB_USER', env_val('DB_USER', 'root'));
define('DB_PASS', env_val('DB_PASS', ''));
// Set DB_SSL=1 for managed MySQL providers that require TLS (Aiven, PlanetScale, etc.).
define('DB_SSL', env_val('DB_SSL', '0') === '1');
define('DB_SSL_CA', env_val('DB_SSL_CA', ''));

// Application / admin settings.
define('APP_NAME', env_val('APP_NAME', 'AI-Solutions'));
define('ADMIN_USERNAME', env_val('ADMIN_USERNAME', 'admin'));
define('ADMIN_PASSWORD', env_val('ADMIN_PASSWORD', 'Admin@123'));
// Set DISABLE_INSTALL=1 in production so install.php cannot be run publicly.
define('DISABLE_INSTALL', env_val('DISABLE_INSTALL', '0') === '1');
