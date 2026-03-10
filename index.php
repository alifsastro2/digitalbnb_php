<?php
require_once 'config/database.php';

// Helper: resolve path gambar — bisa dari uploads lokal atau URL eksternal
function imgUrl($path) {
    if (empty($path)) return '';
    if (str_starts_with($path, 'http')) return $path; // URL eksternal, pakai langsung
    return $path; // Path lokal relatif dari root, langsung pakai
}

// Function helper untuk get content
function content($section, $key, $default = '') {
    return htmlspecialchars(getContent($section, $key)) ?: $default;
}

// Function untuk get portfolio
function getPortfolio($limit = null) {
    global $conn;
    $sql = "SELECT * FROM portfolio WHERE is_active = 1 ORDER BY display_order ASC, created_at DESC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function untuk get testimonials
function getTestimonials($limit = null) {
    global $conn;
    $sql = "SELECT * FROM testimonials WHERE is_active = 1 ORDER BY display_order ASC, created_at DESC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function untuk get FAQ
function getFAQ($limit = null) {
    global $conn;
    $sql = "SELECT * FROM faq WHERE is_active = 1 ORDER BY display_order ASC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Digital BnB - Jasa Pembuatan Website Profesional untuk UMKM. Website Modern, Cepat, dan SEO Friendly.">
<meta name="keywords" content="jasa website, pembuatan website, web development, UMKM, digital marketing">
<title><?php echo content('hero', 'title', 'Digital BnB'); ?> - <?php echo content('hero', 'subtitle', 'Build & Boost Your Business'); ?></title>

<link rel="stylesheet" href="css/futuristic.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<!-- Font Awesome untuk icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</head>

<body>

<!-- Particles Background -->
<div id="particles-js"></div>

<!-- NAVIGATION BAR -->
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <a href="#home" class="nav-logo">
            <img src="assets/logo.png" alt="Digital BnB Logo">
            <span>Digital BnB</span>
        </a>
        
        <ul class="nav-menu" id="navMenu">
            <li><a href="#home" class="nav-link">Home</a></li>
            <li><a href="#about" class="nav-link">Tentang</a></li>
            <li><a href="#portfolio" class="nav-link">Portofolio</a></li>
            <li><a href="#paket" class="nav-link">Layanan</a></li>
            <li><a href="#faq" class="nav-link">FAQ</a></li>
            <li><a href="#kontak" class="nav-link">Kontak</a></li>
        </ul>
        
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<header class="hero" id="home">
    <div class="hero-content">
        <img src="assets/logo.png" class="logo" alt="Digital BnB Logo">
        <h1 class="hero-title"><?php echo content('hero', 'title'); ?></h1>
        <p class="hero-subtitle"><?php echo content('hero', 'subtitle'); ?></p>
        <p class="tagline"><?php echo content('hero', 'tagline'); ?></p>
        <div class="hero-buttons">
            <a href="#paket" class="btn-primary"><?php echo content('hero', 'cta_text'); ?></a>
            <a href="#portfolio" class="btn-secondary">Lihat Portfolio</a>
        </div>
    </div>
    <div class="scroll-indicator">
        <i class="fas fa-chevron-down"></i>
    </div>
</header>

<!-- ABOUT SECTION -->
<section class="about" id="about">
    <div class="container">
        <h2 class="section-title"><?php echo content('about', 'title'); ?></h2>
        <p class="section-description"><?php echo content('about', 'description'); ?></p>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features" id="features">
    <div class="container">
        <h2 class="section-title"><?php echo content('features', 'title'); ?></h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3><?php echo content('features', 'feature1_title'); ?></h3>
                <p><?php echo content('features', 'feature1_desc'); ?></p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3><?php echo content('features', 'feature2_title'); ?></h3>
                <p><?php echo content('features', 'feature2_desc'); ?></p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3><?php echo content('features', 'feature3_title'); ?></h3>
                <p><?php echo content('features', 'feature3_desc'); ?></p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3><?php echo content('features', 'feature4_title'); ?></h3>
                <p><?php echo content('features', 'feature4_desc'); ?></p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3><?php echo content('features', 'feature5_title'); ?></h3>
                <p><?php echo content('features', 'feature5_desc'); ?></p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3><?php echo content('features', 'feature6_title'); ?></h3>
                <p><?php echo content('features', 'feature6_desc'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- PORTFOLIO SECTION -->
<section class="portfolio" id="portfolio">
    <div class="container">
        <h2 class="section-title">Portfolio Kami</h2>
        <p class="section-subtitle">Lihat beberapa project yang telah kami kerjakan</p>
        
        <div class="portfolio-grid">
            <?php 
            $portfolios = getPortfolio(6);
            foreach ($portfolios as $item): 
            ?>
            <div class="portfolio-card">
                <div class="portfolio-image">
                    <img src="<?php echo htmlspecialchars(imgUrl($item['image_url'])); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" onerror="this.src='assets/logo.png'">
                    <div class="portfolio-overlay">
                        <div class="portfolio-info">
                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p><?php echo htmlspecialchars($item['description']); ?></p>
                            <span class="portfolio-category">
                                <i class="fas fa-tag"></i> <?php echo htmlspecialchars($item['category']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="portfolio-footer">
                    <p class="client-name">
                        <i class="fas fa-user"></i> <?php echo htmlspecialchars($item['client_name']); ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="cta-inline">
            <a href="#kontak" class="btn-primary">Konsultasi Project Anda</a>
        </div>
    </div>
</section>

<!-- PROCESS SECTION -->
<section class="process" id="process">
    <div class="container">
        <h2 class="section-title"><?php echo content('process', 'title'); ?></h2>
        <p class="section-subtitle">Langkah mudah untuk memulai project Anda</p>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3><?php echo content('process', 'step1_title'); ?></h3>
                    <p><?php echo content('process', 'step1_desc'); ?></p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3><?php echo content('process', 'step2_title'); ?></h3>
                    <p><?php echo content('process', 'step2_desc'); ?></p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <h3><?php echo content('process', 'step3_title'); ?></h3>
                    <p><?php echo content('process', 'step3_desc'); ?></p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3><?php echo content('process', 'step4_title'); ?></h3>
                    <p><?php echo content('process', 'step4_desc'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section class="testimonials" id="testimonials">
    <div class="container">
        <h2 class="section-title">Apa Kata Mereka?</h2>
        <p class="section-subtitle">Testimoni dari client yang puas dengan layanan kami</p>
        
        <div class="testimonials-grid">
            <?php 
            $testimonials = getTestimonials(6);
            foreach ($testimonials as $testi): 
            ?>
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <?php for ($i = 0; $i < $testi['rating']; $i++): ?>
                        <i class="fas fa-star"></i>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-text">"<?php echo htmlspecialchars($testi['testimonial']); ?>"</p>
                <div class="testimonial-author">
                    <img src="<?php echo htmlspecialchars(imgUrl($testi['avatar_url'])); ?>" alt="<?php echo htmlspecialchars($testi['client_name']); ?>" onerror="this.style.display='none'">
                    <div class="author-info">
                        <h4><?php echo htmlspecialchars($testi['client_name']); ?></h4>
                        <p><?php echo htmlspecialchars($testi['client_position']); ?> - <?php echo htmlspecialchars($testi['client_company']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PRICING SECTION -->
<section class="pricing" id="paket">
    <div class="container">
        <h2 class="section-title">Paket Layanan</h2>
        <p class="section-subtitle">Pilih paket yang sesuai dengan kebutuhan bisnis Anda</p>

        <div class="pricing-grid">
    <?php
    $wa_number  = getContent('cta', 'whatsapp_number');
    $pkg_result = $conn->query("SELECT * FROM packages WHERE is_active = 1 ORDER BY display_order ASC, id ASC");
    while ($pkg = $pkg_result->fetch_assoc()):
        $pkg_features = explode('|', $pkg['features']);
        $wa_message   = "Halo Digital BnB,%0A%0ASaya tertarik dengan *{$pkg['package_name']}* ({$pkg['price']}) yang ada di website Anda.%0A%0ABoleh saya mendapatkan informasi lebih lanjut mengenai paket ini, seperti detail layanan, proses pengerjaan, dan estimasi waktu penyelesaiannya?%0A%0ATerima kasih.";
        $wa_link      = "https://wa.me/{$wa_number}?text={$wa_message}";
    ?>
    <div class="price-card <?php echo $pkg['is_popular'] ? 'featured' : ''; ?>">
        <?php if ($pkg['is_popular']): ?>
        <div class="badge">Populer</div>
        <?php endif; ?>
        <div class="price-header">
            <h3><?php echo htmlspecialchars($pkg['package_name']); ?></h3>
            <div class="price"><?php echo htmlspecialchars($pkg['price']); ?></div>
            <?php if (!empty($pkg['description'])): ?>
            <p style="color:#aaa;font-size:0.85rem;margin-top:6px;"><?php echo htmlspecialchars($pkg['description']); ?></p>
            <?php endif; ?>
        </div>
        <ul class="price-features">
            <?php foreach ($pkg_features as $feat): ?>
            <li><i class="fas fa-check"></i> <?php echo htmlspecialchars(trim($feat)); ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="<?php echo $wa_link; ?>" class="btn-price" target="_blank">
            <i class="fab fa-whatsapp"></i> Pilih Paket
        </a>
    </div>
    <?php endwhile; ?>
</div>
    </div>
</section>

<!-- FAQ SECTION -->
<section class="faq" id="faq">
    <div class="container">
        <h2 class="section-title">Pertanyaan Yang Sering Diajukan</h2>
        <p class="section-subtitle">Temukan jawaban untuk pertanyaan umum</p>
        
        <div class="faq-container">
            <?php 
            $faqs = getFAQ();
            foreach ($faqs as $index => $faq): 
            ?>
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(<?php echo $index; ?>)">
                    <span><?php echo htmlspecialchars($faq['question']); ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer" id="faq-<?php echo $index; ?>">
                    <p><?php echo htmlspecialchars($faq['answer']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="faq-cta">
            <p>Masih ada pertanyaan?</p>
            <a href="#kontak" class="btn-primary">Hubungi Kami</a>
        </div>
    </div>
</section>

<!-- CONTACT SECTION -->
<section class="contact" id="kontak">
    <div class="container">
        <h2 class="section-title"><?php echo content('contact', 'title'); ?></h2>
        <p class="section-subtitle"><?php echo content('contact', 'subtitle'); ?></p>
        
        <div class="contact-wrapper">
            <!-- Contact Info -->
            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Email</h4>
                        <p><?php echo content('contact', 'email'); ?></p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="contact-details">
                        <h4>WhatsApp</h4>
                        <p><?php echo content('contact', 'phone'); ?></p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fab fa-instagram"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Instagram</h4>
                        <p><?php echo content('contact', 'instagram'); ?></p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Alamat</h4>
                        <p><?php echo content('contact', 'address'); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="contact-form">
                <form id="contactForm" onsubmit="return handleContactSubmit(event)">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required placeholder="Masukkan nama Anda">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required placeholder="nama@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">No. WhatsApp</label>
                        <input type="tel" id="phone" name="phone" required placeholder="08123456789">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea id="message" name="message" rows="5" required placeholder="Ceritakan kebutuhan Anda..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta-final">
    <div class="container">
        <h2><?php echo content('cta', 'title'); ?></h2>
        <p><?php echo content('cta', 'description'); ?></p>
        <a href="https://wa.me/<?php echo content('cta', 'whatsapp_number'); ?>" class="btn-primary btn-lg" target="_blank">
            <i class="fab fa-whatsapp"></i> <?php echo content('cta', 'button_text'); ?>
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <img src="assets/logo.png" alt="Digital BnB Logo" class="footer-logo">
                <h3>Digital BnB</h3>
                <p><?php echo content('footer', 'tagline'); ?></p>
            </div>
            
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#portfolio">Portfolio</a></li>
                    <li><a href="#paket">Layanan</a></li>
                </ul>
            </div>
            
            <div class="footer-links">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="#paket">Landing Page</a></li>
                    <li><a href="#paket">Company Profile</a></li>
                    <li><a href="#paket">E-Commerce</a></li>
                    <li><a href="#paket">Custom Development</a></li>
                </ul>
            </div>
            
            <div class="footer-contact">
                <h4>Hubungi Kami</h4>
                <p><i class="fas fa-envelope"></i> <?php echo content('contact', 'email'); ?></p>
                <p><i class="fas fa-phone"></i> <?php echo content('contact', 'phone'); ?></p>
            
            </div>
        </div>
        
        <div class="footer-bottom">
            <p><?php echo content('footer', 'copyright'); ?> | <a href="login.php">Admin Login</a></p>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/<?php echo content('cta', 'whatsapp_number'); ?>" class="whatsapp-float" target="_blank" title="Chat via WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- Scroll to Top Button -->
<button class="scroll-top" id="scrollTop" onclick="scrollToTop()">
    <i class="fas fa-arrow-up"></i>
</button>

<script src="js/futuristic.js"></script>
</body>
</html>