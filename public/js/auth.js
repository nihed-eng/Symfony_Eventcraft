// Authentication Pages JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // GSAP animations for auth pages
    if (typeof gsap !== 'undefined') {
        // Login/Register form animation
        gsap.from('.auth-form-wrapper', {
            opacity: 0,
            y: 30,
            duration: 0.8,
            ease: 'power3.out'
        });
        
        // Banner content animation
        gsap.from('.banner-content h1', {
            opacity: 0,
            y: -20,
            duration: 0.8,
            delay: 0.2,
            ease: 'power3.out'
        });
        
        gsap.from('.banner-content p', {
            opacity: 0,
            y: -10,
            duration: 0.8,
            delay: 0.4,
            ease: 'power3.out'
        });
        
        gsap.from('.banner-content img', {
            opacity: 0,
            scale: 0.9,
            duration: 1,
            delay: 0.6,
            ease: 'power3.out'
        });
    }
    
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
    
    // Password visibility toggle
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = document.querySelector(this.getAttribute('data-target'));
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            // Toggle icon
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });
    
    // Password strength meter
    const passwordInput = document.getElementById('registration_form_plainPassword');
    const strengthMeter = document.getElementById('password-strength-meter');
    
    if (passwordInput && strengthMeter) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
            if (password.match(/\d/)) strength += 1;
            if (password.match(/[^a-zA-Z\d]/)) strength += 1;
            
            // Update strength meter
            strengthMeter.value = strength;
            
            // Update strength text
            const strengthText = document.getElementById('password-strength-text');
            if (strengthText) {
                const texts = ['Weak', 'Fair', 'Good', 'Strong', 'Very Strong'];
                strengthText.textContent = texts[strength];
                
                // Update color
                const colors = ['#ff4d4d', '#ffaa00', '#ffff00', '#00cc00', '#00cc00'];
                strengthText.style.color = colors[strength];
            }
        });
    }
});
