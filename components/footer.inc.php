<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Church Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5>
                    <?php if(isset($general_data['icon']) && !empty($general_data['icon'])): ?>
                        <img src="church/uploads/<?php echo htmlspecialchars($general_data['icon']); ?>" alt="Logo" height="30" class="me-2">
                    <?php else: ?>
                        <i class="fas fa-church me-2"></i>
                    <?php endif; ?>
                    <?php echo isset($general_data['client_name']) ? htmlspecialchars($general_data['client_name']) : 'Church'; ?>
                </h5>
                <p class="mb-3">
                    <?php echo isset($general_data['description']) ? htmlspecialchars($general_data['description']) : 'Welcome to our church community. We are dedicated to serving God and our community with love, faith, and compassion.'; ?>
                </p>
                
                <!-- Social Links -->
                <div class="social-links">
                    <?php if(isset($general_data['facebook']) && !empty($general_data['facebook'])): ?>
                        <a href="<?php echo htmlspecialchars($general_data['facebook']); ?>" target="_blank" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>
                    <a href="#" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="index.php">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="about.php">
                            <i class="fas fa-info-circle me-2"></i>About Us
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="gallery.php">
                            <i class="fas fa-images me-2"></i>Gallery
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="news.php">
                            <i class="fas fa-newspaper me-2"></i>News
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="contact.php">
                            <i class="fas fa-envelope me-2"></i>Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Services -->
            

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Contact Info</h5>
                <div class="contact-info">
                    <?php if(isset($general_data['phone']) && !empty($general_data['phone'])): ?>
                        <div class="mb-3">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:<?php echo htmlspecialchars($general_data['phone']); ?>">
                                <?php echo htmlspecialchars($general_data['phone']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:info@church.com">info@church.com</a>
                    </div>
                    
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span>123 Church Street<br>City, State 12345</span>
                    </div>
                    
                    <div class="mb-3">
                        <i class="fas fa-clock me-2"></i>
                        <div>
                            <div>Sunday: 9:00 AM - 12:00 PM</div>
                            <div>Wednesday: 7:00 PM - 8:30 PM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">
                    &copy; <?php echo date('Y'); ?> <?php echo isset($general_data['client_name']) ? htmlspecialchars($general_data['client_name']) : 'Church'; ?>. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0">
                    Made with <i class="fas fa-heart text-danger"></i> for our community
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script>
    // Smooth scrolling for anchor links
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

    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.addEventListener('DOMContentLoaded', function() {
        const animateElements = document.querySelectorAll('.card, .gallery-item, .section-title');
        animateElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
            navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
        } else {
            navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
            navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.05)';
        }
    });
</script>

</body>
</html>
