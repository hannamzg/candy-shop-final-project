<?php require('components/head.inc.php'); ?>
<?php include('components/navbar.inc.php'); ?>

<?php
// Get page data from pages table (page = 1 for About Us)
$page_query = "SELECT * FROM pages WHERE id = 1";
$page_result = $conn->query($page_query);
$page_data = $page_result->fetch_assoc();

// Get content data for about page
$content_query = "SELECT * FROM content WHERE pageID = 1 ORDER BY id ASC";
$content_result = $conn->query($content_query);
$content_items = [];
while($row = $content_result->fetch_assoc()) {
    $content_items[] = $row;
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><?php echo isset($page_data['pageName']) ? htmlspecialchars($page_data['pageName']) : 'About Us'; ?></h1>
        <p>Learn more about our church community, mission, and values</p>
    </div>
</section>

<!-- About Content Section -->
<section class="content-section">
    <div class="container">
        <?php if(!empty($content_items)): ?>
            <?php foreach($content_items as $index => $item): ?>
                <div class="row align-items-center mb-5 <?php echo $index % 2 == 1 ? 'flex-row-reverse' : ''; ?>">
                    <div class="col-lg-6">
                        <div class="content-text">
                            <h2 class="mb-4"><?php echo htmlspecialchars($item['title']); ?></h2>
                            <div class="content-body">
                                <?php echo nl2br(htmlspecialchars($item['content'])); ?>
                            </div>
                            <?php if(!empty($item['link']) && !empty($item['linkText'])): ?>
                                <a href="<?php echo htmlspecialchars($item['link']); ?>" class="btn btn-primary mt-3">
                                    <?php echo htmlspecialchars($item['linkText']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <?php if(!empty($item['img'])): ?>
                            <div class="content-image">
                                <img src="church/uploads/<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="img-fluid rounded-3 shadow">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Default About Content -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="content-text">
                        <h2 class="mb-4">Our Mission</h2>
                        <p class="lead">
                            We are called to be a beacon of hope and love in our community, spreading the Gospel of Jesus Christ 
                            through worship, fellowship, and service.
                        </p>
                        <p>
                            Our mission is to create a welcoming environment where people can encounter God, grow in their faith, 
                            and develop meaningful relationships with one another. We believe in the power of community and the 
                            transformative love of Christ.
                        </p>
                        <a href="contact.php" class="btn btn-primary mt-3">
                            <i class="fas fa-envelope me-2"></i>Join Our Community
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-image">
                        <img src="img/christianity.png" alt="Our Mission" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-5 flex-row-reverse">
                <div class="col-lg-6">
                    <div class="content-text">
                        <h2 class="mb-4">Our Values</h2>
                        <div class="values-list">
                            <div class="value-item mb-3">
                                <i class="fas fa-heart text-primary me-3"></i>
                                <strong>Love:</strong> We believe in showing God's love to everyone we meet.
                            </div>
                            <div class="value-item mb-3">
                                <i class="fas fa-hands-helping text-primary me-3"></i>
                                <strong>Service:</strong> We are committed to serving our community and those in need.
                            </div>
                            <div class="value-item mb-3">
                                <i class="fas fa-users text-primary me-3"></i>
                                <strong>Fellowship:</strong> We value authentic relationships and community.
                            </div>
                            <div class="value-item mb-3">
                                <i class="fas fa-pray text-primary me-3"></i>
                                <strong>Faith:</strong> We trust in God's plan and seek His guidance in all we do.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-image">
                        <img src="img/handshake.svg" alt="Our Values" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="content-text">
                        <h2 class="mb-4">Our History</h2>
                        <p class="lead">
                            Founded in faith and built on love, our church has been serving the community for many years.
                        </p>
                        <p>
                            From our humble beginnings, we have grown into a vibrant community of believers who are passionate 
                            about sharing the Gospel and making a positive impact in our neighborhood. Our history is marked 
                            by God's faithfulness and the dedication of our members.
                        </p>
                        <p>
                            Today, we continue to build on this foundation, reaching out to new generations and adapting 
                            to meet the changing needs of our community while staying true to our core beliefs.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-image">
                        <img src="img/Cross-Background.jpg" alt="Our History" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Leadership Section -->
<section class="content-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Our Leadership</h2>
                <p class="section-subtitle">Meet the dedicated leaders who guide our church community</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="leader-avatar mb-3">
                            <i class="fas fa-user-circle fa-5x text-primary"></i>
                        </div>
                        <h5 class="card-title">Pastor John Smith</h5>
                        <p class="text-muted">Senior Pastor</p>
                        <p class="card-text">
                            Leading our congregation with wisdom and compassion, Pastor John has been serving our community for over 10 years.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="leader-avatar mb-3">
                            <i class="fas fa-user-circle fa-5x text-primary"></i>
                        </div>
                        <h5 class="card-title">Sarah Johnson</h5>
                        <p class="text-muted">Youth Minister</p>
                        <p class="card-text">
                            Passionate about youth ministry, Sarah leads our young people in growing their faith and building community.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="leader-avatar mb-3">
                            <i class="fas fa-user-circle fa-5x text-primary"></i>
                        </div>
                        <h5 class="card-title">Michael Brown</h5>
                        <p class="text-muted">Music Director</p>
                        <p class="card-text">
                            Leading our worship through music, Michael helps create meaningful worship experiences for our congregation.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="content-section bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-4">Join Our Community</h2>
                <p class="lead mb-4">
                    We invite you to be part of our church family. Whether you're new to faith or have been walking with God for years, 
                    there's a place for you here.
                </p>
                <div class="cta-buttons">
                    <a href="contact.php" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-envelope me-2"></i>Contact Us
                    </a>
                    <a href="index.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-home me-2"></i>Visit Our Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require('components/footer.inc.php'); ?>