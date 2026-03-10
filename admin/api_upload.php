<?php
require_once '../config/auth.php';
require_once '../config/database.php';

requireLogin();

header('Content-Type: application/json');

// Folder mapping
$allowed_folders = [
    'profil_testimoni'  => '../uploads/profil_testimoni/',
    'logo_perusahaan'   => '../uploads/logo_perusahaan/',
    'portfolio'         => '../uploads/portfolio/',
];

$folder_key = $_POST['folder'] ?? '';

if (!array_key_exists($folder_key, $allowed_folders)) {
    echo json_encode(['success' => false, 'message' => 'Folder tidak valid']);
    exit;
}

$upload_dir = $allowed_folders[$folder_key];

// Buat folder jika belum ada
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Ambil data base64 dari cropper
$image_data = $_POST['image_data'] ?? '';

if (empty($image_data)) {
    echo json_encode(['success' => false, 'message' => 'Data gambar kosong']);
    exit;
}

// Decode base64
if (preg_match('/^data:image\/(\w+);base64,/', $image_data, $type)) {
    $image_data = substr($image_data, strpos($image_data, ',') + 1);
    $ext = strtolower($type[1]);

    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
        echo json_encode(['success' => false, 'message' => 'Format gambar tidak didukung. Gunakan JPG, PNG, atau WEBP']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Format data gambar tidak valid']);
    exit;
}

$image_data = base64_decode($image_data);

if ($image_data === false) {
    echo json_encode(['success' => false, 'message' => 'Gagal decode gambar']);
    exit;
}

// Cek ukuran (maks 2MB)
if (strlen($image_data) > 2 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'Ukuran gambar melebihi 2MB']);
    exit;
}

// Generate nama file unik
$filename = uniqid($folder_key . '_', true) . '.' . ($ext === 'jpeg' ? 'jpg' : $ext);
$filepath = $upload_dir . $filename;

if (file_put_contents($filepath, $image_data) === false) {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan gambar ke server']);
    exit;
}


// URL untuk disimpan ke DB (relatif dari root project, dipakai di index.php)
$public_url = 'uploads/' . $folder_key . '/' . $filename;

// URL untuk preview di halaman admin (subfolder /admin/ → perlu ../)
$admin_preview_url = '../uploads/' . $folder_key . '/' . $filename;

echo json_encode([
    'success'     => true,
    'message'     => 'Gambar berhasil diupload',
    'url'         => $public_url,
    'preview_url' => $admin_preview_url,
    'filename'    => $filename
]);
?>
