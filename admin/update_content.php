<?php
header('Content-Type: application/json');

require_once '../config/auth.php';
require_once '../config/database.php';

// Check if user is logged in
if (!isLoggedIn()) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

// Get section
$section = $_POST['section'] ?? '';

if (empty($section)) {
    echo json_encode([
        'success' => false,
        'message' => 'Section tidak ditemukan'
    ]);
    exit;
}

// Start transaction
$conn->begin_transaction();

try {
    $updateCount = 0;
    
    // Loop through all POST data except 'section'
    foreach ($_POST as $key => $value) {
        if ($key === 'section') {
            continue;
        }
        
        // Sanitize input
        $value = trim($value);
        
        // Update content in database
        $stmt = $conn->prepare("INSERT INTO site_content (section, key_name, value) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE value = ?");
        $stmt->bind_param("ssss", $section, $key, $value, $value);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $updateCount++;
            }
        }
        
        $stmt->close();
    }
    
    // Commit transaction
    $conn->commit();
    
    // Log activity (optional)
    $admin_username = $_SESSION['admin_username'];
    $log_message = "User '$admin_username' updated $section section";
    error_log($log_message);
    
    echo json_encode([
        'success' => true,
        'message' => "Berhasil menyimpan " . ucfirst($section) . " Section! ($updateCount item diupdate)",
        'section' => $section,
        'updated_count' => $updateCount
    ]);
    
} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();
    
    echo json_encode([
        'success' => false,
        'message' => 'Gagal menyimpan: ' . $e->getMessage()
    ]);
}
?>
