<?php
require_once '../config/auth.php';
require_once '../config/database.php';

requireLogin();

// Get all portfolio items
$portfolio_items = [];
$result = $conn->query("SELECT * FROM portfolio ORDER BY display_order, id");
while ($row = $result->fetch_assoc()) {
    $portfolio_items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Portfolio - Digital BnB</title>
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
                <h1>💼 Kelola Portfolio</h1>
                <p>Tambah, edit, atau hapus portfolio</p>
            </div>
            <div class="header-right">
                <a href="dashboard.php" class="btn-back">← Kembali</a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </header>

        <div class="content-section">
            <div class="section-header">
                <h2>Daftar Portfolio</h2>
                <button class="btn-add" onclick="showAddModal()">+ Tambah Portfolio</button>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($portfolio_items as $item): ?>
                        <tr data-id="<?php echo $item['id']; ?>">
                            <td><?php echo $item['display_order']; ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                     class="table-thumbnail">
                            </td>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td><span class="badge"><?php echo htmlspecialchars($item['category']); ?></span></td>
                            <td><?php echo htmlspecialchars($item['client_name'] ?? '-'); ?></td>
                            <td>
                                <span class="status-badge <?php echo $item['is_active'] ? 'active' : 'inactive'; ?>">
                                    <?php echo $item['is_active'] ? 'Aktif' : 'Tidak Aktif'; ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn-edit" onclick="editPortfolio(<?php echo $item['id']; ?>)">✏️</button>
                                <button class="btn-delete" onclick="deletePortfolio(<?php echo $item['id']; ?>)">🗑️</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal" id="portfolioModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Portfolio</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="portfolioForm">
                <input type="hidden" id="portfolio_id" name="id">
                
                <div class="form-group">
                    <label>Judul Portfolio *</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            <option value="E-Commerce">E-Commerce</option>
                            <option value="Company Profile">Company Profile</option>
                            <option value="Landing Page">Landing Page</option>
                            <option value="Portfolio">Portfolio</option>
                            <option value="E-Learning">E-Learning</option>
                            <option value="Property">Property</option>
                            <option value="Other">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Client</label>
                        <input type="text" id="client_name" name="client_name">
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea id="description" name="description" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label>Gambar Portfolio *</label>
                    <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:8px;">
                        <img id="portfolio_img_preview" src="" alt="Preview"
                             style="display:none; width:120px; height:80px; border-radius:8px; object-fit:cover; border:2px solid rgba(0,212,255,0.4);">
                        <div>
                            <button type="button" id="btn_upload_portfolio"
                                    style="padding:8px 18px; background:linear-gradient(135deg,#00d4ff,#8000ff); border:none; color:#fff; border-radius:8px; cursor:pointer; font-family:'Poppins',sans-serif; font-size:0.85rem;">
                                📁 Pilih Gambar
                            </button>
                            <small style="display:block; margin-top:6px; color:#888;">
                                Format: JPG/PNG/WEBP · Maks 2MB · Akan di-crop 1:1
                            </small>
                        </div>
                    </div>
                    <input type="hidden" id="image_url" name="image_url" required>
                </div>

                <div class="form-group">
                    <label>URL Project</label>
                    <input type="url" id="project_url" name="project_url" placeholder="https://example.com">
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Urutan Tampil</label>
                        <input type="number" id="display_order" name="display_order" value="0" min="0">
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
    <script src="../js/portfolio.js"></script>
    <script src="../js/crop-uploader.js"></script>
    <script>
        // Inisialisasi crop uploader untuk gambar portfolio
        const portfolioUploader = new CropUploader({
            triggerEl:   '#btn_upload_portfolio',
            previewEl:   '#portfolio_img_preview',
            hiddenInput: '#image_url',
            folder:      'portfolio',
            aspectRatio: 1,
            uploadUrl:   'api_upload.php',
        });
    </script>
</body>
</html>
