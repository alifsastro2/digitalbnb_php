// Packages Management JavaScript

function showAddModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Paket';
    document.getElementById('packageForm').reset();
    document.getElementById('package_id').value = '';
    document.getElementById('packageModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('packageModal').style.display = 'none';
}

function editPackage(id) {
    showLoading();
    
    fetch(`api_packages.php?action=get&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modalTitle').textContent = 'Edit Paket';
                document.getElementById('package_id').value = data.data.id;
                document.getElementById('package_name').value = data.data.package_name;
                document.getElementById('price').value = data.data.price;
                document.getElementById('description').value = data.data.description || '';
                
                // Convert features from pipe-separated to newline-separated
                const features = data.data.features.split('|').join('\n');
                document.getElementById('features').value = features;
                
                document.getElementById('is_popular').checked = data.data.is_popular == 1;
                document.getElementById('display_order').value = data.data.display_order;
                document.getElementById('is_active').value = data.data.is_active;
                
                document.getElementById('packageModal').style.display = 'flex';
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

function deletePackage(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus paket ini?')) {
        return;
    }
    
    showLoading();
    
    fetch('api_packages.php', {
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
document.getElementById('packageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    showLoading();
    
    const formData = new FormData(this);
    const id = document.getElementById('package_id').value;
    formData.append('action', id ? 'update' : 'create');
    
    // Convert features from newline-separated to pipe-separated
    const features = formData.get('features');
    const featuresArray = features.split('\n').filter(f => f.trim() !== '');
    formData.set('features', featuresArray.join('|'));
    
    // Handle checkbox
    if (!document.getElementById('is_popular').checked) {
        formData.set('is_popular', '0');
    }
    
    fetch('api_packages.php', {
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
    const modal = document.getElementById('packageModal');
    if (event.target == modal) {
        closeModal();
    }
}
