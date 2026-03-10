// FAQ Management JavaScript

function showAddModal() {
    document.getElementById('modalTitle').textContent = 'Tambah FAQ';
    document.getElementById('faqForm').reset();
    document.getElementById('faq_id').value = '';
    document.getElementById('faqModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('faqModal').style.display = 'none';
}

function editFaq(id) {
    showLoading();
    
    fetch(`api_faq.php?action=get&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modalTitle').textContent = 'Edit FAQ';
                document.getElementById('faq_id').value = data.data.id;
                document.getElementById('question').value = data.data.question;
                document.getElementById('answer').value = data.data.answer;
                document.getElementById('category').value = data.data.category;
                document.getElementById('display_order').value = data.data.display_order;
                document.getElementById('is_active').value = data.data.is_active;
                
                document.getElementById('faqModal').style.display = 'flex';
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

function deleteFaq(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus FAQ ini?')) {
        return;
    }
    
    showLoading();
    
    fetch('api_faq.php', {
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
document.getElementById('faqForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    showLoading();
    
    const formData = new FormData(this);
    const id = document.getElementById('faq_id').value;
    formData.append('action', id ? 'update' : 'create');
    
    fetch('api_faq.php', {
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
    const modal = document.getElementById('faqModal');
    if (event.target == modal) {
        closeModal();
    }
}
