// Portfolio Management JavaScript

function showAddModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Portfolio';
    document.getElementById('portfolioForm').reset();
    document.getElementById('portfolio_id').value = '';
    // Reset preview
    const preview = document.getElementById('portfolio_img_preview');
    if (preview) { preview.src = ''; preview.style.display = 'none'; }
    document.getElementById('portfolioModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('portfolioModal').style.display = 'none';
}

function editPortfolio(id) {
    showLoading();
    
    fetch(`api_portfolio.php?action=get&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modalTitle').textContent = 'Edit Portfolio';
                document.getElementById('portfolio_id').value = data.data.id;
                document.getElementById('title').value = data.data.title;
                document.getElementById('category').value = data.data.category;
                document.getElementById('description').value = data.data.description || '';
                const imgUrl = data.data.image_url || '';
                document.getElementById('image_url').value = imgUrl;
                // Tampilkan preview gambar yang sudah ada
                const preview = document.getElementById('portfolio_img_preview');
                if (imgUrl) {
                    preview.src = imgUrl.startsWith('http') ? imgUrl : '../' + imgUrl;
                    preview.style.display = 'block';
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
                document.getElementById('client_name').value = data.data.client_name || '';
                document.getElementById('project_url').value = data.data.project_url || '';
                document.getElementById('display_order').value = data.data.display_order;
                document.getElementById('is_active').value = data.data.is_active;
                
                document.getElementById('portfolioModal').style.display = 'flex';
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

function deletePortfolio(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus portfolio ini?')) {
        return;
    }
    
    showLoading();
    
    fetch('api_portfolio.php', {
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
document.getElementById('portfolioForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Validasi: pastikan gambar sudah diupload
    const imgVal = document.getElementById('image_url').value;
    const portfolioId = document.getElementById('portfolio_id').value;
    if (!imgVal) {
        showNotification('Silakan upload gambar portfolio terlebih dahulu', 'error');
        return;
    }

    showLoading();

    const formData = new FormData(this);
    formData.append('action', portfolioId ? 'update' : 'create');

    fetch('api_portfolio.php', {
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
    const modal = document.getElementById('portfolioModal');
    if (event.target == modal) {
        closeModal();
    }
}
