<?php require('components/head.inc.php'); ?>
<?php include('components/navbar.inc.php'); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold mb-4">
                        Welcome to <?php echo isset($general_data['client_name']) ? htmlspecialchars($general_data['client_name']) : 'Our Church'; ?>
                    </h1>
                    <p class="lead mb-4">
                        <?php echo isset($general_data['description']) ? htmlspecialchars($general_data['description']) : 'Join us in worship, fellowship, and community service. We are a welcoming community dedicated to growing in faith together.'; ?>
                    </p>
                    <div class="hero-buttons">
                        <a href="about.php" class="btn btn-light btn-lg me-3">
                            <i class="fas fa-info-circle me-2"></i>Learn More
                        </a>
                        <a href="contact.php" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-phone me-2"></i>Contact Us
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image text-center">
                    <?php if(isset($general_data['background_img1']) && !empty($general_data['background_img1'])): ?>
                        <img src="church/uploads/<?php echo htmlspecialchars($general_data['background_img1']); ?>" alt="Church" class="img-fluid rounded-3 shadow-lg">
                    <?php else: ?>
                        <img src="img/Cross-Background.jpg" alt="Church" class="img-fluid rounded-3 shadow-lg">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="content-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Our Services</h2>
                <p class="section-subtitle">Join us for worship, fellowship, and spiritual growth</p>
            </div>
        </div>
        
        <div class="row g-4">
            <!-- Sunday Service -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-church fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Sunday Service</h5>
                        <p class="card-text">Join us every Sunday for worship, prayer, and fellowship. Experience the joy of community worship.</p>
                        <div class="service-time">
                            <i class="fas fa-clock me-2"></i>
                            <strong>9:00 AM - 12:00 PM</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bible Study -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-bible fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Bible Study</h5>
                        <p class="card-text">Deepen your understanding of God's word through our weekly Bible study sessions.</p>
                        <div class="service-time">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Wednesday 7:00 PM</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Youth Programs -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-child fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Youth Programs</h5>
                        <p class="card-text">Engaging programs for children and youth to grow in faith and build lasting friendships.</p>
                        <div class="service-time">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Saturday 10:00 AM</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Preview Section -->
<section class="content-section bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title text-start">About Our Community</h2>
                <p class="lead">
                    We are a welcoming community of believers dedicated to serving God and our neighbors. 
                    Our mission is to spread the love of Christ through worship, fellowship, and service.
                </p>
                <p>
                    Founded on the principles of faith, hope, and love, we strive to create an environment 
                    where everyone can grow spiritually and find their place in God's family.
                </p>
                <a href="about.php" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i>Learn More About Us
                </a>
            </div>
            <div class="col-lg-6">
                <?php if(isset($general_data['background_img2']) && !empty($general_data['background_img2'])): ?>
                    <img src="church/uploads/<?php echo htmlspecialchars($general_data['background_img2']); ?>" alt="Community" class="img-fluid rounded-3 shadow">
                <?php else: ?>
                    <img src="img/children.png" alt="Community" class="img-fluid rounded-3 shadow">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Preview Section -->
<section class="content-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Gallery</h2>
                <p class="section-subtitle">Moments of faith, fellowship, and community</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php
            // Get gallery images from mainsilderimg table
            $gallery_query = "SELECT * FROM mainsilderimg WHERE page = 2 ORDER BY created_at DESC LIMIT 6";
            $gallery_result = $conn->query($gallery_query);
            
            if($gallery_result && $gallery_result->num_rows > 0):
                while($gallery_item = $gallery_result->fetch_assoc()):
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="church/uploads/<?php echo htmlspecialchars($gallery_item['img']); ?>" alt="Gallery Image" class="img-fluid">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
            else:
                // Default gallery images if no database images
                $default_images = ['img/OIG1.jpg', 'img/OIG2.84xOLuE.jpg', 'img/Cross-Background.jpg'];
                foreach($default_images as $index => $img):
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="<?php echo $img; ?>" alt="Gallery Image" class="img-fluid">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="gallery.php" class="btn btn-primary">
                <i class="fas fa-images me-2"></i>View Full Gallery
            </a>
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="content-section bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-4">Join Our Community</h2>
                <p class="lead mb-4">
                    We welcome you to be part of our church family. Whether you're new to faith or have been walking with God for years, 
                    there's a place for you here.
                </p>
                <div class="contact-info mb-4">
                    <?php if(isset($general_data['phone']) && !empty($general_data['phone'])): ?>
                        <div class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:<?php echo htmlspecialchars($general_data['phone']); ?>" class="text-white">
                                <?php echo htmlspecialchars($general_data['phone']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:info@church.com" class="text-white">info@church.com</a>
                    </div>
                </div>
                <a href="contact.php" class="btn btn-light btn-lg">
                    <i class="fas fa-envelope me-2"></i>Get In Touch
                </a>
            </div>
        </div>
    </div>
</section>

<?php require('components/footer.inc.php'); ?>
