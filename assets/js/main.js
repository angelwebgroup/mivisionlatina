/**
 * MI VISIÓN LATINA - Core Interactive Scripts
 * Lightweight, vanilla JS for maximum Core Web Vitals performance
 */

document.addEventListener('DOMContentLoaded', () => {

    // 1. Mobile Menu Toggle
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', () => {
            mainNav.classList.toggle('open');
            const isOpen = mainNav.classList.contains('open');
            menuToggle.setAttribute('aria-expanded', isOpen);
            menuToggle.innerHTML = isOpen ? '✕ Cerrar' : '☰ Menú';
        });

        // Close menu when clicking a link
        mainNav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (mainNav.classList.contains('open')) {
                    mainNav.classList.remove('open');
                    menuToggle.innerHTML = '☰ Menú';
                }
            });
        });
    }

    // 2. Video Stream / Program Player Switcher
    const streamChannels = document.querySelectorAll('.stream-channel-card');
    const streamPlayer = document.getElementById('main-stream-player');
    const streamTitle = document.getElementById('current-stream-title');

    if (streamChannels.length > 0 && streamPlayer) {
        streamChannels.forEach(channel => {
            channel.addEventListener('click', function() {
                // Update active state
                streamChannels.forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                // Read attributes
                const videoUrl = this.getAttribute('data-video-url');
                const title = this.getAttribute('data-title');

                if (videoUrl) {
                    streamPlayer.src = videoUrl;
                }
                if (title && streamTitle) {
                    streamTitle.textContent = title;
                }
            });
        });
    }

    // 2.1 Interactive Live Studio Card Episode Switcher
    const studioEpisodes = document.querySelectorAll('.studio-ep-item');
    const heroStudioPlayer = document.getElementById('hero-studio-player');
    const studioActiveTitle = document.getElementById('studio-active-title');

    if (studioEpisodes.length > 0 && heroStudioPlayer) {
        studioEpisodes.forEach(ep => {
            ep.addEventListener('click', function() {
                studioEpisodes.forEach(item => item.classList.remove('active'));
                this.classList.add('active');

                const videoId = this.getAttribute('data-video-id');
                const title = this.getAttribute('data-title');

                if (videoId) {
                    heroStudioPlayer.src = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0`;
                }
                if (title && studioActiveTitle) {
                    studioActiveTitle.textContent = title;
                }
            });
        });
    }

    // 3. Job Candidate AJAX Form Submission
    const jobForm = document.getElementById('job-candidate-form');
    const formAlert = document.getElementById('form-alert');
    const submitBtn = document.getElementById('btn-submit-job');

    if (jobForm) {
        jobForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Basic validation
            const fullname = jobForm.querySelector('#fullname')?.value.trim();
            const phone = jobForm.querySelector('#phone')?.value.trim();

            if (!fullname || !phone) {
                showAlert('Por favor completa al menos tu Nombre y Teléfono.', 'error');
                return;
            }

            // UI state: loading
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
                const btnText = submitBtn.querySelector('.btn-text');
                if (btnText) btnText.textContent = '⏳ Guardando en la base de datos...';
            }

            const formData = new FormData(jobForm);

            try {
                const response = await fetch('ajax_submit_job.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message || '¡Tu perfil ha sido registrado exitosamente en Trabajo Latino!', 'success');
                    showToast('✅ Perfil guardado con éxito');
                    jobForm.reset();
                    // Scroll to alert
                    if (formAlert) {
                        formAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    showAlert(data.message || 'Ocurrió un error al registrar tus datos. Por favor intenta de nuevo.', 'error');
                    showToast('❌ Error al registrar');
                }
            } catch (err) {
                console.error(err);
                showAlert('Hubo un error de conexión con el servidor. Inténtalo de nuevo o contáctanos directamente por WhatsApp.', 'error');
                showToast('⚠️ Error de conexión');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                    const btnText = submitBtn.querySelector('.btn-text');
                    if (btnText) btnText.textContent = '🚀 Enviar mi Perfil a la Base de Datos';
                }
            }
        });
    }

    function showAlert(message, type) {
        if (!formAlert) return;
        formAlert.className = `alert-box ${type}`;
        formAlert.innerHTML = message;
        formAlert.style.display = 'block';
    }

    // 4. Toast Notifications
    function showToast(message) {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.textContent = message;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(() => toast.remove(), 400);
        }, 4000);
    }

    // 5. Active Navbar Link on Scroll
    const sections = document.querySelectorAll('section[id]');
    if (sections.length > 0) {
        window.addEventListener('scroll', () => {
            const scrollY = window.pageYOffset;
            sections.forEach(current => {
                const sectionHeight = current.offsetHeight;
                const sectionTop = current.offsetTop - 120;
                const sectionId = current.getAttribute('id');
                const navLink = document.querySelector(`.main-nav a[href*="${sectionId}"]`);
                
                if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    if (navLink) navLink.classList.add('active');
                } else {
                    if (navLink) navLink.classList.remove('active');
                }
            });
        });
    }

});
