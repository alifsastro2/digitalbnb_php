<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Sesuaikan dengan username phpMyAdmin Anda
define('DB_PASS', '');      // Sesuaikan dengan password phpMyAdmin Anda
define('DB_NAME', 'diga1463_digital_bnb');

// Create connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to UTF-8
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// Function untuk get content dari database
function getContent($section, $key) {
    global $conn;
    $stmt = $conn->prepare("SELECT value FROM site_content WHERE section = ? AND key_name = ?");
    $stmt->bind_param("ss", $section, $key);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row['value'];
    }
    return '';
}

// Function untuk update content
function updateContent($section, $key, $value) {
    global $conn;
    $stmt = $conn->prepare("UPDATE site_content SET value = ? WHERE section = ? AND key_name = ?");
    $stmt->bind_param("sss", $value, $section, $key);
    return $stmt->execute();
}
?>
