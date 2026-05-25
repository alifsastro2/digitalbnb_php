<?php
require_once 'config/database.php';

/* ─── Fetch all content ───────────────────────────────────────── */
$stmt = $conn->query("SELECT section, key_name, value FROM site_content");
$c = [];
foreach ($stmt->fetchAll() as $row) {
    $c[$row['section']][$row['key_name']] = $row['value'];
}
$h = fn($s, $k) => htmlspecialchars($c[$s][$k] ?? '', ENT_QUOTES, 'UTF-8');

$portfolio    = $conn->query("SELECT * FROM portfolio    WHERE is_active = 1 ORDER BY is_featured DESC, display_order ASC, id ASC")->fetchAll();
$testimonials = $conn->query("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY display_order ASC, id ASC")->fetchAll();
$faqs         = $conn->query("SELECT * FROM faq          WHERE is_active = 1 ORDER BY display_order ASC, id ASC")->fetchAll();

$waNumber = $c['cta']['whatsapp_number'] ?? '6281387614254';
$waBase   = 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo Digital BnB! Saya ingin konsultasi.');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Digital BnB — Build & Boost bisnis Anda dengan website profesional, aplikasi mobile, undangan digital, dan sistem kasir modern.">
    <title>Digital BnB — Build &amp; Boost Your Business</title>

    <link rel="icon" href="assets/logo.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.4.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@7.4.0/dist/ionicons/ionicons.js"></script>
</head>
<body>

<!-- ─── NAVBAR ─────────────────────────────────────────────── -->
<nav id="navbar">
    <div class="nav-inner">
        <a href="#hero" class="nav-logo">
            <img src="assets/logo.png" alt="Digital BnB Logo">
            <span>Digital BnB</span>
        </a>
        <div class="nav-links" id="navLinks">
            <a href="#products"  class="nav-link">Produk</a>
            <a href="#portfolio" class="nav-link">Portfolio</a>
            <a href="#process"   class="nav-link">Cara Kerja</a>
            <a href="#faq"       class="nav-link">FAQ</a>
            <a href="#contact"   class="nav-link">Kontak</a>
            <a href="<?= htmlspecialchars($waBase) ?>" target="_blank" class="nav-cta" rel="noopener">
                Mulai Konsultasi
            </a>
        </div>
        <button class="hamburger" id="hamburger" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<!-- ─── HERO ────────────────────────────────────────────────── -->
<section id="hero">
    <div class="hero-blob"></div>
    <div class="hero-blob-2"></div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge reveal"><?= $h('hero', 'badge') ?: 'Digital Agency Indonesia' ?></div>

            <h1 class="hero-title reveal reveal-delay-1">
                <?php
                $rawTitle = $c['hero']['title'] ?? "Build & Boost\nBisnis Anda";
                $parts = explode("\n", $rawTitle);
                echo htmlspecialchars($parts[0], ENT_QUOTES, 'UTF-8');
                if (!empty($parts[1])) {
                    echo ' <span class="accent gradient-text">' . htmlspecialchars($parts[1], ENT_QUOTES, 'UTF-8') . '</span>';
                }
                ?>
            </h1>

            <p class="hero-sub reveal reveal-delay-2">
                <?= $h('hero', 'subtitle') ?: 'Dari website profesional hingga aplikasi mobile — kami wujudkan digital presence bisnis Anda.' ?>
            </p>

            <div class="hero-ctas reveal reveal-delay-3">
                <a href="#products" class="btn-primary">
                    <?= $h('hero', 'cta_primary') ?: 'Lihat Produk' ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </a>
                <a href="<?= htmlspecialchars($waBase) ?>" target="_blank" class="btn-outline" rel="noopener">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <?= $h('hero', 'cta_wa') ?: 'Konsultasi Gratis' ?>
                </a>
            </div>

            <div class="hero-stats reveal reveal-delay-4">
                <div class="stat-item">
                    <div class="stat-num"><?= $h('stats', 'projects') ?: '100%' ?></div>
                    <div class="stat-label"><?= $h('stats', 'projects_label') ?: 'Kepuasan Klien' ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-num"><?= $h('stats', 'clients') ?: '48 Jam' ?></div>
                    <div class="stat-label"><?= $h('stats', 'clients_label') ?: 'Respons Cepat' ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-num"><?= $h('stats', 'cities') ?: '1 Bulan' ?></div>
                    <div class="stat-label"><?= $h('stats', 'cities_label') ?: 'Garansi Support' ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-scroll" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        <span>Scroll</span>
    </div>
</section>

<!-- ─── PRODUCTS ─────────────────────────────────────────────── -->
<section id="products">
    <div class="container">
        <div class="section-head">
            <div class="section-label reveal">Apa yang Kami Buat</div>
            <h2 class="section-title reveal reveal-delay-1">Produk &amp; Layanan Kami</h2>
            <p class="section-sub reveal reveal-delay-2">Solusi digital lengkap — dari website hingga aplikasi mobile, semua dirancang untuk menumbuhkan bisnis Anda.</p>
        </div>

        <div class="products-grid">
            <div class="product-card product-card--popular reveal">
                <div class="popular-badge"><ion-icon name="star"></ion-icon> Terpopuler</div>
                <div class="product-icon"><ion-icon name="desktop-outline"></ion-icon></div>
                <h3>POS Cashier</h3>
                <p>Sistem kasir digital berbasis web. Kelola transaksi, inventori produk, dan laporan harian dengan mudah dari browser manapun.</p>
                <div class="product-badge-list">
                    <span class="product-badge">Manajemen Produk</span>
                    <span class="product-badge">Laporan Harian</span>
                    <span class="product-badge">Multi-User</span>
                    <span class="product-badge">Print Struk</span>
                </div>
                <div class="product-pricing">
                    <div class="pricing-discount-tag">Hemat 60%</div>
                    <div class="pricing-row">
                        <span class="pricing-old">Rp 500.000</span>
                        <span class="pricing-new">Rp 200.000<span class="pricing-period">/bln</span></span>
                    </div>
                </div>
                <a href="https://pos.digitalbnb.my.id" target="_blank" rel="noopener" class="product-link">
                    Akses POS Cashier
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <p class="product-note">Fitur tambahan &amp; penyesuaian kebutuhan bisnis dapat dibahas langsung.</p>
            </div>

            <div class="product-card reveal reveal-delay-1">
                <div class="product-icon"><ion-icon name="globe-outline"></ion-icon></div>
                <h3>Website Bisnis</h3>
                <p>Landing page, company profile, atau website custom sesuai brand bisnis Anda. Desain profesional, SEO-ready, dan mobile-friendly.</p>
                <div class="product-badge-list">
                    <span class="product-badge">Company Profile</span>
                    <span class="product-badge">Landing Page</span>
                    <span class="product-badge">E-Commerce</span>
                    <span class="product-badge">Admin Panel</span>
                </div>
                <a href="<?= htmlspecialchars($waBase) ?>" target="_blank" rel="noopener" class="product-link">
                    Konsultasi Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <p class="product-note">Harga dan fitur disesuaikan dengan kebutuhan — hubungi kami untuk penawaran.</p>
            </div>

            <div class="product-card reveal reveal-delay-2">
                <div class="product-icon"><ion-icon name="mail-outline"></ion-icon></div>
                <h3>Undangan Digital</h3>
                <p>Undangan digital sinematik untuk berbagai momen spesial — pernikahan, ulang tahun, gathering, dan acara formal. Elegan, interaktif, dan mudah dibagikan.</p>
                <div class="product-badge-list">
                    <span class="product-badge">Pernikahan</span>
                    <span class="product-badge">Birthday & Gathering</span>
                    <span class="product-badge">RSVP Online</span>
                    <span class="product-badge">Hadiah Digital</span>
                </div>
                <div class="product-actions">
                    <a href="https://invite.digitalbnb.my.id" target="_blank" rel="noopener" class="product-link">
                        Lihat Demo
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                    <a href="<?= htmlspecialchars($waBase) ?>" target="_blank" rel="noopener" class="product-link product-link--ghost">
                        Pesan Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
                <p class="product-note">Desain dan konten disesuaikan penuh — konsultasi gratis sebelum mulai.</p>
            </div>

            <div class="product-card reveal reveal-delay-3">
                <div class="product-icon"><ion-icon name="phone-portrait-outline"></ion-icon></div>
                <h3>Mobile App</h3>
                <p>Aplikasi Android &amp; iOS berbasis Flutter dengan backend Supabase atau Firebase. Dari konsep hingga publish di Play Store / App Store.</p>
                <div class="product-badge-list">
                    <span class="product-badge">Flutter</span>
                    <span class="product-badge">Android &amp; iOS</span>
                    <span class="product-badge">Supabase</span>
                    <span class="product-badge">Push Notifikasi</span>
                </div>
                <a href="<?= htmlspecialchars($waBase) ?>" target="_blank" rel="noopener" class="product-link">
                    Diskusikan Ide Anda
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <p class="product-note">Fitur &amp; estimasi biaya dibahas setelah konsultasi kebutuhan bersama.</p>
            </div>
        </div>
    </div>
</section>

<!-- ─── FEATURES ─────────────────────────────────────────────── -->
<section id="features">
    <div class="container">
        <div class="section-head">
            <div class="section-label reveal">Keunggulan Kami</div>
            <h2 class="section-title reveal reveal-delay-1"><?= $h('features', 'title') ?: 'Kenapa Pilih Digital BnB?' ?></h2>
        </div>
        <div class="features-grid">
            <?php for ($i = 1; $i <= 6; $i++):
                $icon  = $c['features']["feature{$i}_icon"]  ?? '';
                $title = $c['features']["feature{$i}_title"] ?? '';
                $desc  = $c['features']["feature{$i}_desc"]  ?? '';
                if (!$title) continue;
            ?>
            <div class="feature-card reveal reveal-delay-<?= $i ?>">
                <?php if ($icon): ?><div class="feature-icon"><ion-icon name="<?= htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') ?>"></ion-icon></div><?php endif; ?>
                <h3><?= htmlspecialchars($title) ?></h3>
                <p><?= htmlspecialchars($desc) ?></p>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- ─── PORTFOLIO ─────────────────────────────────────────────── -->
<?php if (!empty($portfolio)): ?>
<section id="portfolio">
    <div class="container">
        <div class="section-head">
            <div class="section-label reveal">Karya Terbaik Kami</div>
            <h2 class="section-title reveal reveal-delay-1">Portfolio</h2>
            <p class="section-sub reveal reveal-delay-2">Produk dan proyek yang telah kami bangun untuk berbagai klien di Indonesia.</p>
        </div>

        <?php $categories = array_unique(array_column($portfolio, 'category')); ?>
        <?php if (count($categories) > 1): ?>
        <div class="portfolio-filters reveal">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <?php foreach ($categories as $cat): ?>
            <button class="filter-btn" data-filter="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="portfolio-grid">
            <?php foreach ($portfolio as $i => $item): ?>
            <?php
                $rawImgs = json_decode($item['images'] ?? '[]', true) ?: [];
                // Normalize: support string format (legacy) and {url,caption} format
                $imgs = array_map(fn($img) => is_string($img)
                    ? ['url' => $img, 'caption' => '']
                    : ['url' => $img['url'] ?? '', 'caption' => $img['caption'] ?? ''],
                    $rawImgs
                );
                if (empty($imgs) && $item['image_url']) {
                    $imgs = [['url' => $item['image_url'], 'caption' => '']];
                }
                $hasSlider = count($imgs) > 1;
            ?>
            <div class="portfolio-card reveal reveal-delay-<?= ($i % 3) + 1 ?>"
                 data-category="<?= htmlspecialchars($item['category']) ?>">
                <?php if (!empty($imgs)): ?>
                <div class="portfolio-slider">
                    <div class="slider-track">
                        <?php foreach ($imgs as $img): ?>
                        <img src="<?= htmlspecialchars($img['url']) ?>"
                             data-caption="<?= htmlspecialchars($img['caption']) ?>"
                             alt="<?= htmlspecialchars($item['title']) ?>"
                             loading="lazy">
                        <?php endforeach; ?>
                    </div>
                    <?php if ($hasSlider): ?>
                    <button class="slide-btn slide-prev" aria-label="Sebelumnya">&#8249;</button>
                    <button class="slide-btn slide-next" aria-label="Berikutnya">&#8250;</button>
                    <div class="slide-dots">
                        <?php foreach ($imgs as $di => $_): ?>
                        <button class="slide-dot <?= $di === 0 ? 'active' : '' ?>" aria-label="Foto <?= $di+1 ?>"></button>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="portfolio-thumb" style="background:var(--bg-2);min-height:160px;"></div>
                <?php endif; ?>
                <div class="portfolio-info">
                    <div class="portfolio-meta">
                        <span class="portfolio-cat"><?= htmlspecialchars($item['category']) ?></span>
                        <?php if ($item['platform']): ?>
                        <span class="portfolio-platform">&middot; <?= htmlspecialchars($item['platform']) ?></span>
                        <?php endif; ?>
                        <?php if ($item['is_featured']): ?>
                        <span class="portfolio-featured-badge">Featured</span>
                        <?php endif; ?>
                    </div>
                    <h3><?= htmlspecialchars($item['title']) ?></h3>
                    <?php if ($item['description']): ?>
                    <p><?= htmlspecialchars($item['description']) ?></p>
                    <?php endif; ?>
                    <div class="portfolio-footer">
                        <span class="portfolio-client">
                            <?= $item['client_name'] ? htmlspecialchars($item['client_name']) : '' ?>
                            <?php if ($item['tech_stack']): ?>
                            <br><small style="color:var(--text-3)"><?= htmlspecialchars($item['tech_stack']) ?></small>
                            <?php endif; ?>
                        </span>
                        <?php if ($item['project_url']): ?>
                        <a href="<?= htmlspecialchars($item['project_url']) ?>"
                           target="_blank" rel="noopener" class="portfolio-visit">
                            Lihat
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ─── PROCESS ──────────────────────────────────────────────── -->
<section id="process">
    <div class="container">
        <div class="section-head">
            <div class="section-label reveal">Alur Kerja</div>
            <h2 class="section-title reveal reveal-delay-1"><?= $h('process', 'title') ?: 'Cara Kerja Kami' ?></h2>
        </div>
        <div class="process-steps">
            <?php for ($i = 1; $i <= 4; $i++):
                $t = $c['process']["step{$i}_title"] ?? '';
                $d = $c['process']["step{$i}_desc"]  ?? '';
                if (!$t) continue;
            ?>
            <div class="process-step reveal reveal-delay-<?= $i ?>">
                <div class="process-num"><?= $i ?></div>
                <h3><?= htmlspecialchars($t) ?></h3>
                <p><?= htmlspecialchars($d) ?></p>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- ─── TESTIMONIALS ─────────────────────────────────────────── -->
<?php if (!empty($testimonials)): ?>
<section id="testimonials">
    <div class="container">
        <div class="section-head">
            <div class="section-label reveal">Apa Kata Mereka</div>
            <h2 class="section-title reveal reveal-delay-1">Testimoni Klien</h2>
        </div>
        <div class="testi-grid">
            <?php foreach ($testimonials as $i => $t): ?>
            <div class="testi-card reveal reveal-delay-<?= ($i % 2) + 1 ?>">
                <div class="testi-stars">
                    <?= str_repeat('<span>★</span>', min((int)$t['rating'], 5)) ?>
                </div>
                <p class="testi-text"><?= htmlspecialchars($t['testimonial']) ?></p>
                <div class="testi-author">
                    <?php if ($t['avatar_url']): ?>
                    <img class="testi-avatar"
                         src="<?= htmlspecialchars($t['avatar_url']) ?>"
                         alt="<?= htmlspecialchars($t['client_name']) ?>"
                         loading="lazy">
                    <?php endif; ?>
                    <div>
                        <div class="testi-name"><?= htmlspecialchars($t['client_name']) ?></div>
                        <div class="testi-role"><?= htmlspecialchars(implode(', ', array_filter([$t['client_position'], $t['client_company']]))) ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ─── FAQ ──────────────────────────────────────────────────── -->
<?php if (!empty($faqs)): ?>
<section id="faq">
    <div class="container">
        <div class="section-head">
            <div class="section-label reveal">Pertanyaan Umum</div>
            <h2 class="section-title reveal reveal-delay-1">FAQ</h2>
            <p class="section-sub reveal reveal-delay-2">Belum menemukan jawaban? Hubungi kami langsung via WhatsApp.</p>
        </div>
        <div class="faq-wrap">
            <?php foreach ($faqs as $faq): ?>
            <div class="faq-item reveal">
                <div class="faq-question">
                    <span><?= htmlspecialchars($faq['question']) ?></span>
                    <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="faq-answer">
                    <p><?= htmlspecialchars($faq['answer']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ─── CONTACT ───────────────────────────────────────────────── -->
<section id="contact">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info reveal">
                <div class="section-label" style="margin-bottom:16px">Hubungi Kami</div>
                <h2><?= $h('contact', 'title') ?: 'Ada yang Bisa Kami Bantu?' ?></h2>
                <p class="sub"><?= $h('contact', 'subtitle') ?: 'Ceritakan kebutuhan Anda dan kami siap membantu.' ?></p>

                <div class="contact-detail">
                    <div class="contact-icon"><ion-icon name="mail-outline"></ion-icon></div>
                    <div class="contact-detail-text">
                        <div class="contact-detail-label">Email</div>
                        <a href="mailto:<?= $h('contact', 'email') ?>" class="contact-detail-val"><?= $h('contact', 'email') ?></a>
                    </div>
                </div>
                <div class="contact-detail">
                    <div class="contact-icon"><ion-icon name="call-outline"></ion-icon></div>
                    <div class="contact-detail-text">
                        <div class="contact-detail-label">WhatsApp / Telepon</div>
                        <a href="<?= htmlspecialchars($waBase) ?>" target="_blank" rel="noopener" class="contact-detail-val"><?= $h('contact', 'phone') ?></a>
                    </div>
                </div>
                <div class="contact-detail">
                    <div class="contact-icon"><ion-icon name="location-outline"></ion-icon></div>
                    <div class="contact-detail-text">
                        <div class="contact-detail-label">Lokasi</div>
                        <div class="contact-detail-val"><?= $h('contact', 'address') ?></div>
                    </div>
                </div>
                <div class="contact-detail">
                    <div class="contact-icon"><ion-icon name="logo-instagram"></ion-icon></div>
                    <div class="contact-detail-text">
                        <div class="contact-detail-label">Instagram</div>
                        <a href="https://instagram.com/digitalbnb" target="_blank" rel="noopener" class="contact-detail-val"><?= $h('contact', 'instagram') ?></a>
                    </div>
                </div>
            </div>

            <div class="contact-form-wrap reveal reveal-delay-1">
                <h3>Kirim Pesan</h3>
                <input type="hidden" id="wa-number" value="<?= htmlspecialchars($waNumber) ?>">
                <form id="contactForm" onsubmit="return handleContactSubmit(event)">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Nama Anda" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="email@domain.com" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor WhatsApp</label>
                        <input type="tel" name="phone" placeholder="08xx-xxxx-xxxx" required>
                    </div>
                    <div class="form-group">
                        <label>Pesan / Kebutuhan</label>
                        <textarea name="message" placeholder="Ceritakan kebutuhan bisnis Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Kirim Pesan
                    </button>
                    <div class="form-feedback" id="formFeedback"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ─── CTA BANNER ───────────────────────────────────────────── -->
<section id="cta-banner">
    <div class="container">
        <h2 class="reveal"><?= $h('cta', 'title') ?: 'Siap Go Digital?' ?></h2>
        <p class="reveal reveal-delay-1"><?= $h('cta', 'description') ?: 'Konsultasi gratis, tanpa komitmen. Ceritakan kebutuhan Anda.' ?></p>
        <a href="<?= htmlspecialchars($waBase) ?>" target="_blank" rel="noopener" class="btn-white reveal reveal-delay-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <?= $h('cta', 'button_text') ?: 'Hubungi via WhatsApp' ?>
        </a>
    </div>
</section>

<!-- ─── FOOTER ───────────────────────────────────────────────── -->
<footer>
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand">
                <img src="assets/logo.png" alt="Digital BnB">
                <span class="footer-brand-name">Digital BnB</span>
            </div>
            <div class="footer-links">
                <a href="#products">Produk</a>
                <a href="#portfolio">Portfolio</a>
                <a href="#process">Cara Kerja</a>
                <a href="#faq">FAQ</a>
                <a href="#contact">Kontak</a>
                <a href="admin/dashboard.php">Admin</a>
            </div>
            <div class="footer-social">
                <a href="https://instagram.com/digitalbnb" target="_blank" rel="noopener" title="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                </a>
                <a href="<?= htmlspecialchars($waBase) ?>" target="_blank" rel="noopener" title="WhatsApp">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </a>
            </div>
        </div>
        <div class="footer-bottom">
            <p><?= $h('footer', 'copyright') ?: '© 2026 Digital BnB — BuildNBoost' ?></p>
            <p><?= $h('footer', 'tagline') ?: 'Transforming Ideas into Digital Reality' ?></p>
        </div>
    </div>
</footer>

<!-- ─── LIGHTBOX ──────────────────────────────────────────────── -->
<div id="lightbox" aria-modal="true" role="dialog">
    <button id="lb-close" aria-label="Tutup">&#x2715;</button>
    <button id="lb-prev"  aria-label="Sebelumnya">&#8249;</button>
    <img id="lb-img" src="" alt="Portfolio preview">
    <button id="lb-next"  aria-label="Berikutnya">&#8250;</button>
    <div id="lb-caption"></div>
    <div id="lb-counter"></div>
</div>

<button id="scrollTop" aria-label="Scroll to top">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<script src="js/main.js"></script>
</body>
</html>
