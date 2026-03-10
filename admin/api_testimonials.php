<?php
require_once '../config/auth.php';
require_once '../config/database.php';

requireLogin();

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'get':
        $id = $_GET['id'] ?? 0;
        $stmt = $conn->prepare("SELECT * FROM testimonials WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            echo json_encode(['success' => true, 'data' => $row]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Testimonial tidak ditemukan']);
        }
        break;
        
    case 'create':
        $client_name = $_POST['client_name'] ?? '';
        $client_position = $_POST['client_position'] ?? '';
        $client_company = $_POST['client_company'] ?? '';
        $testimonial = $_POST['testimonial'] ?? '';
        $rating = $_POST['rating'] ?? 5;
        $avatar_url = $_POST['avatar_url'] ?? '';
        $display_order = $_POST['display_order'] ?? 0;
        $is_active = $_POST['is_active'] ?? 1;
        
        $stmt = $conn->prepare("INSERT INTO testimonials (client_name, client_position, client_company, testimonial, rating, avatar_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisii", $client_name, $client_position, $client_company, $testimonial, $rating, $avatar_url, $display_order, $is_active);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Testimonial berhasil ditambahkan']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan testimonial']);
        }
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $client_name = $_POST['client_name'] ?? '';
        $client_position = $_POST['client_position'] ?? '';
        $client_company = $_POST['client_company'] ?? '';
        $testimonial = $_POST['testimonial'] ?? '';
        $rating = $_POST['rating'] ?? 5;
        $avatar_url = $_POST['avatar_url'] ?? '';
        $display_order = $_POST['display_order'] ?? 0;
        $is_active = $_POST['is_active'] ?? 1;
        
        $stmt = $conn->prepare("UPDATE testimonials SET client_name=?, client_position=?, client_company=?, testimonial=?, rating=?, avatar_url=?, display_order=?, is_active=? WHERE id=?");
        $stmt->bind_param("ssssisiii", $client_name, $client_position, $client_company, $testimonial, $rating, $avatar_url, $display_order, $is_active, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Testimonial berhasil diupdate']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate testimonial']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;

        // Ambil avatar_url dulu sebelum dihapus
        $sel = $conn->prepare("SELECT avatar_url FROM testimonials WHERE id = ?");
        $sel->bind_param("i", $id);
        $sel->execute();
        $sel_result = $sel->get_result();
        $old_row = $sel_result->fetch_assoc();

        $stmt = $conn->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Hapus file fisik jika bukan URL eksternal
            if ($old_row && !empty($old_row['avatar_url']) && !str_starts_with($old_row['avatar_url'], 'http')) {
                $file_path = '../' . $old_row['avatar_url'];
                if (file_exists($file_path)) unlink($file_path);
            }
            echo json_encode(['success' => true, 'message' => 'Testimonial berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus testimonial']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Action tidak valid']);
        break;
}

$conn->close();
?>
