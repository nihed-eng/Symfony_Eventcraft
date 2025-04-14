// Dashboard Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // GSAP animations for dashboard elements
    if (typeof gsap !== 'undefined') {
        // Welcome card animation
        gsap.from('.welcome-card', {
            opacity: 0,
            y: 20,
            duration: 0.6,
            ease: 'power2.out'
        });
        
        // Stats cards animation with stagger
        gsap.from('.stat-card', {
            opacity: 0,
            y: 30,
            duration: 0.6,
            stagger: 0.1,
            ease: 'power2.out',
            delay: 0.2
        });
        
        // Recent events animation
        gsap.from('.recent-events .card', {
            opacity: 0,
            y: 20,
            duration: 0.6,
            ease: 'power2.out',
            delay: 0.5
        });
        
        // Initialize GSAP animations
        gsap.from('.dashboard-sidebar', {
            x: -100,
            opacity: 0,
            duration: 0.5,
            ease: 'power2.out'
        });

        gsap.from('.stat-card', {
            y: 30,
            opacity: 0,
            duration: 0.5,
            stagger: 0.1,
            ease: 'power2.out'
        });

        gsap.from('.action-card', {
            y: 30,
            opacity: 0,
            duration: 0.5,
            stagger: 0.1,
            delay: 0.3,
            ease: 'power2.out'
        });
    }
    
    // Initialize charts if Chart.js is available
    if (typeof Chart !== 'undefined') {
        // Activity chart
        const activityCtx = document.getElementById('activityChart');
        if (activityCtx) {
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Events Created',
                        data: [5, 10, 8, 15, 12, 14],
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Events Attended',
                        data: [7, 12, 15, 10, 8, 9],
                        borderColor: '#ec4899',
                        backgroundColor: 'rgba(236, 72, 153, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        
        // Event types chart
        const eventTypesCtx = document.getElementById('eventTypesChart');
        if (eventTypesCtx) {
            new Chart(eventTypesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Conferences', 'Workshops', 'Meetups', 'Webinars', 'Other'],
                    datasets: [{
                        data: [30, 25, 20, 15, 10],
                        backgroundColor: [
                            '#6366f1',
                            '#ec4899',
                            '#10b981',
                            '#0ea5e9',
                            '#f59e0b'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    },
                    cutout: '70%'
                }
            });
        }
    }
    
    // Handle mobile navigation
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.dashboard-sidebar');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }

    // Handle active navigation state
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Add hover animations to cards
    const cards = document.querySelectorAll('.stat-card, .action-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            gsap.to(this, {
                y: -5,
                duration: 0.2,
                ease: 'power2.out'
            });
        });

        card.addEventListener('mouseleave', function() {
            gsap.to(this, {
                y: 0,
                duration: 0.2,
                ease: 'power2.out'
            });
        });
    });

    // Handle responsive behavior
    function handleResponsive() {
        if (window.innerWidth <= 768) {
            sidebar?.classList.remove('show');
        }
    }

    window.addEventListener('resize', handleResponsive);
    handleResponsive();

    // Quick action buttons
    const quickActionButtons = document.querySelectorAll('.quick-action-btn');
    quickActionButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Add a ripple effect
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            
            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${event.clientX - rect.left - size / 2}px`;
            ripple.style.top = `${event.clientY - rect.top - size / 2}px`;
            
            ripple.classList.add('active');
            
            setTimeout(() => {
                ripple.remove();
            }, 500);
            
            // Navigate to the specified URL
            const url = this.getAttribute('data-url');
            if (url) {
                window.location.href = url;
            }
        });
    });
    
    // Notification badge animation
    const notificationBadges = document.querySelectorAll('.notification-badge');
    notificationBadges.forEach(badge => {
        gsap.from(badge, {
            scale: 0.5,
            opacity: 0,
            duration: 0.3,
            ease: 'back.out(1.7)',
            delay: 1
        });
    });
});
