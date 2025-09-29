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
        
        <!-- Swiper Gallery -->
        <div class="gallery-swiper-container">
            <div class="swiper gallery-swiper">
                <div class="swiper-wrapper">
                    <?php
                    // Get gallery images from mainsilderimg table
                    $gallery_query = "SELECT * FROM mainsilderimg WHERE page = 2 ORDER BY created_at DESC LIMIT 10";
                    $gallery_result = $conn->query($gallery_query);
                    
                    if($gallery_result && $gallery_result->num_rows > 0):
                        while($gallery_item = $gallery_result->fetch_assoc()):
                    ?>
                        <div class="swiper-slide">
                            <div class="gallery-slide-item">
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
                        <div class="swiper-slide">
                            <div class="gallery-slide-item">
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
                
                <!-- Navigation buttons -->
                <div class="swiper-button-next gallery-nav-next"></div>
                <div class="swiper-button-prev gallery-nav-prev"></div>
                
                <!-- Pagination -->
                <div class="swiper-pagination gallery-pagination"></div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="gallery.php" class="btn btn-primary">
                <i class="fas fa-images me-2"></i>View Full Gallery
            </a>
        </div>
    </div>
</section>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
.gallery-swiper-container {
    margin: 30px 0;
    padding: 0 20px;
}

.gallery-swiper {
    width: 100%;
    height: 400px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.gallery-slide-item {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: 15px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.gallery-slide-item:hover {
    transform: scale(1.05);
}

.gallery-slide-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 15px;
}

.gallery-slide-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay i {
    color: white;
    font-size: 2rem;
    transition: transform 0.3s ease;
}

.gallery-slide-item:hover .gallery-overlay i {
    transform: scale(1.2);
}

/* Navigation buttons */
.gallery-nav-next,
.gallery-nav-prev {
    color: #667eea !important;
    background: rgba(255, 255, 255, 0.9);
    width: 50px !important;
    height: 50px !important;
    border-radius: 50%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.gallery-nav-next:hover,
.gallery-nav-prev:hover {
    background: #667eea;
    color: white !important;
    transform: scale(1.1);
}

.gallery-nav-next:after,
.gallery-nav-prev:after {
    font-size: 18px !important;
    font-weight: bold;
}

/* Pagination */
.gallery-pagination {
    bottom: 20px !important;
}

.gallery-pagination .swiper-pagination-bullet {
    background: rgba(255, 255, 255, 0.5);
    opacity: 1;
    width: 12px;
    height: 12px;
    margin: 0 6px;
    transition: all 0.3s ease;
}

.gallery-pagination .swiper-pagination-bullet-active {
    background: #667eea;
    transform: scale(1.2);
}

/* Facebook Section Styles */
.facebook-embed-container {
    text-align: center;
    padding: 20px 0;
}

.facebook-iframe-wrapper {
    display: flex;
    justify-content: center;
    margin: 20px 0;
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.facebook-iframe-wrapper iframe {
    max-width: 100%;
    height: auto;
    min-height: 600px;
}

/* Responsive */
@media (max-width: 768px) {
    .gallery-swiper {
        height: 300px;
    }
    
    .gallery-swiper-container {
        padding: 0 10px;
    }
    
    .gallery-nav-next,
    .gallery-nav-prev {
        width: 40px !important;
        height: 40px !important;
    }
    
    .gallery-nav-next:after,
    .gallery-nav-prev:after {
        font-size: 14px !important;
    }
    
    .facebook-iframe-wrapper {
        padding: 10px;
    }
    
    .facebook-iframe-wrapper iframe {
        width: 100% !important;
        height: 400px !important;
        min-height: 400px !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper
    const gallerySwiper = new Swiper('.gallery-swiper', {
        // Optional parameters
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        speed: 800,
        
        // Responsive breakpoints
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        },
        
        // Navigation arrows
        navigation: {
            nextEl: '.gallery-nav-next',
            prevEl: '.gallery-nav-prev',
        },
        
        // Pagination
        pagination: {
            el: '.gallery-pagination',
            clickable: true,
        },
        
        // Effect
        effect: 'slide',
        
        // Grab cursor
        grabCursor: true,
    });
    
    // Pause autoplay on hover
    const swiperContainer = document.querySelector('.gallery-swiper');
    swiperContainer.addEventListener('mouseenter', function() {
        gallerySwiper.autoplay.stop();
    });
    
    swiperContainer.addEventListener('mouseleave', function() {
        gallerySwiper.autoplay.start();
    });
});
</script>

<!-- Facebook Section -->
<?php if(isset($clientInfo['facebook']) && !empty($clientInfo['facebook'])): ?>
<section class="content-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Follow Us on Facebook</h2>
                <p class="section-subtitle">Stay connected with our community and latest updates</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="facebook-embed-container">
                    <?php
                    // Extract Facebook page URL and create embed URL
                    $facebook_url = $clientInfo['facebook'];
                    
                    // Convert Facebook page URL to embed format
                    if (strpos($facebook_url, 'facebook.com/') !== false) {
                        // Extract page name from URL
                        $page_name = '';
                        if (preg_match('/facebook\.com\/([^\/\?]+)/', $facebook_url, $matches)) {
                            $page_name = $matches[1];
                        }
                        
                        if (!empty($page_name)) {
                            $embed_url = "https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2F" . urlencode($page_name) . "&tabs=timeline&width=500&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId";
                    ?>
                        <div class="facebook-iframe-wrapper">
                            <iframe src="<?php echo $embed_url; ?>" 
                                    width="500" 
                                    height="500" 
                                    style="border:none;overflow:hidden;border-radius:15px;box-shadow: 0 10px 30px rgba(0,0,0,0.1);" 
                                    scrolling="no" 
                                    frameborder="0" 
                                    allowfullscreen="true" 
                                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                            </iframe>
                        </div>
                    <?php
                        }
                    }
                    ?>
                    
                    <div class="text-center mt-4">
                        <a href="<?php echo htmlspecialchars($facebook_url); ?>" target="_blank" class="btn btn-primary">
                            <i class="fab fa-facebook-f me-2"></i>Visit Our Facebook Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

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
                    <?php if(isset($clientInfo['phone']) && !empty($clientInfo['phone'])): ?>
                        <div class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:<?php echo htmlspecialchars($clientInfo['phone']); ?>" class="text-white">
                                <?php echo htmlspecialchars($clientInfo['phone']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($clientInfo['email']) && !empty($clientInfo['email'])): ?>
                        <div class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:<?php echo htmlspecialchars($clientInfo['email']); ?>" class="text-white">
                                <?php echo htmlspecialchars($clientInfo['email']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <a href="contact.php" class="btn btn-light btn-lg">
                    <i class="fas fa-envelope me-2"></i>Get In Touch
                </a>
            </div>
        </div>
    </div>
</section>

<?php require('components/footer.inc.php'); ?>
