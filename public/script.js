document.addEventListener('DOMContentLoaded', () => {
    
    // ==========================================================================
    // 1. Theme Toggle (Dark / Light Mode)
    // ==========================================================================
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIcon = themeToggleBtn.querySelector('i');
    
    // Check saved theme or system preference
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.documentElement.setAttribute('data-theme', 'dark');
        themeIcon.className = 'fa-solid fa-sun';
    } else {
        document.documentElement.removeAttribute('data-theme');
        themeIcon.className = 'fa-solid fa-moon';
    }
    
    themeToggleBtn.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        if (currentTheme === 'dark') {
            document.documentElement.removeAttribute('data-theme');
            localStorage.setItem('theme', 'light');
            themeIcon.className = 'fa-solid fa-moon';
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            themeIcon.className = 'fa-solid fa-sun';
        }
    });

    // ==========================================================================
    // 2. Mobile Menu Toggle
    // ==========================================================================
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const navMenu = document.getElementById('nav-menu');
    const navLinks = navMenu.querySelectorAll('a');

    mobileMenuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        const icon = mobileMenuToggle.querySelector('i');
        if (navMenu.classList.contains('active')) {
            icon.className = 'fa-solid fa-xmark';
        } else {
            icon.className = 'fa-solid fa-bars';
        }
    });

    // Close menu when clicking navigation links
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            mobileMenuToggle.querySelector('i').className = 'fa-solid fa-bars';
        });
    });

    // ==========================================================================
    // 3. Project Gallery Tab Switcher
    // ==========================================================================
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab');

            // Set active button
            tabButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Show active content
            tabContents.forEach(content => {
                if (content.id === targetTab) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });
        });
    });

    // ==========================================================================
    // 4. Before / After Sliders (Multi-instance support)
    // ==========================================================================
    const sliders = document.querySelectorAll('.ba-slider-instance');

    sliders.forEach(slider => {
        const beforeImgWrapper = slider.querySelector('.before-img-wrap-instance');
        const handle = slider.querySelector('.slider-handle-instance');

        if (slider && beforeImgWrapper && handle) {
            let isDragging = false;

            const setSliderPosition = (xPos) => {
                const rect = slider.getBoundingClientRect();
                let position = ((xPos - rect.left) / rect.width) * 100;
                
                if (position < 0) position = 0;
                if (position > 100) position = 100;

                beforeImgWrapper.style.width = `${position}%`;
                handle.style.left = `${position}%`;
            };

            // Mouse Events
            slider.addEventListener('mousedown', (e) => {
                isDragging = true;
                setSliderPosition(e.clientX);
            });

            window.addEventListener('mouseup', () => {
                isDragging = false;
            });

            window.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                setSliderPosition(e.clientX);
            });

            // Touch Events
            slider.addEventListener('touchstart', (e) => {
                isDragging = true;
                setSliderPosition(e.touches[0].clientX);
            });

            window.addEventListener('touchend', () => {
                isDragging = false;
            });

            window.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                setSliderPosition(e.touches[0].clientX);
            });
        }
    });

    // ==========================================================================
    // 5. Contact Form Handler (Dynamic POST request)
    // ==========================================================================
    const contactForm = document.getElementById('contact-form');
    const formSuccessMessage = document.getElementById('form-success');
    const successTxt = document.getElementById('success-txt');

    if (contactForm && formSuccessMessage) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const formData = new FormData(contactForm);
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Sending <i class="fa-solid fa-spinner fa-spin"></i>';

            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    successTxt.textContent = data.message;
                    contactForm.classList.add('hidden');
                    formSuccessMessage.classList.remove('hidden');
                    contactForm.reset();
                } else {
                    alert(data.message || 'There was an error sending your message. Please try again.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Send Message <i class="fa-solid fa-arrow-right"></i>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Connection error. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Send Message <i class="fa-solid fa-arrow-right"></i>';
            });
        });
    }
});
