document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Back to top button
    const backToTopButton = document.querySelector('.back-to-top');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            backToTopButton.classList.add('active');
        } else {
            backToTopButton.classList.remove('active');
        }
    });
    backToTopButton.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || !document.querySelector(targetId)) return;
            e.preventDefault();
            const targetElement = document.querySelector(targetId);
            const navbarHeight = navbar.offsetHeight;
            const targetPosition = targetElement.offsetTop - navbarHeight;
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
            if (history.pushState) {
                history.pushState(null, null, targetId);
            } else {
                location.hash = targetId;
            }
        });
    });

    // Animate stats counter
    const statNumbers = document.querySelectorAll('.stat-number');
    if (statNumbers.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    statNumbers.forEach(stat => {
                        const target = +stat.getAttribute('data-count');
                        const speed = 200;
                        const increment = target / speed;
                        let current = 0;
                        const updateCount = () => {
                            current += increment;
                            if (current < target) {
                                stat.textContent = Math.floor(current);
                                setTimeout(updateCount, 1);
                            } else {
                                stat.textContent = target;
                            }
                        };
                        updateCount();
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        observer.observe(document.querySelector('.stats'));
    }

    // Tool filtering functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const toolItems = document.querySelectorAll('.tool');
    const toolSearch = document.getElementById('toolSearch');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            const filterValue = this.getAttribute('data-filter');
            toolItems.forEach(tool => {
                if (filterValue === 'all' || tool.getAttribute('data-category') === filterValue) {
                    tool.style.display = 'flex';
                } else {
                    tool.style.display = 'none';
                }
            });
        });
    });
    if (toolSearch) {
        toolSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            toolItems.forEach(tool => {
                const toolName = tool.querySelector('.tool-name').textContent.toLowerCase();
                const toolDesc = tool.querySelector('.tool-desc').textContent.toLowerCase();
                if (toolName.includes(searchTerm) || toolDesc.includes(searchTerm)) {
                    tool.style.display = 'flex';
                } else {
                    tool.style.display = 'none';
                }
            });
        });
    }

    // Animate elements on scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.feature-card, .tool, .testimonial-item, .section-title');
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;
            if (elementPosition < screenPosition) {
                element.classList.add('fade-in');
            }
        });
    };
    animateOnScroll();
    window.addEventListener('scroll', animateOnScroll);

    // Testimonial slider functionality
    const testimonialSlider = document.querySelector('.testimonial-slider');
    if (testimonialSlider) {
        let isDown = false;
        let startX;
        let scrollLeft;
        testimonialSlider.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - testimonialSlider.offsetLeft;
            scrollLeft = testimonialSlider.scrollLeft;
            testimonialSlider.style.cursor = 'grabbing';
        });
        testimonialSlider.addEventListener('mouseleave', () => {
            isDown = false;
            testimonialSlider.style.cursor = 'grab';
        });
        testimonialSlider.addEventListener('mouseup', () => {
            isDown = false;
            testimonialSlider.style.cursor = 'grab';
        });
        testimonialSlider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - testimonialSlider.offsetLeft;
            const walk = (x - startX) * 2;
            testimonialSlider.scrollLeft = scrollLeft - walk;
        });
        testimonialSlider.addEventListener('touchstart', (e) => {
            isDown = true;
            startX = e.touches[0].pageX - testimonialSlider.offsetLeft;
            scrollLeft = testimonialSlider.scrollLeft;
        });
        testimonialSlider.addEventListener('touchend', () => {
            isDown = false;
        });
        testimonialSlider.addEventListener('touchmove', (e) => {
            if (!isDown) return;
            const x = e.touches[0].pageX - testimonialSlider.offsetLeft;
            const walk = (x - startX) * 2;
            testimonialSlider.scrollLeft = scrollLeft - walk;
        });
    }
});