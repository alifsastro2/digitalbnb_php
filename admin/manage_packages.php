<?php
require_once '../config/auth.php';
require_once '../config/database.php';

requireLogin();

// Check if packages table exists, if not show instruction
$table_check = $conn->query("SHOW TABLES LIKE 'packages'");
$table_exists = $table_check->num_rows > 0;

if ($table_exists) {
    // Get all packages
    $packages = [];
    $result = $conn->query("SELECT * FROM packages ORDER BY display_order, id");
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Paket Layanan - Digital BnB</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</head>
<body>
    <div id="particles-js"></div>
    <div class="grid-background"></div>
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loader"></div>
    </div>
    
    <div class="notification" id="notification"></div>

    <div class="admin-container">
        <header class="admin-header">
            <div class="header-left">
                <h1>📦 Kelola Paket Layanan</h1>
                <p>Tambah, edit, atau hapus paket layanan</p>
            </div>
            <div class="header-right">
                <a href="dashboard.php" class="btn-back">← Kembali</a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </header>

        <?php if (!$table_exists): ?>
        <div class="content-section">
            <div class="alert alert-warning">
                <h3>⚠️ Tabel Packages Belum Ada</h3>
                <p>Silakan jalankan query SQL berikut di phpMyAdmin untuk membuat tabel packages:</p>
                <pre style="background: #1a1a2e; padding: 20px; border-radius: 8px; overflow-x: auto; color: #fff;">
CREATE TABLE IF NOT EXISTS `packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `features` text NOT NULL,
  `is_popular` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_packages_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `packages` (`package_name`, `price`, `features`, `is_popular`, `display_order`) VALUES
('Paket Perintis', 'Rp499.000', 'Landing Page|Domain 1 Tahun|Hosting 3 Bulan|Revisi 2x', 0, 1),
('Paket Berkembang', 'Rp1.299.000', 'Company Profile|Admin Panel|SEO Basic|Revisi 3x', 1, 2),
('Paket Bisnis', 'Rp2.999.000', 'Sistem Login|Database|Backup|Revisi 5x', 0, 3),
('Toko Online', 'Rp3.499.000', 'E-Commerce|Checkout|WhatsApp|Training', 0, 4);
                </pre>
                <p>File SQL juga tersedia di: <code>packages_table.sql</code></p>
            </div>
        </div>
        <?php else: ?>
        
        <div class="content-section">
            <div class="section-header">
                <h2>Daftar Paket</h2>
                <button class="btn-add" onclick="showAddModal()">+ Tambah Paket</button>
            </div>

            <div class="packages-grid">
                <?php foreach($packages as $item): ?>
                <div class="package-card <?php echo $item['is_popular'] ? 'popular' : ''; ?>" data-id="<?php echo $item['id']; ?>">
                    <?php if ($item['is_popular']): ?>
                    <div class="popular-badge">⭐ Populer</div>
                    <?php endif; ?>
                    
                    <div class="package-header">
                        <h3><?php echo htmlspecialchars($item['package_name']); ?></h3>
                        <div class="package-price"><?php echo htmlspecialchars($item['price']); ?></div>
                        <?php if ($item['description']): ?>
                        <p class="package-desc"><?php echo htmlspecialchars($item['description']); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="package-features">
                        <ul>
                            <?php 
                            $features = explode('|', $item['features']);
                            foreach($features as $feature): 
                            ?>
                            <li>✓ <?php echo htmlspecialchars($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="package-footer">
                        <span class="status-badge <?php echo $item['is_active'] ? 'active' : 'inactive'; ?>">
                            <?php echo $item['is_active'] ? 'Aktif' : 'Tidak Aktif'; ?>
                        </span>
                        <div class="actions">
                            <button class="btn-edit" onclick="editPackage(<?php echo $item['id']; ?>)">✏️ Edit</button>
                            <button class="btn-delete" onclick="deletePackage(<?php echo $item['id']; ?>)">🗑️ Hapus</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php endif; ?>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal" id="packageModal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Paket</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="packageForm">
                <input type="hidden" id="package_id" name="id">
                
                <div class="form-group">
                    <label>Nama Paket *</label>
                    <input type="text" id="package_name" name="package_name" required>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Harga *</label>
                        <input type="text" id="price" name="price" required placeholder="Rp1.000.000">
                    </div>

                    <div class="form-group">
                        <label>Urutan Tampil</label>
                        <input type="number" id="display_order" name="display_order" value="0" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi Singkat</label>
                    <input type="text" id="description" name="description" placeholder="Cocok untuk pemula">
                </div>

                <div class="form-group">
                    <label>Fitur-fitur *</label>
                    <textarea id="features" name="features" rows="5" required placeholder="Masukkan satu fitur per baris"></textarea>
                    <small>Tulis satu fitur per baris. Contoh:
Landing Page
Domain 1 Tahun
Hosting 3 Bulan
Revisi 2x</small>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="is_popular" name="is_popular" value="1">
                            Tandai sebagai paket populer
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select id="is_active" name="is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-save">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/admin.js"></script>
    <script src="../js/packages.js"></script>
</body>
</html>
