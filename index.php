<?php 
require('connect.php');
require('GetClient.php');
require('components/head.inc.php'); 
include('components/navbar.inc.php'); 
?>
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
                <h2 class="section-title">Our categories</h2>
            </div>
        </div>
        
        <div class="row g-4">
            <?php
            // Get classes from database
            $classes_query = "SELECT * FROM class WHERE client_id = $clientID ORDER BY id ASC LIMIT 6";
            $classes_result = $conn->query($classes_query);
            
            if($classes_result && $classes_result->num_rows > 0):
                while($class_item = $classes_result->fetch_assoc()):
                    // Get count of items in this class
                    $count_query = "SELECT COUNT(*) as count FROM classpage WHERE ClassID = " . $class_item['id'];
                    $count_result = $conn->query($count_query);
                    $count = $count_result ? $count_result->fetch_assoc()['count'] : 0;
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center service-card">
                        <div class="card-body">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-star fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title"><?php echo htmlspecialchars($class_item['title']); ?></h5>
                            <p class="card-text">
                                Explore our <?php echo htmlspecialchars($class_item['title']); ?> programs and activities. 
                                Join us for meaningful experiences and spiritual growth.
                            </p>
                            <div class="service-info mb-3">
                                <i class="fas fa-list me-2"></i>
                                <strong><?php echo $count; ?> category<?php echo $count != 1 ? 's' : ''; ?> Available</strong>
                            </div>
                            <a href="ClassPage.php?id=<?php echo $class_item['id']; ?>&title=<?php echo urlencode($class_item['title']); ?>" class="btn btn-primary">
                                <i class="fas fa-arrow-right me-2"></i>View category
                            </a>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
            else:
                // Fallback to default services if no classes in database
            ?>
                
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- About Preview Section -->
<section class="content-section bg-light">
    <div class="container">
        <?php
        // Get content data for about page (pageID = 1) - get first item for preview
        $about_query = "SELECT * FROM content WHERE pageID = 1 AND client_id = $clientID ORDER BY id ASC LIMIT 1";
        $about_result = $conn->query($about_query);
        $about_item = $about_result ? $about_result->fetch_assoc() : null;
        ?>
        
        <div class="row align-items-center">
            <div class="col-lg-6">
                <?php if($about_item): ?>
                    <h2 class="section-title text-start"><?php echo htmlspecialchars($about_item['title']); ?></h2>
                    <div class="content-body">
                        <?php echo nl2br(htmlspecialchars($about_item['content'])); ?>
                    </div>
                    <?php if(!empty($about_item['link']) && !empty($about_item['linkText'])): ?>
                        <a href="<?php echo htmlspecialchars($about_item['link']); ?>" class="btn btn-primary">
                            <i class="fas fa-arrow-right me-2"></i><?php echo htmlspecialchars($about_item['linkText']); ?>
                        </a>
                    <?php else: ?>
                        <a href="about.php" class="btn btn-primary">
                            <i class="fas fa-arrow-right me-2"></i>Learn More About Us
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Fallback content if no database content -->
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
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <?php if($about_item && !empty($about_item['img'])): ?>
                    <img src="church/uploads/<?php echo htmlspecialchars($about_item['img']); ?>" alt="<?php echo htmlspecialchars($about_item['title']); ?>" class="img-fluid rounded-3 shadow">
                <?php elseif(isset($clientInfo['background_img2']) && !empty($clientInfo['background_img2'])): ?>
                    <img src="church/uploads/<?php echo htmlspecialchars($clientInfo['background_img2']); ?>" alt="Community" class="img-fluid rounded-3 shadow">
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
