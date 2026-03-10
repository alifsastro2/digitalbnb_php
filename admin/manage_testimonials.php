<?php
require_once '../config/auth.php';
require_once '../config/database.php';

requireLogin();

// Get all testimonials
$testimonials = [];
$result = $conn->query("SELECT * FROM testimonials ORDER BY display_order, id");
while ($row = $result->fetch_assoc()) {
    $testimonials[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Testimonial - Digital BnB</title>
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
                <h1>💬 Kelola Testimonial</h1>
                <p>Tambah, edit, atau hapus testimonial</p>
            </div>
            <div class="header-right">
                <a href="dashboard.php" class="btn-back">← Kembali</a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </header>

        <div class="content-section">
            <div class="section-header">
                <h2>Daftar Testimonial</h2>
                <button class="btn-add" onclick="showAddModal()">+ Tambah Testimonial</button>
            </div>

            <div class="testimonials-grid">
                <?php foreach($testimonials as $item): ?>
                <div class="testimonial-card" data-id="<?php echo $item['id']; ?>">
                    <div class="testimonial-header">
                        <img src="<?php echo htmlspecialchars($item['avatar_url']); ?>" 
                             alt="<?php echo htmlspecialchars($item['client_name']); ?>" 
                             class="testimonial-avatar">
                        <div>
                            <h3><?php echo htmlspecialchars($item['client_name']); ?></h3>
                            <p class="position"><?php echo htmlspecialchars($item['client_position'] ?? ''); ?></p>
                            <p class="company"><?php echo htmlspecialchars($item['client_company'] ?? ''); ?></p>
                        </div>
                    </div>
                    <div class="testimonial-body">
                        <div class="rating">
                            <?php for($i = 0; $i < $item['rating']; $i++): ?>⭐<?php endfor; ?>
                        </div>
                        <p class="testimonial-text"><?php echo htmlspecialchars($item['testimonial']); ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <span class="status-badge <?php echo $item['is_active'] ? 'active' : 'inactive'; ?>">
                            <?php echo $item['is_active'] ? 'Aktif' : 'Tidak Aktif'; ?>
                        </span>
                        <div class="actions">
                            <button class="btn-edit" onclick="editTestimonial(<?php echo $item['id']; ?>)">✏️ Edit</button>
                            <button class="btn-delete" onclick="deleteTestimonial(<?php echo $item['id']; ?>)">🗑️ Hapus</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal" id="testimonialModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Testimonial</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="testimonialForm">
                <input type="hidden" id="testimonial_id" name="id">
                
                <div class="form-group">
                    <label>Nama Client *</label>
                    <input type="text" id="client_name" name="client_name" required>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Posisi</label>
                        <input type="text" id="client_position" name="client_position">
                    </div>

                    <div class="form-group">
                        <label>Perusahaan</label>
                        <input type="text" id="client_company" name="client_company">
                    </div>
                </div>

                <div class="form-group">
                    <label>Testimonial *</label>
                    <textarea id="testimonial" name="testimonial" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label>Foto Profil</label>
                    <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                        <img id="avatar_preview" src="" alt="Preview"
                             class="cup-preview-img"
                             style="display:none; width:80px; height:80px; border-radius:50%; object-fit:cover; border:2px solid rgba(0,212,255,0.4);">
                        <div>
                            <button type="button" id="btn_upload_avatar"
                                    style="padding:8px 18px; background:linear-gradient(135deg,#00d4ff,#8000ff); border:none; color:#fff; border-radius:8px; cursor:pointer; font-family:'Poppins',sans-serif; font-size:0.85rem;">
                                📁 Pilih Foto
                            </button>
                            <small style="display:block; margin-top:6px; color:#888;">
                                Format: JPG/PNG/WEBP · Maks 2MB · Akan di-crop 1:1
                            </small>
                        </div>
                    </div>
                    <!-- hidden input tetap menyimpan path untuk dikirim ke server -->
                    <input type="hidden" id="avatar_url" name="avatar_url">
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Rating</label>
                        <select id="rating" name="rating">
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>

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
    <script src="../js/testimonials.js"></script>
    <script src="../js/crop-uploader.js"></script>
    <script>
        // Inisialisasi crop uploader untuk foto profil testimoni
        const avatarUploader = new CropUploader({
            triggerEl:   '#btn_upload_avatar',
            previewEl:   '#avatar_preview',
            hiddenInput: '#avatar_url',
            folder:      'profil_testimoni',
            aspectRatio: 1,
            uploadUrl:   'api_upload.php',
        });
    </script>
</body>
</html>
