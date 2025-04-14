// Profile Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize GSAP animations
    gsap.from('.profile-image-wrapper', {
        scale: 0.8,
        opacity: 0,
        duration: 0.5,
        ease: 'power2.out'
    });

    gsap.from('.card', {
        y: 30,
        opacity: 0,
        duration: 0.5,
        stagger: 0.1,
        ease: 'power2.out'
    });

    // Handle tab navigation
    const tabLinks = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]');
    tabLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Update URL without page reload
            const tabId = this.getAttribute('href').substring(1);
            history.pushState(null, '', `/profile/${tabId.replace('profile-', '')}`);
        });
    });

    // Handle form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enregistrement...';
            submitBtn.disabled = true;

            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show animate__animated animate__fadeIn';
                alert.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>Modifications enregistrées avec succès
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                form.insertAdjacentElement('beforebegin', alert);

                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                // Auto-dismiss alert
                setTimeout(() => {
                    alert.classList.add('animate__fadeOut');
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }, 1000);
        });
    });

    // Handle file upload for profile picture
    const profilePicBtn = document.querySelector('.btn-outline-primary');
    if (profilePicBtn) {
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = 'image/*';
        fileInput.style.display = 'none';
        document.body.appendChild(fileInput);

        profilePicBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const profileImage = document.querySelector('.profile-image') || document.querySelector('.profile-image-placeholder');
                    if (profileImage.tagName === 'IMG') {
                        profileImage.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'profile-image rounded-circle';
                        profileImage.parentNode.replaceChild(img, profileImage);
                    }
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Handle mobile navigation
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.dashboard-sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }

    // Handle responsive behavior
    function handleResponsive() {
        if (window.innerWidth <= 768) {
            sidebar?.classList.remove('show');
        }
    }

    window.addEventListener('resize', handleResponsive);
    handleResponsive();
});
