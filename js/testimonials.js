// Testimonials Management JavaScript

function showAddModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Testimonial';
    document.getElementById('testimonialForm').reset();
    document.getElementById('testimonial_id').value = '';
    // Reset preview foto
    const preview = document.getElementById('avatar_preview');
    if (preview) { preview.src = ''; preview.style.display = 'none'; }
    document.getElementById('testimonialModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('testimonialModal').style.display = 'none';
}

function editTestimonial(id) {
    showLoading();
    
    fetch(`api_testimonials.php?action=get&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modalTitle').textContent = 'Edit Testimonial';
                document.getElementById('testimonial_id').value = data.data.id;
                document.getElementById('client_name').value = data.data.client_name;
                document.getElementById('client_position').value = data.data.client_position || '';
                document.getElementById('client_company').value = data.data.client_company || '';
                document.getElementById('testimonial').value = data.data.testimonial;
                const avatarUrl = data.data.avatar_url || '';
                document.getElementById('avatar_url').value = avatarUrl;
                // Tampilkan preview foto yang sudah ada
                const preview = document.getElementById('avatar_preview');
                if (avatarUrl) {
                    preview.src = avatarUrl.startsWith('http') ? avatarUrl : '../' + avatarUrl;
                    preview.style.display = 'block';
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
                document.getElementById('rating').value = data.data.rating;
                document.getElementById('display_order').value = data.data.display_order;
                document.getElementById('is_active').value = data.data.is_active;
                
                document.getElementById('testimonialModal').style.display = 'flex';
            } else {
                showNotification(data.message, 'error');
            }
            hideLoading();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', 'error');
            hideLoading();
        });
}

function deleteTestimonial(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus testimonial ini?')) {
        return;
    }
    
    showLoading();
    
    fetch('api_testimonials.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=delete&id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message, 'error');
        }
        hideLoading();
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan', 'error');
        hideLoading();
    });
}

// Form submission
document.getElementById('testimonialForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Validasi: pastikan gambar sudah diupload
    const avatarVal = document.getElementById('avatar_url').value;
    const testimonialId = document.getElementById('testimonial_id').value;
    if (!avatarVal && !testimonialId) {
        showNotification('Silakan upload foto profil terlebih dahulu', 'error');
        return;
    }

    showLoading();

    const formData = new FormData(this);
    formData.append('action', testimonialId ? 'update' : 'create');

    fetch('api_testimonials.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            closeModal();
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message, 'error');
        }
        hideLoading();
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan', 'error');
        hideLoading();
    });
});


// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('testimonialModal');
    if (event.target == modal) {
        closeModal();
    }
}
