// ============================================
// StoreOman Admin Dashboard JavaScript
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    menuToggle.addEventListener('click', () => {
        sidebar.classList.add('open');
    });
    
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.remove('open');
    });

    // Page Navigation
    const navLinks = document.querySelectorAll('.sidebar-nav .nav-link');
    const pages = document.querySelectorAll('.page-content');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const pageName = this.getAttribute('data-page');
            
            // Update active nav item
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            this.closest('.nav-item').classList.add('active');
            
            // Show corresponding page
            pages.forEach(page => {
                page.classList.add('hidden');
            });
            
            const targetPage = document.getElementById(`${pageName}-page`);
            if (targetPage) {
                targetPage.classList.remove('hidden');
            }
            
            // Close sidebar on mobile
            if (window.innerWidth < 992) {
                sidebar.classList.remove('open');
            }
        });
    });

    // Select All Checkbox
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.products-table tbody input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Counter Animation
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-value');
        counters.forEach(counter => {
            const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
            if (isNaN(target)) return;
            
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    counter.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(current).toLocaleString();
                }
            }, 30);
        });
    }
    
    animateCounters();

    // Chart Bars Animation
    const bars = document.querySelectorAll('.bar');
    bars.forEach((bar, index) => {
        const height = bar.style.height;
        bar.style.height = '0';
        setTimeout(() => {
            bar.style.transition = 'height 0.5s ease';
            bar.style.height = height;
        }, index * 100);
    });

    // Notification Click
    const notificationBtn = document.querySelector('.notification-btn');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', () => {
            alert('لديك 3 إشعارات جديدة');
        });
    }

    // Action Buttons
    document.querySelectorAll('.action-btn.delete').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('هل أنت متأكد من حذف هذا العنصر؟')) {
                const row = this.closest('tr');
                if (row) {
                    row.style.animation = 'fadeOut 0.3s ease';
                    setTimeout(() => {
                        row.remove();
                    }, 300);
                }
            }
        });
    });

    document.querySelectorAll('.action-btn.view').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const productName = row.querySelector('.product-name h4, .customer-name');
            if (productName) {
                alert(`عرض تفاصيل: ${productName.textContent}`);
            }
        });
    });

    document.querySelectorAll('.action-btn.edit').forEach(btn => {
        btn.addEventListener('click', function() {
            alert('سيتم فتح نموذج التعديل');
        });
    });

    // File Upload
    const fileUpload = document.querySelector('.file-upload');
    if (fileUpload) {
        fileUpload.addEventListener('click', function() {
            this.querySelector('input').click();
        });
        
        const fileInput = fileUpload.querySelector('input');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const fileName = Array.from(this.files).map(f => f.name).join(', ');
                    fileUpload.querySelector('span').textContent = fileName;
                }
            });
        }
    }

    // Settings Form
    const settingsForm = document.querySelector('.settings-section');
    if (settingsForm) {
        const saveBtn = settingsForm.querySelector('.btn-primary');
        if (saveBtn) {
            saveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showNotification('تم حفظ الإعدادات بنجاح', 'success');
            });
        }
    }

    // Search Filter
    const searchFilter = document.querySelector('.search-filter input');
    if (searchFilter) {
        searchFilter.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.products-table tbody tr, .orders-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Theme Toggle (Dark Mode)
    const themeBtn = document.querySelector('.header-actions .action-btn:not(.notification-btn)');
    if (themeBtn) {
        themeBtn.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const icon = this.querySelector('i');
            if (document.body.classList.contains('dark-mode')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        });
    }
});

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Close modal when clicking outside
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});

// Notification Function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `admin-notification ${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => notification.classList.add('show'), 10);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add notification styles
const notificationStyles = document.createElement('style');
notificationStyles.textContent = `
    .admin-notification {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-100px);
        background: var(--white);
        padding: 1rem 2rem;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        z-index: 9999;
        transition: transform 0.3s ease;
    }
    
    .admin-notification.show {
        transform: translateX(-50%) translateY(0);
    }
    
    .admin-notification.success i { color: var(--success); }
    .admin-notification.error i { color: var(--danger); }
    .admin-notification.info i { color: var(--info); }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
document.head.appendChild(notificationStyles);

// Add product form submission
document.querySelector('.product-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    showNotification('تم إضافة المنتج بنجاح', 'success');
    closeModal('addProductModal');
});
