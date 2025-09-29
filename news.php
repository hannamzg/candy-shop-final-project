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
        <p>Stay updated with the latest news</p>
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
