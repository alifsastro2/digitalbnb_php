-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 11, 2026 at 12:38 AM
-- Server version: 10.11.16-MariaDB-cll-lve
-- PHP Version: 8.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diga1463_digital_bnb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$W5VPQsuOO41PjezQM1z88eHubCZsWlvWf4YK20pokgjquijTCBfV2', '2026-02-05 16:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(50) DEFAULT 'General',
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`, `category`, `is_active`, `display_order`, `created_at`) VALUES
(1, 'Berapa lama proses pembuatan website?', 'Waktu pembuatan bervariasi tergantung kompleksitas: Landing Page 3-5 hari, Company Profile 7-10 hari, E-commerce 14-21 hari kerja.', 'Timeline', 1, 1, '2026-02-05 16:05:19'),
(2, 'Apakah harga sudah termasuk domain dan hosting?', 'Ya, semua paket sudah termasuk domain dan hosting sesuai durasi yang tertera di masing-masing paket. Anda tidak perlu bayar tambahan.', 'Pricing', 1, 2, '2026-02-05 16:05:19'),
(3, 'Berapa kali revisi yang bisa dilakukan?', 'Jumlah revisi sesuai paket yang Anda pilih. Revisi major design dihitung, minor text changes tidak dihitung sebagai revisi.', 'Service', 1, 3, '2026-02-05 16:05:19'),
(4, 'Bagaimana cara pembayaran?', 'Kami menerima pembayaran via transfer bank (BCA, Mandiri, BNI) dan e-wallet (GoPay, OVO, Dana). DP 50% di awal, pelunasan sebelum launching.', 'Payment', 1, 4, '2026-02-05 16:05:19'),
(5, 'Apakah website bisa di-update sendiri?', 'Ya, untuk paket Berkembang keatas kami sediakan admin panel sederhana agar Anda bisa update konten sendiri. Kami juga berikan tutorial penggunaannya.', 'Service', 1, 5, '2026-02-05 16:05:19'),
(6, 'Apakah ada garansi setelah website jadi?', 'Ya, kami memberikan garansi maintenance gratis selama 1 bulan pertama untuk bug fixing dan technical support.', 'Support', 1, 6, '2026-02-05 16:05:19'),
(7, 'Bagaimana jika saya ingin fitur tambahan?', 'Silakan konsultasikan kebutuhan fitur tambahan dengan kami. Kami akan berikan quotation tersendiri untuk custom development.', 'Service', 1, 7, '2026-02-05 16:05:19'),
(8, 'Apakah website akan mobile-friendly?', 'Semua website yang kami buat sudah responsive dan mobile-friendly. Tampilan akan menyesuaikan di semua ukuran layar.', 'Technical', 1, 8, '2026-02-05 16:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `features` text NOT NULL,
  `is_popular` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `price`, `description`, `features`, `is_popular`, `is_active`, `display_order`, `created_at`) VALUES
(1, 'Paket Perintis', 'Rp499.000', 'Cocok untuk Anda yang baru memulai dan ingin hadir secara digital dengan tampilan profesional', 'Landing Page|Domain 1 Tahun|Hosting 3 Bulan|Revisi 2x', 0, 1, 1, '2026-02-06 09:13:19'),
(2, 'Paket Berkembang', 'Rp799.000', 'Ideal untuk bisnis yang ingin tampil lebih lengkap dan mulai menjangkau lebih banyak pelanggan', 'Company Profile 4-6 Page|Admin Panel|SEO On-Page|Form|Revisi 3x', 1, 1, 2, '2026-02-06 09:13:19'),
(3, 'Paket Bisnis', 'Rp999.000', 'Solusi untuk bisnis yang membutuhkan sistem lebih canggih dan pengalaman pengguna yang lebih baik', 'Sistem Login|Database|Backup|Revisi 5x', 0, 1, 3, '2026-02-06 09:13:19'),
(4, 'Paket Toko Online', 'Rp1.499.000', 'Buka toko digital Anda 24 jam, terima pesanan, dan kelola penjualan dari mana saja dengan mudah', 'E-Commerce|Checkout|Payment Gateway|Dashboard Penjualan|Training', 0, 1, 4, '2026-02-06 09:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `client_name` varchar(100) DEFAULT NULL,
  `project_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`id`, `title`, `category`, `description`, `image_url`, `client_name`, `project_url`, `is_active`, `display_order`, `created_at`) VALUES
(2, 'Company Profile Elegant', 'Company Profile', 'Website company profile untuk perusahaan konsultan dengan design profesional', 'https://via.placeholder.com/600x400/764ba2/ffffff?text=Company+Profile', 'PT Maju Jaya', NULL, 1, 2, '2026-02-05 16:05:19'),
(4, 'Portfolio Photography', 'Portfolio', 'Website portfolio untuk fotografer dengan galeri dinamis dan booking system', 'https://via.placeholder.com/600x400/4facfe/ffffff?text=Photography', 'Studio Cahaya', NULL, 1, 4, '2026-02-05 16:05:19'),
(5, 'Educational Platform', 'E-Learning', 'Platform belajar online dengan sistem membership dan video streaming', 'https://via.placeholder.com/600x400/43e97b/ffffff?text=E-Learning', 'Belajar Pintar', NULL, 1, 5, '2026-02-05 16:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `site_content`
--

CREATE TABLE `site_content` (
  `id` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `key_name` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_content`
--

INSERT INTO `site_content` (`id`, `section`, `key_name`, `value`, `updated_at`) VALUES
(1, 'hero', 'title', 'Digital BnB', '2026-02-05 16:05:19'),
(2, 'hero', 'subtitle', 'Build & Boost Your Business', '2026-02-05 16:05:19'),
(3, 'hero', 'tagline', 'Mendigitalisasi Bisnis Anda Agar Lebih Profesional', '2026-02-05 18:45:01'),
(4, 'hero', 'cta_text', 'Pesan Sekarang', '2026-02-23 23:20:11'),
(5, 'about', 'title', 'Tentang Kami', '2026-02-05 16:05:19'),
(6, 'about', 'description', 'Digital BnB hadir untuk membantu UMKM naik kelas melalui website modern, cepat, aman, dan profesional. Kami fokus membangun identitas digital yang mampu meningkatkan kepercayaan pelanggan dan memperluas jangkauan bisnis Anda.', '2026-02-05 16:05:19'),
(7, 'features', 'title', 'Kenapa Pilih Kami?', '2026-02-05 16:05:19'),
(8, 'features', 'feature1_title', 'Desain Futuristik', '2026-02-05 16:05:19'),
(9, 'features', 'feature1_desc', 'Website modern dengan tampilan yang eye-catching dan user-friendly', '2026-02-05 16:05:19'),
(10, 'features', 'feature2_title', 'Mobile Friendly', '2026-02-05 16:05:19'),
(11, 'features', 'feature2_desc', 'Responsive di semua device, dari smartphone hingga desktop', '2026-02-05 16:05:19'),
(12, 'features', 'feature3_title', 'SEO Optimized', '2026-02-05 16:05:19'),
(13, 'features', 'feature3_desc', 'Dioptimasi untuk mesin pencari agar mudah ditemukan di Google', '2026-02-05 16:05:19'),
(14, 'features', 'feature4_title', 'Fast Loading', '2026-02-05 16:05:19'),
(15, 'features', 'feature4_desc', 'Kecepatan loading maksimal untuk pengalaman user terbaik', '2026-02-05 16:05:19'),
(16, 'features', 'feature5_title', 'Secure & Safe', '2026-02-05 16:05:19'),
(17, 'features', 'feature5_desc', 'Dilengkapi SSL certificate dan backup rutin untuk keamanan data', '2026-02-05 16:05:19'),
(18, 'features', 'feature6_title', 'Full Support', '2026-02-05 16:05:19'),
(19, 'features', 'feature6_desc', 'Dukungan teknis 24/7 dan maintenance berkala', '2026-02-05 16:05:19'),
(20, 'process', 'title', 'Cara Kerja Kami', '2026-02-05 16:05:19'),
(21, 'process', 'step1_title', 'Konsultasi & Brief', '2026-02-05 16:05:19'),
(22, 'process', 'step1_desc', 'Kami memahami bisnis, target pasar, dan kebutuhan spesifik Anda sebelum memulai', '2026-02-23 22:07:21'),
(23, 'process', 'step2_title', 'Design & Development', '2026-02-05 16:05:19'),
(24, 'process', 'step2_desc', 'Website dirancang sesuai identitas brand Anda, responsif di semua perangkat', '2026-02-23 22:07:21'),
(25, 'process', 'step3_title', 'Review & Revisi', '2026-02-05 16:05:19'),
(26, 'process', 'step3_desc', 'Anda review dan kami revisi sesuai feedback', '2026-02-05 16:05:19'),
(27, 'process', 'step4_title', 'Launch & Support', '2026-02-05 16:05:19'),
(28, 'process', 'step4_desc', 'Website live dan siap diakses, kami dampingi jika ada kendala pasca-launch', '2026-02-23 22:07:21'),
(29, 'pricing', 'title', 'Paket Layanan', '2026-02-05 16:05:19'),
(30, 'pricing', 'paket1_name', 'Paket Perintis', '2026-02-05 16:05:19'),
(31, 'pricing', 'paket1_price', 'Rp499.000', '2026-02-05 16:05:19'),
(32, 'pricing', 'paket1_feature1', 'Landing Page', '2026-02-05 16:05:19'),
(33, 'pricing', 'paket1_feature2', 'Domain 1 Tahun', '2026-02-05 16:05:19'),
(34, 'pricing', 'paket1_feature3', 'Hosting 3 Bulan', '2026-02-05 16:05:19'),
(35, 'pricing', 'paket1_feature4', 'Revisi 2x', '2026-02-05 16:05:19'),
(36, 'pricing', 'paket2_name', 'Paket Berkembang', '2026-02-05 16:05:19'),
(37, 'pricing', 'paket2_price', 'Rp1.299.000', '2026-02-05 16:05:19'),
(38, 'pricing', 'paket2_feature1', 'Company Profile', '2026-02-05 16:05:19'),
(39, 'pricing', 'paket2_feature2', 'Admin Panel', '2026-02-05 16:05:19'),
(40, 'pricing', 'paket2_feature3', 'SEO Basic', '2026-02-05 16:05:19'),
(41, 'pricing', 'paket2_feature4', 'Revisi 3x', '2026-02-05 16:05:19'),
(42, 'pricing', 'paket3_name', 'Paket Bisnis', '2026-02-05 16:05:19'),
(43, 'pricing', 'paket3_price', 'Rp2.999.000', '2026-02-05 16:05:19'),
(44, 'pricing', 'paket3_feature1', 'Sistem Login', '2026-02-05 16:05:19'),
(45, 'pricing', 'paket3_feature2', 'Database', '2026-02-05 16:05:19'),
(46, 'pricing', 'paket3_feature3', 'Backup', '2026-02-05 16:05:19'),
(47, 'pricing', 'paket3_feature4', 'Revisi 5x', '2026-02-05 16:05:19'),
(48, 'pricing', 'paket4_name', 'Toko Online', '2026-02-05 16:05:19'),
(49, 'pricing', 'paket4_price', 'Rp3.499.000', '2026-02-05 16:05:19'),
(50, 'pricing', 'paket4_feature1', 'E-Commerce', '2026-02-05 16:05:19'),
(51, 'pricing', 'paket4_feature2', 'Checkout', '2026-02-05 16:05:19'),
(52, 'pricing', 'paket4_feature3', 'WhatsApp', '2026-02-05 16:05:19'),
(53, 'pricing', 'paket4_feature4', 'Training', '2026-02-05 16:05:19'),
(54, 'cta', 'title', 'Siap Go Digital?', '2026-02-05 16:05:19'),
(55, 'cta', 'description', 'Bangun website profesional sekarang juga', '2026-02-05 16:05:19'),
(56, 'cta', 'button_text', 'Hubungi Kami', '2026-02-05 16:05:19'),
(57, 'cta', 'whatsapp_number', '6289619631221', '2026-02-11 13:50:57'),
(58, 'contact', 'title', 'Hubungi Kami', '2026-02-05 16:05:19'),
(59, 'contact', 'subtitle', 'Punya pertanyaan? Silakan hubungi kami', '2026-02-05 16:05:19'),
(60, 'contact', 'email', 'digitalbnb26@gmail.com', '2026-02-23 21:41:32'),
(61, 'contact', 'phone', '+62 896-1963-1221', '2026-02-23 21:41:32'),
(62, 'contact', 'address', 'Bekasi, Indonesia', '2026-02-23 21:41:32'),
(63, 'contact', 'instagram', '@digitalbnb', '2026-02-05 16:05:19'),
(64, 'footer', 'copyright', '© 2026 Digital BnB - BuildNBoost', '2026-02-05 16:05:19'),
(65, 'footer', 'tagline', 'Transforming Ideas into Digital Reality', '2026-02-05 16:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_position` varchar(100) DEFAULT NULL,
  `client_company` varchar(100) DEFAULT NULL,
  `testimonial` text NOT NULL,
  `rating` int(11) DEFAULT 5,
  `avatar_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `client_position`, `client_company`, `testimonial`, `rating`, `avatar_url`, `is_active`, `display_order`, `created_at`) VALUES
(1, 'Budi Santoso', 'Owner', 'TokoBerkah Store', 'Pelayanan sangat profesional! Website yang dibuat sangat sesuai dengan keinginan saya. Loading cepat dan tampilan modern. Highly recommended!', 5, 'https://ui-avatars.com/api/?name=Budi+Santoso&background=667eea&color=fff&size=200', 1, 1, '2026-02-05 16:05:19'),
(2, 'Siti Rahmawati', 'Marketing Manager', 'PT Maju Jaya', 'Tim Digital BnB sangat responsive dan detail. Hasil website company profile kami melebihi ekspektasi. Terima kasih!', 5, 'https://ui-avatars.com/api/?name=Siti+Rahmawati&background=764ba2&color=fff&size=200', 1, 2, '2026-02-05 16:05:19'),
(3, 'Ahmad Fauzi', 'Chef & Owner', 'Warung Sedap Nusantara', 'Website landing page yang dibuat sangat membantu meningkatkan pesanan online kami. Design-nya eye catching dan mudah digunakan!', 5, 'https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=f093fb&color=fff&size=200', 1, 3, '2026-02-05 16:05:19'),
(4, 'Dian Permata', 'Photographer', 'Studio Cahaya', 'Portfolio website saya sekarang terlihat sangat profesional. Client lebih mudah melihat karya saya. Worth it banget!', 5, 'https://ui-avatars.com/api/?name=Dian+Permata&background=4facfe&color=fff&size=200', 1, 4, '2026-02-05 16:05:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_faq_category` (`category`),
  ADD KEY `idx_faq_active` (`is_active`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_packages_active` (`is_active`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_portfolio_category` (`category`),
  ADD KEY `idx_portfolio_active` (`is_active`);

--
-- Indexes for table `site_content`
--
ALTER TABLE `site_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_content` (`section`,`key_name`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_testimonials_active` (`is_active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `site_content`
--
ALTER TABLE `site_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
