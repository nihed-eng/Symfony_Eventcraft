// Admin Authentication JavaScript

document.addEventListener('DOMContentLoaded', () => {
    // Password strength validation
    const passwordInput = document.getElementById('inputPassword');
    const requirements = {
        length: /^.{8,}$/,
        uppercase: /[A-Z]/,
        lowercase: /[a-z]/,
        number: /[0-9]/
    };

    if (passwordInput) {
        passwordInput.addEventListener('input', (e) => {
            const password = e.target.value;
            const requirementItems = document.querySelectorAll('.password-requirements li');
            
            // Check each requirement
            requirementItems.forEach((item, index) => {
                const requirement = Object.values(requirements)[index];
                if (requirement.test(password)) {
                    item.style.color = '#166534';
                    item.querySelector('::before').style.color = '#166534';
                } else {
                    item.style.color = '#991b1b';
                    item.querySelector('::before').style.color = '#991b1b';
                }
            });
        });
    }

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Remember me checkbox animation
    const rememberMe = document.getElementById('remember_me');
    if (rememberMe) {
        rememberMe.addEventListener('change', (e) => {
            const label = e.target.nextElementSibling;
            if (e.target.checked) {
                label.style.color = 'var(--primary)';
            } else {
                label.style.color = 'var(--text-secondary)';
            }
        });
    }

    // Input focus effects
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.style.transform = 'translateY(-2px)';
        });

        input.addEventListener('blur', () => {
            input.parentElement.style.transform = 'translateY(0)';
        });
    });
});