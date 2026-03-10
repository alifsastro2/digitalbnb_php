<?php
require_once '../config/auth.php';
require_once '../config/database.php';

requireLogin();

// Get all FAQs
$faqs = [];
$result = $conn->query("SELECT * FROM faq ORDER BY display_order, id");
while ($row = $result->fetch_assoc()) {
    $faqs[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola FAQ - Digital BnB</title>
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
                <h1>❓ Kelola FAQ</h1>
                <p>Tambah, edit, atau hapus pertanyaan yang sering diajukan</p>
            </div>
            <div class="header-right">
                <a href="dashboard.php" class="btn-back">← Kembali</a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </header>

        <div class="content-section">
            <div class="section-header">
                <h2>Daftar FAQ</h2>
                <button class="btn-add" onclick="showAddModal()">+ Tambah FAQ</button>
            </div>

            <div class="faq-list">
                <?php foreach($faqs as $item): ?>
                <div class="faq-item" data-id="<?php echo $item['id']; ?>">
                    <div class="faq-header">
                        <div class="faq-info">
                            <span class="badge"><?php echo htmlspecialchars($item['category']); ?></span>
                            <span class="status-badge <?php echo $item['is_active'] ? 'active' : 'inactive'; ?>">
                                <?php echo $item['is_active'] ? 'Aktif' : 'Tidak Aktif'; ?>
                            </span>
                        </div>
                        <div class="faq-actions">
                            <button class="btn-edit" onclick="editFaq(<?php echo $item['id']; ?>)">✏️</button>
                            <button class="btn-delete" onclick="deleteFaq(<?php echo $item['id']; ?>)">🗑️</button>
                        </div>
                    </div>
                    <div class="faq-content">
                        <h3>Q: <?php echo htmlspecialchars($item['question']); ?></h3>
                        <p>A: <?php echo htmlspecialchars($item['answer']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal" id="faqModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah FAQ</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="faqForm">
                <input type="hidden" id="faq_id" name="id">
                
                <div class="form-group">
                    <label>Pertanyaan *</label>
                    <textarea id="question" name="question" rows="2" required></textarea>
                </div>

                <div class="form-group">
                    <label>Jawaban *</label>
                    <textarea id="answer" name="answer" rows="4" required></textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select id="category" name="category">
                            <option value="General">General</option>
                            <option value="Timeline">Timeline</option>
                            <option value="Pricing">Pricing</option>
                            <option value="Service">Service</option>
                            <option value="Payment">Payment</option>
                            <option value="Support">Support</option>
                            <option value="Technical">Technical</option>
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
    <script src="../js/faq.js"></script>
</body>
</html>
