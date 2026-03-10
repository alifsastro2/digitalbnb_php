<?php
require_once '../config/auth.php';
require_once '../config/database.php';

// Check login
requireLogin();

// Get all content
$contents = [];
$result = $conn->query("SELECT * FROM site_content ORDER BY section, key_name");
while ($row = $result->fetch_assoc()) {
    $contents[$row['section']][$row['key_name']] = $row['value'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Digital BnB</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</head>
<body>

    <!-- Particles Background -->
    <div id="particles-js"></div>
    <div class="grid-background"></div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loader"></div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <div class="admin-container">
        
        <!-- Header -->
        <header class="admin-header">
            <div class="header-left">
                <h1>🎛️ Admin Dashboard</h1>
                <p>Kelola konten website Digital BnB</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    👤 <span><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                </div>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </header>

        <!-- Navigation Menu -->
        <nav class="admin-nav">
            <a href="#hero" class="nav-item active" data-target="content">
                <span class="icon">🎯</span>
                <span>Konten Dasar</span>
            </a>
            <a href="manage_portfolio.php" class="nav-item">
                <span class="icon">💼</span>
                <span>Portfolio</span>
            </a>
            <a href="manage_testimonials.php" class="nav-item">
                <span class="icon">💬</span>
                <span>Testimonial</span>
            </a>
            <a href="manage_packages.php" class="nav-item">
                <span class="icon">📦</span>
                <span>Paket Layanan</span>
            </a>
            <a href="manage_faq.php" class="nav-item">
                <span class="icon">❓</span>
                <span>FAQ</span>
            </a>
        </nav>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="action-card" onclick="scrollToSection('hero')">
                <div class="icon">🏠</div>
                <h3>Hero Section</h3>
                <p>Edit judul & tagline</p>
            </div>
            <div class="action-card" onclick="location.href='manage_portfolio.php'">
                <div class="icon">💼</div>
                <h3>Portfolio</h3>
                <p>Kelola portfolio</p>
            </div>
            <div class="action-card" onclick="location.href='manage_testimonials.php'">
                <div class="icon">💬</div>
                <h3>Testimonial</h3>
                <p>Kelola testimonial</p>
            </div>
            <div class="action-card" onclick="window.open('../index.php', '_blank')">
                <div class="icon">🌐</div>
                <h3>Preview</h3>
                <p>Lihat website</p>
            </div>
        </div>

        <!-- Hero Section -->
        <section class="content-section" id="hero">
            <div class="section-header">
                <h2>Hero Section</h2>
                <span class="section-icon">🎯</span>
            </div>
            <form class="edit-form" data-section="hero">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($contents['hero']['title'] ?? ''); ?>" data-key="title">
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" value="<?php echo htmlspecialchars($contents['hero']['subtitle'] ?? ''); ?>" data-key="subtitle">
                    </div>
                    <div class="form-group">
                        <label>Tagline</label>
                        <input type="text" name="tagline" value="<?php echo htmlspecialchars($contents['hero']['tagline'] ?? ''); ?>" data-key="tagline">
                    </div>
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="cta_text" value="<?php echo htmlspecialchars($contents['hero']['cta_text'] ?? ''); ?>" data-key="cta_text">
                    </div>
                </div>
                <button type="submit" class="btn-save">💾 Simpan Hero Section</button>
            </form>
        </section>

        <!-- About Section -->
        <section class="content-section" id="about">
            <div class="section-header">
                <h2>About Section</h2>
                <span class="section-icon">ℹ️</span>
            </div>
            <form class="edit-form" data-section="about">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($contents['about']['title'] ?? ''); ?>" data-key="title">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" data-key="description"><?php echo htmlspecialchars($contents['about']['description'] ?? ''); ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn-save">💾 Simpan About Section</button>
            </form>
        </section>

        <!-- Features Section -->
        <section class="content-section" id="features">
            <div class="section-header">
                <h2>Features Section</h2>
                <span class="section-icon">⭐</span>
            </div>
            <form class="edit-form" data-section="features">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($contents['features']['title'] ?? ''); ?>" data-key="title">
                    </div>
                </div>
                <div class="features-grid">
                    <?php for($i = 1; $i <= 6; $i++): ?>
                    <div class="feature-card">
                        <h4>Feature <?php echo $i; ?></h4>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="feature<?php echo $i; ?>_title" 
                                   value="<?php echo htmlspecialchars($contents['features']['feature'.$i.'_title'] ?? ''); ?>" 
                                   data-key="feature<?php echo $i; ?>_title">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="feature<?php echo $i; ?>_desc" 
                                      data-key="feature<?php echo $i; ?>_desc"><?php echo htmlspecialchars($contents['features']['feature'.$i.'_desc'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                <button type="submit" class="btn-save">💾 Simpan Features Section</button>
            </form>
        </section>

        <!-- Process Section -->
        <section class="content-section" id="process">
            <div class="section-header">
                <h2>Process Section</h2>
                <span class="section-icon">🔄</span>
            </div>
            <form class="edit-form" data-section="process">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($contents['process']['title'] ?? ''); ?>" data-key="title">
                </div>
                <div class="process-grid">
                    <?php for($i = 1; $i <= 4; $i++): ?>
                    <div class="process-card">
                        <h4>Step <?php echo $i; ?></h4>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="step<?php echo $i; ?>_title" 
                                   value="<?php echo htmlspecialchars($contents['process']['step'.$i.'_title'] ?? ''); ?>" 
                                   data-key="step<?php echo $i; ?>_title">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="step<?php echo $i; ?>_desc" 
                                      data-key="step<?php echo $i; ?>_desc"><?php echo htmlspecialchars($contents['process']['step'.$i.'_desc'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                <button type="submit" class="btn-save">💾 Simpan Process Section</button>
            </form>
        </section>

        <!-- CTA Section -->
        <section class="content-section" id="cta">
            <div class="section-header">
                <h2>CTA Section</h2>
                <span class="section-icon">📢</span>
            </div>
            <form class="edit-form" data-section="cta">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($contents['cta']['title'] ?? ''); ?>" data-key="title">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" value="<?php echo htmlspecialchars($contents['cta']['description'] ?? ''); ?>" data-key="description">
                    </div>
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="button_text" value="<?php echo htmlspecialchars($contents['cta']['button_text'] ?? ''); ?>" data-key="button_text">
                    </div>
                    <div class="form-group">
                        <label>WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="<?php echo htmlspecialchars($contents['cta']['whatsapp_number'] ?? ''); ?>" data-key="whatsapp_number" placeholder="6289619631221">
                    </div>
                </div>
                <button type="submit" class="btn-save">💾 Simpan CTA Section</button>
            </form>
        </section>

        <!-- Contact Section -->
        <section class="content-section" id="contact">
            <div class="section-header">
                <h2>Contact Section</h2>
                <span class="section-icon">📞</span>
            </div>
            <form class="edit-form" data-section="contact">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($contents['contact']['title'] ?? ''); ?>" data-key="title">
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" value="<?php echo htmlspecialchars($contents['contact']['subtitle'] ?? ''); ?>" data-key="subtitle">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($contents['contact']['email'] ?? ''); ?>" data-key="email">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($contents['contact']['phone'] ?? ''); ?>" data-key="phone">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($contents['contact']['address'] ?? ''); ?>" data-key="address">
                    </div>
                    <div class="form-group">
                        <label>Instagram</label>
                        <input type="text" name="instagram" value="<?php echo htmlspecialchars($contents['contact']['instagram'] ?? ''); ?>" data-key="instagram">
                    </div>
                </div>
                <button type="submit" class="btn-save">💾 Simpan Contact Section</button>
            </form>
        </section>

        <!-- Footer Section -->
        <section class="content-section" id="footer">
            <div class="section-header">
                <h2>Footer Section</h2>
                <span class="section-icon">📄</span>
            </div>
            <form class="edit-form" data-section="footer">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Copyright Text</label>
                        <input type="text" name="copyright" value="<?php echo htmlspecialchars($contents['footer']['copyright'] ?? ''); ?>" data-key="copyright">
                    </div>
                    <div class="form-group">
                        <label>Tagline</label>
                        <input type="text" name="tagline" value="<?php echo htmlspecialchars($contents['footer']['tagline'] ?? ''); ?>" data-key="tagline">
                    </div>
                </div>
                <button type="submit" class="btn-save">💾 Simpan Footer Section</button>
            </form>
        </section>

    </div>

    <script src="../js/admin.js"></script>

</body>
</html>
