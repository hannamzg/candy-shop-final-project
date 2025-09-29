<?php require('components/head.inc.php'); ?>
<?php include('components/navbar.inc.php'); ?>

<?php
// Get page data from pages table (page = 3 for News)
$page_query = "SELECT * FROM pages WHERE id = 3";
$page_result = $conn->query($page_query);
$page_data = $page_result->fetch_assoc();

// Get content data for news page
$content_query = "SELECT * FROM content WHERE pageID = 3 ORDER BY id ASC";
$content_result = $conn->query($content_query);
$content_items = [];
while($row = $content_result->fetch_assoc()) {
    $content_items[] = $row;
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><?php echo isset($page_data['pageName']) ? htmlspecialchars($page_data['pageName']) : 'News & Updates'; ?></h1>
        <p>Stay updated with the latest news and events from our church community</p>
    </div>
</section>

<!-- News Content Section -->
<?php if(!empty($content_items)): ?>
    <section class="content-section">
        <div class="container">
            <?php foreach($content_items as $item): ?>
                <div class="row align-items-center mb-5">
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
        </div>
    </section>
<?php endif; ?>

<!-- News Articles Section -->
<section class="content-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Latest News</h2>
                <p class="section-subtitle">Stay informed about our church activities and community events</p>
            </div>
        </div>
        
        <div class="row g-4">
            <!-- News Article 1 -->
            <div class="col-lg-4 col-md-6">
                <article class="card h-100">
                    <div class="card-img-top-wrapper">
                        <img src="img/calendar.png" alt="Upcoming Events" class="card-img-top">
                        <div class="card-date">
                            <span class="day">15</span>
                            <span class="month">Dec</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-meta mb-2">
                            <span class="badge bg-primary">Events</span>
                            <span class="text-muted ms-2">December 15, 2024</span>
                        </div>
                        <h5 class="card-title">Christmas Celebration Service</h5>
                        <p class="card-text">
                            Join us for our special Christmas celebration service featuring carols, 
                            a nativity play, and a message of hope and joy.
                        </p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </article>
            </div>

            <!-- News Article 2 -->
            <div class="col-lg-4 col-md-6">
                <article class="card h-100">
                    <div class="card-img-top-wrapper">
                        <img src="img/children.png" alt="Youth Program" class="card-img-top">
                        <div class="card-date">
                            <span class="day">20</span>
                            <span class="month">Dec</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-meta mb-2">
                            <span class="badge bg-success">Youth</span>
                            <span class="text-muted ms-2">December 20, 2024</span>
                        </div>
                        <h5 class="card-title">Youth Winter Retreat</h5>
                        <p class="card-text">
                            Our annual youth winter retreat is coming up! A weekend of fun, 
                            fellowship, and spiritual growth for ages 13-18.
                        </p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </article>
            </div>

            <!-- News Article 3 -->
            <div class="col-lg-4 col-md-6">
                <article class="card h-100">
                    <div class="card-img-top-wrapper">
                        <img src="img/handshake.svg" alt="Community Service" class="card-img-top">
                        <div class="card-date">
                            <span class="day">25</span>
                            <span class="month">Dec</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-meta mb-2">
                            <span class="badge bg-warning">Community</span>
                            <span class="text-muted ms-2">December 25, 2024</span>
                        </div>
                        <h5 class="card-title">Community Food Drive</h5>
                        <p class="card-text">
                            Help us make a difference in our community by participating in 
                            our annual food drive for families in need.
                        </p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </article>
            </div>

            <!-- News Article 4 -->
            <div class="col-lg-4 col-md-6">
                <article class="card h-100">
                    <div class="card-img-top-wrapper">
                        <img src="img/bible.png" alt="Bible Study" class="card-img-top">
                        <div class="card-date">
                            <span class="day">30</span>
                            <span class="month">Dec</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-meta mb-2">
                            <span class="badge bg-info">Study</span>
                            <span class="text-muted ms-2">December 30, 2024</span>
                        </div>
                        <h5 class="card-title">New Year Bible Study Series</h5>
                        <p class="card-text">
                            Start the new year with a fresh perspective on God's word. 
                            Join our new Bible study series beginning in January.
                        </p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </article>
            </div>

            <!-- News Article 5 -->
            <div class="col-lg-4 col-md-6">
                <article class="card h-100">
                    <div class="card-img-top-wrapper">
                        <img src="img/praying.png" alt="Prayer Meeting" class="card-img-top">
                        <div class="card-date">
                            <span class="day">05</span>
                            <span class="month">Jan</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-meta mb-2">
                            <span class="badge bg-secondary">Prayer</span>
                            <span class="text-muted ms-2">January 5, 2025</span>
                        </div>
                        <h5 class="card-title">Weekly Prayer Meetings Resume</h5>
                        <p class="card-text">
                            Our weekly prayer meetings will resume after the holiday break. 
                            Join us every Wednesday at 7:00 PM for prayer and fellowship.
                        </p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </article>
            </div>

            <!-- News Article 6 -->
            <div class="col-lg-4 col-md-6">
                <article class="card h-100">
                    <div class="card-img-top-wrapper">
                        <img src="img/marketing.svg" alt="Outreach" class="card-img-top">
                        <div class="card-date">
                            <span class="day">10</span>
                            <span class="month">Jan</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-meta mb-2">
                            <span class="badge bg-danger">Outreach</span>
                            <span class="text-muted ms-2">January 10, 2025</span>
                        </div>
                        <h5 class="card-title">Community Outreach Program</h5>
                        <p class="card-text">
                            We're launching a new community outreach program to serve 
                            our neighbors and share God's love in practical ways.
                        </p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </article>
            </div>
        </div>
        
        <!-- Load More Button -->
        <div class="text-center mt-5">
            <button class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Load More News
            </button>
        </div>
    </div>
</section>

<!-- Newsletter Signup Section -->
<section class="content-section bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-4">Stay Connected</h2>
                <p class="lead mb-4">
                    Subscribe to our newsletter to receive the latest news, events, and updates 
                    directly in your inbox.
                </p>
                <form class="newsletter-form">
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-6">
                            <input type="email" class="form-control form-control-lg" placeholder="Enter your email address" required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-light btn-lg w-100">
                                <i class="fas fa-envelope me-2"></i>Subscribe
                            </button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 small">
                    <i class="fas fa-shield-alt me-2"></i>
                    We respect your privacy and will never share your email address.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Custom News Styles -->
<style>
    .card-img-top-wrapper {
        position: relative;
        overflow: hidden;
    }
    
    .card-img-top {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .card-date {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        padding: 8px 12px;
        border-radius: 8px;
        text-align: center;
        font-weight: bold;
    }
    
    .card-date .day {
        display: block;
        font-size: 1.2rem;
        color: var(--primary-color);
    }
    
    .card-date .month {
        display: block;
        font-size: 0.8rem;
        color: var(--text-light);
        text-transform: uppercase;
    }
    
    .card-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .newsletter-form .form-control {
        border-radius: 25px;
        border: none;
        padding: 15px 20px;
    }
    
    .newsletter-form .btn {
        border-radius: 25px;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 6px 12px;
    }
</style>

<?php require('components/footer.inc.php'); ?>
