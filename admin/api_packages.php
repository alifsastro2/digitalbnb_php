<?php
require_once '../config/auth.php';
require_once '../config/database.php';

requireLogin();

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'get':
        $id = $_GET['id'] ?? 0;
        $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            echo json_encode(['success' => true, 'data' => $row]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Paket tidak ditemukan']);
        }
        break;
        
    case 'create':
        $package_name = $_POST['package_name'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';
        $features = $_POST['features'] ?? '';
        $is_popular = $_POST['is_popular'] ?? 0;
        $display_order = $_POST['display_order'] ?? 0;
        $is_active = $_POST['is_active'] ?? 1;
        
        $stmt = $conn->prepare("INSERT INTO packages (package_name, price, description, features, is_popular, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiii", $package_name, $price, $description, $features, $is_popular, $display_order, $is_active);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Paket berhasil ditambahkan']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan paket']);
        }
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $package_name = $_POST['package_name'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';
        $features = $_POST['features'] ?? '';
        $is_popular = $_POST['is_popular'] ?? 0;
        $display_order = $_POST['display_order'] ?? 0;
        $is_active = $_POST['is_active'] ?? 1;
        
        $stmt = $conn->prepare("UPDATE packages SET package_name=?, price=?, description=?, features=?, is_popular=?, display_order=?, is_active=? WHERE id=?");
        $stmt->bind_param("ssssiiii", $package_name, $price, $description, $features, $is_popular, $display_order, $is_active, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Paket berhasil diupdate']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate paket']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;
        $stmt = $conn->prepare("DELETE FROM packages WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Paket berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus paket']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Action tidak valid']);
        break;
}

$conn->close();
?>
