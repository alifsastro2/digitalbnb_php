/**
 * CropUploader — Reusable image crop & upload module
 * Requires: Cropper.js (loaded via CDN)
 *
 * Usage:
 *   const uploader = new CropUploader({
 *     triggerEl:    '#btn-upload',          // tombol pemicu
 *     previewEl:    '#img-preview',         // <img> preview hasil crop
 *     hiddenInput:  '#avatar_url',          // <input hidden> tempat URL hasil
 *     folder:       'profil_testimoni',     // folder tujuan di server
 *     aspectRatio:  1,                      // 1 = square (1:1)
 *   });
 */

class CropUploader {
    constructor(options) {
        this.opts = Object.assign({
            triggerEl:   null,
            previewEl:   null,
            hiddenInput: null,
            folder:      'profil_testimoni',
            aspectRatio: 1,
            uploadUrl:   'api_upload.php',
        }, options);

        this.cropper     = null;
        this.modalEl     = null;
        this.fileInput   = null;

        this._init();
    }

    _init() {
        // Inject Cropper.js CSS jika belum ada
        if (!document.querySelector('link[href*="cropper"]')) {
            const link = document.createElement('link');
            link.rel  = 'stylesheet';
            link.href = 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css';
            document.head.appendChild(link);
        }

        // Inject Cropper.js JS jika belum ada
        if (!window.Cropper) {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js';
            document.head.appendChild(script);
        }

        // Buat hidden file input
        this.fileInput = document.createElement('input');
        this.fileInput.type   = 'file';
        this.fileInput.accept = 'image/jpeg,image/png,image/webp';
        this.fileInput.style.display = 'none';
        document.body.appendChild(this.fileInput);

        // Buat modal crop
        this._buildModal();

        // Bind trigger
        const trigger = document.querySelector(this.opts.triggerEl);
        if (trigger) {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                this.fileInput.click();
            });
        }

        // Saat file dipilih
        this.fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;

            // Validasi ukuran sebelum crop (maks 10MB raw)
            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file terlalu besar (maks 10MB)');
                this.fileInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (ev) => {
                this._openCropModal(ev.target.result);
            };
            reader.readAsDataURL(file);
            this.fileInput.value = '';
        });
    }

    _buildModal() {
        const modal = document.createElement('div');
        modal.id = 'cropUploaderModal';
        modal.innerHTML = `
            <div class="cup-overlay">
                <div class="cup-box">
                    <div class="cup-header">
                        <h3>✂️ Crop Gambar (1:1)</h3>
                        <button class="cup-close" id="cupClose">&times;</button>
                    </div>
                    <div class="cup-body">
                        <div class="cup-canvas-wrap">
                            <img id="cupImage" src="" alt="crop">
                        </div>
                        <p class="cup-hint">Geser & zoom untuk menyesuaikan area crop</p>
                    </div>
                    <div class="cup-footer">
                        <button class="cup-btn-cancel" id="cupCancel">Batal</button>
                        <button class="cup-btn-crop"   id="cupApply">✔ Crop & Upload</button>
                    </div>
                    <div class="cup-progress" id="cupProgress" style="display:none">
                        <div class="cup-progress-bar" id="cupProgressBar"></div>
                        <span id="cupProgressText">Mengupload...</span>
                    </div>
                </div>
            </div>
        `;

        // Inject styles
        const style = document.createElement('style');
        style.textContent = `
            #cropUploaderModal { display:none; position:fixed; inset:0; z-index:99999; }
            .cup-overlay { width:100%; height:100%; background:rgba(0,0,0,0.85); display:flex; align-items:center; justify-content:center; padding:20px; box-sizing:border-box; }
            .cup-box { background:#0d1117; border:1px solid rgba(0,212,255,0.3); border-radius:16px; width:100%; max-width:520px; overflow:hidden; box-shadow:0 0 40px rgba(0,212,255,0.2); }
            .cup-header { display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid rgba(255,255,255,0.1); }
            .cup-header h3 { margin:0; color:#00d4ff; font-size:1rem; font-family:'Poppins',sans-serif; }
            .cup-close { background:none; border:none; color:#aaa; font-size:1.5rem; cursor:pointer; line-height:1; padding:0; }
            .cup-close:hover { color:#fff; }
            .cup-body { padding:20px; }
            .cup-canvas-wrap { width:100%; height:360px; background:#111; border-radius:8px; overflow:hidden; }
            .cup-canvas-wrap img { display:block; max-width:100%; }
            .cup-hint { text-align:center; color:#888; font-size:0.8rem; margin:10px 0 0; font-family:'Poppins',sans-serif; }
            .cup-footer { display:flex; gap:12px; padding:16px 20px; border-top:1px solid rgba(255,255,255,0.1); }
            .cup-btn-cancel { flex:1; padding:10px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); color:#ccc; border-radius:8px; cursor:pointer; font-family:'Poppins',sans-serif; transition:all .2s; }
            .cup-btn-cancel:hover { background:rgba(255,255,255,0.15); }
            .cup-btn-crop { flex:2; padding:10px; background:linear-gradient(135deg,#00d4ff,#8000ff); border:none; color:#fff; border-radius:8px; cursor:pointer; font-weight:600; font-family:'Poppins',sans-serif; transition:opacity .2s; }
            .cup-btn-crop:hover { opacity:.85; }
            .cup-btn-crop:disabled { opacity:.5; cursor:not-allowed; }
            .cup-progress { padding:12px 20px; background:rgba(0,212,255,0.05); }
            .cup-progress-bar { height:4px; background:rgba(255,255,255,0.1); border-radius:2px; overflow:hidden; margin-bottom:6px; }
            .cup-progress-bar::after { content:''; display:block; height:100%; width:0%; background:linear-gradient(90deg,#00d4ff,#8000ff); border-radius:2px; animation:cupFill 1.5s ease-in-out infinite; }
            @keyframes cupFill { 0%{width:0%} 50%{width:70%} 100%{width:100%} }
            .cup-progress span { color:#00d4ff; font-size:0.8rem; font-family:'Poppins',sans-serif; }

            /* Preview image style */
            .cup-preview-img { width:80px; height:80px; border-radius:50%; object-fit:cover; border:2px solid rgba(0,212,255,0.4); }
            .cup-preview-rect { width:120px; height:80px; border-radius:8px; object-fit:cover; border:2px solid rgba(0,212,255,0.4); }
        `;
        document.head.appendChild(style);
        document.body.appendChild(modal);
        this.modalEl = modal;

        // Events
        document.getElementById('cupClose').addEventListener('click',  () => this._closeCropModal());
        document.getElementById('cupCancel').addEventListener('click', () => this._closeCropModal());
        document.getElementById('cupApply').addEventListener('click',  () => this._doCropAndUpload());
    }

    _openCropModal(src) {
        const img = document.getElementById('cupImage');
        img.src = src;
        this.modalEl.style.display = 'block';

        // Tunggu Cropper.js siap
        const tryInit = () => {
            if (!window.Cropper) { setTimeout(tryInit, 100); return; }

            if (this.cropper) { this.cropper.destroy(); }
            this.cropper = new Cropper(img, {
                aspectRatio:    this.opts.aspectRatio,
                viewMode:       1,
                dragMode:       'move',
                autoCropArea:   0.85,
                responsive:     true,
                restore:        false,
                guides:         true,
                highlight:      true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        };
        tryInit();
    }

    _closeCropModal() {
        this.modalEl.style.display = 'none';
        if (this.cropper) { this.cropper.destroy(); this.cropper = null; }
        document.getElementById('cupProgress').style.display = 'none';
        document.getElementById('cupApply').disabled = false;
    }

    _doCropAndUpload() {
        if (!this.cropper) return;

        const applyBtn   = document.getElementById('cupApply');
        const progressEl = document.getElementById('cupProgress');

        applyBtn.disabled = true;
        progressEl.style.display = 'block';

        // Ambil canvas hasil crop (output 600x600 max)
        const canvas = this.cropper.getCroppedCanvas({
            width:  600,
            height: 600,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        // Konversi ke base64 JPEG kualitas 85%
        const imageData = canvas.toDataURL('image/jpeg', 0.85);

        // Kirim ke server
        const formData = new FormData();
        formData.append('image_data', imageData);
        formData.append('folder',     this.opts.folder);

        fetch(this.opts.uploadUrl, {
            method: 'POST',
            body:   formData,
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Set hidden input value
                const hidden = document.querySelector(this.opts.hiddenInput);
                if (hidden) hidden.value = data.url;

                // Update preview image
                const preview = document.querySelector(this.opts.previewEl);
                if (preview) {
                    preview.src = data.preview_url;
                    preview.style.display = 'block';
                }

                this._closeCropModal();

                // Tampilkan notifikasi sukses
                if (typeof showNotification === 'function') {
                    showNotification('✓ Gambar berhasil diupload!');
                }
            } else {
                alert('Upload gagal: ' + data.message);
                applyBtn.disabled = false;
                progressEl.style.display = 'none';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat upload');
            applyBtn.disabled = false;
            progressEl.style.display = 'none';
        });
    }
}
