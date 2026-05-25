// Digital BnB — Main JS (lightweight, no heavy libs)

/* ─── NAVBAR ─────────────────────────────────────────────────── */
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar?.classList.toggle('scrolled', window.scrollY > 40);
}, { passive: true });

/* ─── MOBILE MENU ────────────────────────────────────────────── */
const hamburger = document.getElementById('hamburger');
const navLinks  = document.getElementById('navLinks');

hamburger?.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navLinks?.classList.toggle('mobile-open');
    document.body.style.overflow = navLinks?.classList.contains('mobile-open') ? 'hidden' : '';
});

navLinks?.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        hamburger?.classList.remove('active');
        navLinks.classList.remove('mobile-open');
        document.body.style.overflow = '';
    });
});

/* ─── ACTIVE NAV LINK ────────────────────────────────────────── */
const navSections = document.querySelectorAll('section[id]');
function updateActiveNav() {
    const sy = window.scrollY + 100;
    navSections.forEach(sec => {
        const top  = sec.offsetTop - 120;
        const btm  = top + sec.offsetHeight;
        const link = document.querySelector(`.nav-link[href="#${sec.id}"]`);
        if (link) link.classList.toggle('active', sy >= top && sy < btm);
    });
}
window.addEventListener('scroll', updateActiveNav, { passive: true });

/* ─── SMOOTH SCROLL ──────────────────────────────────────────── */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href === '#') return;
        const target = document.querySelector(href);
        if (target) {
            e.preventDefault();
            const top = target.getBoundingClientRect().top + window.scrollY - 72;
            window.scrollTo({ top, behavior: 'smooth' });
        }
    });
});

/* ─── SCROLL REVEAL (IntersectionObserver) ───────────────────── */
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

/* ─── STATS COUNTER ──────────────────────────────────────────── */
const statObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const raw    = el.dataset.count || el.textContent;
        const num    = parseFloat(raw);
        const suffix = raw.replace(/[\d.]/g, '');
        const isInt  = Number.isInteger(num);
        const dur    = 1800;
        const start  = performance.now();

        function tick(now) {
            const p = Math.min((now - start) / dur, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            const val = num * eased;
            el.textContent = (isInt ? Math.round(val) : val.toFixed(1)) + suffix;
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
        statObserver.unobserve(el);
    });
}, { threshold: 0.6 });

document.querySelectorAll('.stat-num').forEach(el => statObserver.observe(el));

/* ─── LIGHTBOX ───────────────────────────────────────────────── */
const lightbox  = document.getElementById('lightbox');
const lbImg     = document.getElementById('lb-img');
const lbCaption = document.getElementById('lb-caption');
const lbCounter = document.getElementById('lb-counter');
const lbPrev    = document.getElementById('lb-prev');
const lbNext    = document.getElementById('lb-next');
let lbEls = [], lbIndex = 0;

function openLightbox(imgEls, index) {
    lbEls   = imgEls;
    lbIndex = index;
    lbShow();
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
}
function lbShow() {
    const el = lbEls[lbIndex];
    lbImg.src = el.src;
    lbCaption.textContent = el.dataset.caption || '';
    const multi = lbEls.length > 1;
    lbCounter.textContent = multi ? `${lbIndex + 1} / ${lbEls.length}` : '';
    lbPrev.classList.toggle('hidden', !multi);
    lbNext.classList.toggle('hidden', !multi);
}
function lbGo(dir) {
    lbIndex = (lbIndex + dir + lbEls.length) % lbEls.length;
    lbShow();
}

document.getElementById('lb-close').addEventListener('click', closeLightbox);
lbPrev.addEventListener('click', () => lbGo(-1));
lbNext.addEventListener('click', () => lbGo(1));
lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
document.addEventListener('keydown', e => {
    if (!lightbox.classList.contains('open')) return;
    if (e.key === 'Escape')      closeLightbox();
    if (e.key === 'ArrowLeft')   lbGo(-1);
    if (e.key === 'ArrowRight')  lbGo(1);
});

/* ─── PORTFOLIO SLIDER ───────────────────────────────────────── */
document.querySelectorAll('.portfolio-slider').forEach(slider => {
    const track  = slider.querySelector('.slider-track');
    const imgEls = Array.from(track.querySelectorAll('img'));
    const dots   = slider.querySelectorAll('.slide-dot');
    const multi  = imgEls.length > 1;

    let cur = 0;
    function go(n) {
        cur = (n + imgEls.length) % imgEls.length;
        track.style.transform = `translateX(-${cur * 100}%)`;
        dots.forEach((d, i) => d.classList.toggle('active', i === cur));
    }

    if (multi) {
        slider.querySelector('.slide-prev')?.addEventListener('click', e => { e.stopPropagation(); go(cur - 1); });
        slider.querySelector('.slide-next')?.addEventListener('click', e => { e.stopPropagation(); go(cur + 1); });
        dots.forEach((d, i) => d.addEventListener('click', e => { e.stopPropagation(); go(i); }));
    }

    imgEls.forEach((img, i) => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', () => openLightbox(imgEls, i));
    });
});

/* ─── PORTFOLIO FILTER ───────────────────────────────────────── */
const filterBtns  = document.querySelectorAll('.filter-btn');
const portCards   = document.querySelectorAll('.portfolio-card');

filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const cat = btn.dataset.filter;

        portCards.forEach(card => {
            const match = cat === 'all' || card.dataset.category === cat;
            card.classList.toggle('hidden', !match);
        });
    });
});

/* ─── FAQ ACCORDION ──────────────────────────────────────────── */
document.querySelectorAll('.faq-question').forEach(q => {
    q.addEventListener('click', () => {
        const item   = q.closest('.faq-item');
        const answer = item.querySelector('.faq-answer');
        const isOpen = q.classList.contains('active');

        // close all
        document.querySelectorAll('.faq-question.active').forEach(oq => {
            oq.classList.remove('active');
            oq.closest('.faq-item').querySelector('.faq-answer').classList.remove('active');
        });

        if (!isOpen) {
            q.classList.add('active');
            answer.classList.add('active');
        }
    });
});

/* ─── CONTACT FORM → WHATSAPP ────────────────────────────────── */
function handleContactSubmit(event) {
    event.preventDefault();
    const form    = document.getElementById('contactForm');
    const btn     = form.querySelector('.btn-submit');
    const name    = form.name.value.trim();
    const email   = form.email.value.trim();
    const phone   = form.phone.value.trim();
    const message = form.message.value.trim();

    if (!name || !email || !phone || !message) {
        showFeedback('error', 'Mohon lengkapi semua field.');
        return false;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showFeedback('error', 'Format email tidak valid.');
        return false;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span> Mengirim...';
    hideFeedback();

    setTimeout(() => {
        const waNum  = document.getElementById('wa-number')?.value || '6289619631221';
        const waText = encodeURIComponent(
            `Halo Digital BnB! Saya ingin konsultasi.\n\nNama: ${name}\nEmail: ${email}\nNo. WA: ${phone}\n\nPesan:\n${message}`
        );
        window.open(`https://wa.me/${waNum}?text=${waText}`, '_blank');
        btn.disabled = false;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Kirim Pesan';
        form.reset();
        showFeedback('success', 'Pesan terkirim! Lanjutkan chat di WhatsApp ya.');
        setTimeout(hideFeedback, 7000);
    }, 800);

    return false;
}

function showFeedback(type, message) {
    const el = document.getElementById('formFeedback');
    if (!el) return;
    el.className = 'form-feedback ' + type;
    el.innerHTML = `<span>${message}</span>`;
    el.style.display = 'flex';
}
function hideFeedback() {
    const el = document.getElementById('formFeedback');
    if (!el) return;
    el.style.display = 'none';
    el.className = 'form-feedback';
}

/* ─── SCROLL TO TOP ──────────────────────────────────────────── */
const scrollTopBtn = document.getElementById('scrollTop');
window.addEventListener('scroll', () => {
    scrollTopBtn?.classList.toggle('visible', window.scrollY > 500);
}, { passive: true });

scrollTopBtn?.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
