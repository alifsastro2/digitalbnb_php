<?php
require_once '../config/auth.php';
require_once '../config/database.php';

requireLogin();

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'get':
        $id = $_GET['id'] ?? 0;
        $stmt = $conn->prepare("SELECT * FROM faq WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            echo json_encode(['success' => true, 'data' => $row]);
        } else {
            echo json_encode(['success' => false, 'message' => 'FAQ tidak ditemukan']);
        }
        break;
        
    case 'create':
        $question = $_POST['question'] ?? '';
        $answer = $_POST['answer'] ?? '';
        $category = $_POST['category'] ?? 'General';
        $display_order = $_POST['display_order'] ?? 0;
        $is_active = $_POST['is_active'] ?? 1;
        
        $stmt = $conn->prepare("INSERT INTO faq (question, answer, category, display_order, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $question, $answer, $category, $display_order, $is_active);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'FAQ berhasil ditambahkan']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan FAQ']);
        }
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $question = $_POST['question'] ?? '';
        $answer = $_POST['answer'] ?? '';
        $category = $_POST['category'] ?? 'General';
        $display_order = $_POST['display_order'] ?? 0;
        $is_active = $_POST['is_active'] ?? 1;
        
        $stmt = $conn->prepare("UPDATE faq SET question=?, answer=?, category=?, display_order=?, is_active=? WHERE id=?");
        $stmt->bind_param("sssiii", $question, $answer, $category, $display_order, $is_active, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'FAQ berhasil diupdate']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate FAQ']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;
        $stmt = $conn->prepare("DELETE FROM faq WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'FAQ berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus FAQ']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Action tidak valid']);
        break;
}

$conn->close();
?>
