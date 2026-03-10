// Particles.js Configuration
particlesJS('particles-js', {
    particles: {
        number: {
            value: 60,
            density: {
                enable: true,
                value_area: 800
            }
        },
        color: {
            value: ['#00d4ff', '#8000ff']
        },
        shape: {
            type: 'circle'
        },
        opacity: {
            value: 0.3,
            random: true
        },
        size: {
            value: 3,
            random: true
        },
        line_linked: {
            enable: true,
            distance: 150,
            color: '#00d4ff',
            opacity: 0.2,
            width: 1
        },
        move: {
            enable: true,
            speed: 1.5,
            direction: 'none',
            random: true,
            out_mode: 'out'
        }
    },
    interactivity: {
        detect_on: 'canvas',
        events: {
            onhover: {
                enable: true,
                mode: 'grab'
            },
            resize: true
        }
    },
    retina_detect: true
});

// Show Notification
function showNotification(message, isError = false) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.classList.remove('error');
    
    if (isError) {
        notification.classList.add('error');
    }
    
    notification.classList.add('show');
    
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

// Show Loading Overlay
function showLoading(show = true) {
    const overlay = document.getElementById('loadingOverlay');
    if (show) {
        overlay.classList.add('show');
    } else {
        overlay.classList.remove('show');
    }
}


function hideLoading() {
    showLoading(false);
}

// Scroll to Section
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// AJAX Form Submit Handler
document.querySelectorAll('.edit-form').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const section = this.getAttribute('data-section');
        const submitBtn = this.querySelector('.btn-save');
        const originalText = submitBtn.textContent;
        
        // Disable button
        submitBtn.disabled = true;
        submitBtn.textContent = '⏳ Menyimpan...';
        
        // Collect form data
        const formData = new FormData();
        formData.append('section', section);
        
        // Get all inputs and textareas
        const inputs = this.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            const key = input.getAttribute('data-key');
            const value = input.value;
            formData.append(key, value);
        });
        
        try {
            showLoading(true);
            
            // Send AJAX request
            const response = await fetch('update_content.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            showLoading(false);
            
            if (result.success) {
                showNotification('✓ ' + result.message);
                
                // Add success animation to form
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            } else {
                showNotification('✗ ' + result.message, true);
            }
            
        } catch (error) {
            showLoading(false);
            showNotification('✗ Terjadi kesalahan: ' + error.message, true);
        } finally {
            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});

// Input Animation on Focus
document.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
        this.parentElement.style.transition = 'transform 0.3s ease';
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });
});

// Auto-save on input change (debounced)
let autoSaveTimeout;
document.querySelectorAll('.edit-form input, .edit-form textarea').forEach(input => {
    input.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        
        // Show indicator that changes are pending
        this.style.borderColor = '#ffaa00';
        
        autoSaveTimeout = setTimeout(() => {
            this.style.borderColor = '';
        }, 1000);
    });
});

// Keyboard Shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl+S or Cmd+S to save current form
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        
        // Find the focused form or the first form
        const activeElement = document.activeElement;
        const form = activeElement.closest('.edit-form') || document.querySelector('.edit-form');
        
        if (form) {
            form.querySelector('.btn-save').click();
        }
    }
});

// Add smooth transitions on page load
window.addEventListener('load', function() {
    document.querySelectorAll('.content-section').forEach((section, index) => {
        setTimeout(() => {
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Confirmation before leaving with unsaved changes
let hasUnsavedChanges = false;

document.querySelectorAll('.edit-form input, .edit-form textarea').forEach(input => {
    input.addEventListener('change', function() {
        hasUnsavedChanges = true;
    });
});

document.querySelectorAll('.edit-form').forEach(form => {
    form.addEventListener('submit', function() {
        hasUnsavedChanges = false;
    });
});

window.addEventListener('beforeunload', function(e) {
    if (hasUnsavedChanges) {
        e.preventDefault();
        e.returnValue = '';
        return '';
    }
});

// Console welcome message
console.log('%c🚀 Digital BnB Admin Panel', 'color: #00d4ff; font-size: 20px; font-weight: bold;');
console.log('%cSelamat datang di sistem manajemen konten futuristik!', 'color: #8000ff; font-size: 14px;');
