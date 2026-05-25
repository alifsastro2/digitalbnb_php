<?php
// ─── Supabase PostgreSQL — PDO Connection ──────────────────────
define('DB_HOST', 'db.grdhinkbclhepunerimb.supabase.co');
define('DB_PORT', '5432');
define('DB_NAME', 'postgres');
define('DB_USER', 'postgres');
define('DB_PASS', 'digitalbnb-2026');

try {
    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s;sslmode=require',
        DB_HOST, DB_PORT, DB_NAME
    );
    $conn = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die('Database connection failed. Cek kredensial di config/database.php');
}

function getContent(string $section, string $key): string {
    global $conn;
    $stmt = $conn->prepare("SELECT value FROM site_content WHERE section = ? AND key_name = ?");
    $stmt->execute([$section, $key]);
    $row = $stmt->fetch();
    return $row ? $row['value'] : '';
}

function updateContent(string $section, string $key, string $value): bool {
    global $conn;
    $stmt = $conn->prepare("UPDATE site_content SET value = ? WHERE section = ? AND key_name = ?");
    return $stmt->execute([$value, $section, $key]);
}
