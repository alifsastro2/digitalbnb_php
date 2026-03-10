<?php
require_once '../config/auth.php';
require_once '../config/database.php';

requireLogin();

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'get':
        $id = $_GET['id'] ?? 0;
        $stmt = $conn->prepare("SELECT * FROM portfolio WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            echo json_encode(['success' => true, 'data' => $row]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Portfolio tidak ditemukan']);
        }
        break;
        
    case 'create':
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $description = $_POST['description'] ?? '';
        $image_url = $_POST['image_url'] ?? '';
        $client_name = $_POST['client_name'] ?? '';
        $project_url = $_POST['project_url'] ?? '';
        $display_order = $_POST['display_order'] ?? 0;
        $is_active = $_POST['is_active'] ?? 1;
        
        $stmt = $conn->prepare("INSERT INTO portfolio (title, category, description, image_url, client_name, project_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssii", $title, $category, $description, $image_url, $client_name, $project_url, $display_order, $is_active);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Portfolio berhasil ditambahkan']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan portfolio']);
        }
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $description = $_POST['description'] ?? '';
        $image_url = $_POST['image_url'] ?? '';
        $client_name = $_POST['client_name'] ?? '';
        $project_url = $_POST['project_url'] ?? '';
        $display_order = $_POST['display_order'] ?? 0;
        $is_active = $_POST['is_active'] ?? 1;
        
        $stmt = $conn->prepare("UPDATE portfolio SET title=?, category=?, description=?, image_url=?, client_name=?, project_url=?, display_order=?, is_active=? WHERE id=?");
        $stmt->bind_param("ssssssiii", $title, $category, $description, $image_url, $client_name, $project_url, $display_order, $is_active, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Portfolio berhasil diupdate']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate portfolio']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;

        // Ambil image_url dulu sebelum dihapus
        $sel = $conn->prepare("SELECT image_url FROM portfolio WHERE id = ?");
        $sel->bind_param("i", $id);
        $sel->execute();
        $sel_result = $sel->get_result();
        $old_row = $sel_result->fetch_assoc();

        $stmt = $conn->prepare("DELETE FROM portfolio WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Hapus file fisik jika bukan URL eksternal
            if ($old_row && !empty($old_row['image_url']) && !str_starts_with($old_row['image_url'], 'http')) {
                $file_path = '../' . $old_row['image_url'];
                if (file_exists($file_path)) unlink($file_path);
            }
            echo json_encode(['success' => true, 'message' => 'Portfolio berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus portfolio']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Action tidak valid']);
        break;
}

$conn->close();
?>
