<?php require('components/head.inc.php'); ?>
<?php include('components/navbar.inc.php'); ?>

<?php
// Get page data from pages table (page = 2 for Gallery)
$page_query = "SELECT * FROM pages WHERE id = 2";
$page_result = $conn->query($page_query);
$page_data = $page_result->fetch_assoc();

// Get main slider images for gallery page
$gallery_query = "SELECT * FROM mainsilderimg WHERE page = 2 ORDER BY created_at DESC";
$gallery_result = $conn->query($gallery_query);
$gallery_images = [];
while($row = $gallery_result->fetch_assoc()) {
    $gallery_images[] = $row;
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><?php echo isset($page_data['pageName']) ? htmlspecialchars($page_data['pageName']) : 'Photo Gallery'; ?></h1>
        <p>Capturing moments of faith, fellowship, and community</p>
    </div>
</section>

<!-- Gallery Grid Section -->
<section class="content-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Our Gallery</h2>
                <p class="section-subtitle">Moments of worship, fellowship, and community life</p>
            </div>
        </div>
        
        <!-- Gallery Grid -->
        <div class="row g-4">
            <?php if(!empty($gallery_images)): ?>
                <?php foreach($gallery_images as $index => $image): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                            <img src="church/uploads/<?php echo htmlspecialchars($image['img']); ?>" alt="Gallery Image <?php echo $index + 1; ?>" class="img-fluid">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default gallery images -->
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="img/Cross-Background.jpg" alt="Worship Service" class="img-fluid">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="img/OIG1.jpg" alt="Church Event" class="img-fluid">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="img/OIG2.84xOLuE.jpg" alt="Community Gathering" class="img-fluid">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require('components/footer.inc.php'); ?>
