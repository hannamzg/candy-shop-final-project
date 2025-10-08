<?php
include 'connect.php';
include 'GetClient.php';

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    header("Location: products.php");
    exit();
}

// Get product details
$product_sql = "SELECT * FROM products WHERE id = $product_id AND client_id = $clientID AND is_active = 1";
$product_result = $conn->query($product_sql);

if ($product_result->num_rows == 0) {
    header("Location: products.php");
    exit();
}

$product = $product_result->fetch_assoc();

// Get related products (same category, excluding current product)
$related_sql = "SELECT * FROM products WHERE category = '" . mysqli_real_escape_string($conn, $product['category']) . "' AND id != $product_id AND client_id = $clientID AND is_active = 1 ORDER BY featured DESC, created_at DESC LIMIT 4";
$related_products = $conn->query($related_sql);
?>

<?php include 'components/head.inc.php'; ?>
    <title><?php echo htmlspecialchars($product['name']); ?> - <?php echo isset($general_data['client_name']) ? htmlspecialchars($general_data['client_name']) : 'Church Store'; ?></title>
    
    <style>
        .product-detail-section {
            padding: 80px 0;
        }

        .product-image-container {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .product-main-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-main-image:hover {
            transform: scale(1.05);
        }

        .product-image-placeholder {
            width: 100%;
            height: 500px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 5rem;
        }

        .product-info {
            padding-left: 40px;
        }

        .product-category-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 30px;
        }

        .product-description {
            font-size: 1.1rem;
            color: #6c757d;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .product-specs {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .spec-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #e1e5e9;
        }

        .spec-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .spec-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .spec-content {
            flex: 1;
        }

        .spec-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .spec-value {
            color: #6c757d;
        }

        .stock-status {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .stock-in {
            background: #d4edda;
            color: #155724;
        }

        .stock-out {
            background: #f8d7da;
            color: #721c24;
        }

        .product-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-outline {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-outline:hover {
            background: #667eea;
            color: white;
            text-decoration: none;
        }

        .related-products {
            background: #f8f9fa;
            padding: 80px 0;
        }

        .related-products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 40px;
        }

        .related-product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .related-product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            color: inherit;
        }

        .related-product-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            object-position: center;
        }

        .related-product-content {
            padding: 20px;
        }

        .related-product-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .related-product-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #667eea;
        }

        .breadcrumb {
            background: transparent;
            padding: 20px 0;
        }

        .breadcrumb-item a {
            color: #667eea;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .featured-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #ffc107;
            color: #212529;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        @media (max-width: 1200px) {
            .related-products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .related-products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .product-info {
                padding-left: 0;
                margin-top: 30px;
            }
            
            .product-title {
                font-size: 2rem;
            }
            
            .product-actions {
                flex-direction: column;
            }
            
            .related-products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'components/navbar.inc.php'; ?>

    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="products.php">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
            </ol>
        </nav>
    </div>

    <!-- Product Detail Section -->
    <div class="product-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-image-container">
                        <?php if ($product['featured']): ?>
                            <div class="featured-badge">
                                <i class="fas fa-star"></i> Featured
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($product['photo']): ?>
                            <img src="church/uploads/<?php echo htmlspecialchars($product['photo']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="product-main-image">
                        <?php else: ?>
                            <div class="product-image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="product-info">
                        <div class="product-category-badge"><?php echo htmlspecialchars($product['category']); ?></div>
                        
                        <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                        
                        <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                        
                        <div class="stock-status <?php echo $product['stock_quantity'] > 0 ? 'stock-in' : 'stock-out'; ?>">
                            <i class="fas fa-<?php echo $product['stock_quantity'] > 0 ? 'check-circle' : 'times-circle'; ?>"></i>
                            <?php echo $product['stock_quantity'] > 0 ? 'In Stock' : 'Out of Stock'; ?>
                        </div>
                        
                        <?php if ($product['description']): ?>
                            <div class="product-description">
                                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="product-specs">
                            <?php if ($product['weight']): ?>
                                <div class="spec-item">
                                    <div class="spec-icon">
                                        <i class="fas fa-weight"></i>
                                    </div>
                                    <div class="spec-content">
                                        <div class="spec-label">Weight</div>
                                        <div class="spec-value"><?php echo htmlspecialchars($product['weight']); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product['material']): ?>
                                <div class="spec-item">
                                    <div class="spec-icon">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                    <div class="spec-content">
                                        <div class="spec-label">Material</div>
                                        <div class="spec-value"><?php echo htmlspecialchars($product['material']); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product['color']): ?>
                                <div class="spec-item">
                                    <div class="spec-icon">
                                        <i class="fas fa-palette"></i>
                                    </div>
                                    <div class="spec-content">
                                        <div class="spec-label">Color</div>
                                        <div class="spec-value"><?php echo htmlspecialchars($product['color']); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product['dimensions']): ?>
                                <div class="spec-item">
                                    <div class="spec-icon">
                                        <i class="fas fa-ruler-combined"></i>
                                    </div>
                                    <div class="spec-content">
                                        <div class="spec-label">Dimensions</div>
                                        <div class="spec-value"><?php echo htmlspecialchars($product['dimensions']); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="spec-item">
                                <div class="spec-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div class="spec-content">
                                    <div class="spec-label">Stock Quantity</div>
                                    <div class="spec-value"><?php echo $product['stock_quantity']; ?> available</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="product-actions">
                            <a href="contact.php" class="btn btn-primary">
                                <i class="fas fa-envelope"></i>
                                Contact Us
                            </a>
                            <a href="products.php" class="btn btn-outline">
                                <i class="fas fa-arrow-left"></i>
                                Back to Products
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if ($related_products->num_rows > 0): ?>
        <div class="related-products">
            <div class="container">
                <h2 class="section-title">Related Products</h2>
                <p class="section-subtitle">You might also be interested in these items</p>
                
                <div class="related-products-grid">
                    <?php while ($related = $related_products->fetch_assoc()): ?>
                        <a href="product.php?id=<?php echo $related['id']; ?>" class="related-product-card">
                            <?php if ($related['photo']): ?>
                                <img src="church/uploads/<?php echo htmlspecialchars($related['photo']); ?>" 
                                     alt="<?php echo htmlspecialchars($related['name']); ?>" 
                                     class="related-product-image">
                            <?php else: ?>
                                <div class="related-product-image" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                    <i class="fas fa-image" style="font-size: 2rem;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="related-product-content">
                                <h3 class="related-product-name"><?php echo htmlspecialchars($related['name']); ?></h3>
                                <div class="related-product-price">$<?php echo number_format($related['price'], 2); ?></div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php include 'components/footer.inc.php'; ?>

    <script>
        // Add some interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on scroll
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
            const animateElements = document.querySelectorAll('.product-info, .product-specs, .related-product-card');
            animateElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
