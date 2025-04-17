// Main JavaScript file for EventCraft

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize Bootstrap popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Flash message animations
    const flashMessages = document.querySelectorAll('.alert');
    flashMessages.forEach(message => {
        // Auto-dismiss flash messages after 5 seconds
        setTimeout(() => {
            const alert = bootstrap.Alert.getOrCreateInstance(message);
            alert.close();
        }, 5000);
    });

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // Shake animation for invalid form
                form.classList.add('animate__animated', 'animate__headShake');
                setTimeout(() => {
                    form.classList.remove('animate__animated', 'animate__headShake');
                }, 1000);
            }
            
            form.classList.add('was-validated');
        }, false);
    });

    // GSAP animations for page elements
    if (typeof gsap !== 'undefined') {
        // Animate navbar items
        gsap.from('.navbar-nav .nav-item', {
            opacity: 0,
            y: -20,
            stagger: 0.1,
            duration: 0.5,
            ease: 'power2.out',
            delay: 0.2
        });
        
        // Animate main content
        gsap.from('main .container > *', {
            opacity: 0,
            y: 20,
            stagger: 0.1,
            duration: 0.5,
            ease: 'power2.out',
            delay: 0.3
        });
    }
});
