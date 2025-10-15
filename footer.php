    <!-- Professional Footer -->
    <footer class="professional-footer mt-5 py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="footer-brand">
                        <i class="bi bi-calendar-check me-2"></i>
                        <span class="fw-bold">Sistema de Reservas Profesional</span>
                    </div>
                    <p class="footer-text mb-0">Gestión eficiente y segura de citas</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-links">
                        <a href="mediosContacto.php" class="footer-link me-3">
                            <i class="bi bi-telephone me-1"></i> Contacto
                        </a>
                        <a href="admin/" class="footer-link">
                            <i class="bi bi-gear me-1"></i> Admin
                        </a>
                    </div>
                    <p class="footer-copyright mb-0"> 2025 Sistema de Reservas</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Contenedor para partículas -->
    <div id="particles-container"></div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js "></script>
    <!-- Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js "></script>
    <!-- Datatables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js "></script>
    <!-- Particles JS -->
    <script src="/citas/jss/particles.js"></script>
    <!-- Custom JS -->
    <script src="/citas/jss/custom.js"></script>
    
    <!-- Professional Enhancements Script -->
    <script>
        // Professional form enhancements and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize scroll reveal animations
            initScrollReveal();
            
            // Initialize professional interactions
            initProfessionalInteractions();
            
            // Initialize form enhancements
            initFormEnhancements();
            
            // Initialize navbar effects
            initNavbarEffects();
            
            // Initialize particle effects
            initParticleEffects();
        });

        // Scroll Reveal Animation System
        function initScrollReveal() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Add scroll reveal to elements
            const elements = document.querySelectorAll('.card, .alert, .btn, .form-control');
            elements.forEach((el, index) => {
                el.classList.add('scroll-reveal');
                el.style.animationDelay = `${index * 0.1}s`;
                observer.observe(el);
            });
        }

        // Professional Interactions
        function initProfessionalInteractions() {
            // Enhanced button interactions
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px) scale(1.05)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
                
                btn.addEventListener('mousedown', function() {
                    this.style.transform = 'translateY(0) scale(0.98)';
                });
                
                btn.addEventListener('mouseup', function() {
                    this.style.transform = 'translateY(-3px) scale(1.05)';
                });
            });

            // Enhanced card interactions
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-15px) scale(1.03)';
                    this.style.boxShadow = '0 25px 50px rgba(37, 99, 235, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '';
                });
            });

            // Reservation card special effects
            const reservationCard = document.querySelector('.reservation-card');
            if (reservationCard) {
                reservationCard.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.05)';
                    this.style.boxShadow = '0 30px 60px rgba(37, 99, 235, 0.3)';
                });
                
                reservationCard.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '';
                });
            }
        }

        // Form Enhancements
        function initFormEnhancements() {
            // Add loading states to buttons
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('loading');
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Procesando...';
                        
                        // Simulate processing time
                        setTimeout(() => {
                            submitBtn.classList.remove('loading');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Enviado';
                        }, 2000);
                    }
                });
            });

            // Enhanced form validation with animations
            const inputs = document.querySelectorAll('.form-control, .form-select');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                    this.style.borderColor = 'var(--primary-color)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                    
                    if (this.checkValidity()) {
                        this.classList.add('is-valid');
                        this.classList.remove('is-invalid');
                        this.style.borderColor = 'var(--success-color)';
                    } else if (this.value) {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                        this.style.borderColor = 'var(--danger-color)';
                    } else {
                        this.style.borderColor = '';
                    }
                });
                
                // Real-time validation feedback
                input.addEventListener('input', function() {
                    if (this.value && this.checkValidity()) {
                        this.style.borderColor = 'var(--success-color)';
                    } else if (this.value) {
                        this.style.borderColor = 'var(--warning-color)';
                    }
                });
            });
        }

        // Navbar Effects
        function initNavbarEffects() {
            let lastScrollTop = 0;
            const navbar = document.querySelector('.navbar');
            let ticking = false;

            function updateNavbar() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    navbar.style.transform = 'translateY(-100%)';
                    navbar.style.opacity = '0.95';
                } else {
                    navbar.style.transform = 'translateY(0)';
                    navbar.style.opacity = '1';
                }
                
                // Add background blur effect on scroll
                if (scrollTop > 50) {
                    navbar.style.backdropFilter = 'blur(20px)';
                    navbar.style.background = 'rgba(15, 23, 42, 0.9)';
                } else {
                    navbar.style.backdropFilter = 'blur(10px)';
                    navbar.style.background = 'rgba(15, 23, 42, 0.8)';
                }
                
                lastScrollTop = scrollTop;
                ticking = false;
            }

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(updateNavbar);
                    ticking = true;
                }
            });
        }

        // Particle Effects Enhancement
        function initParticleEffects() {
            const particlesContainer = document.getElementById('particles-container');
            if (!particlesContainer) return;

            // Create floating particles
            function createParticle() {
                const particle = document.createElement('div');
                particle.className = 'particle';
                
                const size = Math.random() * 4 + 2;
                const left = Math.random() * 100;
                const animationDuration = Math.random() * 20 + 10;
                
                particle.style.cssText = `
                    width: ${size}px;
                    height: ${size}px;
                    left: ${left}%;
                    animation-duration: ${animationDuration}s;
                    animation-delay: ${Math.random() * 2}s;
                `;
                
                particlesContainer.appendChild(particle);
                
                // Remove particle after animation
                setTimeout(() => {
                    if (particle.parentNode) {
                        particle.parentNode.removeChild(particle);
                    }
                }, animationDuration * 1000);
            }

            // Create particles periodically
            setInterval(createParticle, 800);
            
            // Initial particles
            for (let i = 0; i < 10; i++) {
                setTimeout(createParticle, i * 200);
            }
        }

        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Professional modal enhancements
        const modal = document.getElementById('modalReserva');
        if (modal) {
            modal.addEventListener('show.bs.modal', function() {
                document.body.style.overflow = 'hidden';
                this.querySelector('.modal-dialog').style.transform = 'scale(1) translateY(0)';
            });
            
            modal.addEventListener('hide.bs.modal', function() {
                document.body.style.overflow = '';
                this.querySelector('.modal-dialog').style.transform = 'scale(0.8) translateY(-50px)';
            });
        }
    </script>
</body>
</html>