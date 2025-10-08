<?php
include 'connect.php';
include 'GetClient.php';

// Get all active products
$products = $conn->query("SELECT * FROM products WHERE client_id = $clientID AND is_active = 1 ORDER BY featured DESC, created_at DESC");

// Get categories for filtering
$categories = $conn->query("SELECT DISTINCT category FROM products WHERE client_id = $clientID AND is_active = 1 AND category IS NOT NULL ORDER BY category");
?>

<?php include 'components/head.inc.php'; ?>
    <title>Our Products - <?php echo isset($general_data['client_name']) ? htmlspecialchars($general_data['client_name']) : 'Church Store'; ?></title>
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .filter-section {
            background: #f8f9fa;
            padding: 30px 0;
        }

        .filter-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid #667eea;
            background: white;
            color: #667eea;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #667eea;
            color: white;
            text-decoration: none;
        }

        .products-section {
            padding: 60px 0;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 40px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e1e5e9;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 280px;
            object-fit: cover;
            object-position: center;
        }

        .product-image-placeholder {
            width: 100%;
            height: 280px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 3rem;
        }

        .product-content {
            padding: 25px;
        }

        .product-category {
            background: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
        }

        .product-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .product-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 20px;
        }

        .product-details {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .product-detail {
            background: #f8f9fa;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            color: #6c757d;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5a6fd8;
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

        .featured-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #ffc107;
            color: #212529;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .product-card {
            position: relative;
        }

        .no-products {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .no-products i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        @media (max-width: 1200px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'components/navbar.inc.php'; ?>

    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">Our Products</h1>
            <p class="hero-subtitle">Discover our collection of religious items, books, and gifts</p>
        </div>
    </div>

    <div class="filter-section">
        <div class="container">
            <div class="filter-buttons">
                <a href="#" class="filter-btn active" data-category="all">All Products</a>
                <?php while ($category = $categories->fetch_assoc()): ?>
                    <a href="#" class="filter-btn" data-category="<?php echo htmlspecialchars($category['category']); ?>">
                        <?php echo htmlspecialchars($category['category']); ?>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="products-section">
        <div class="container">
            <div class="products-grid" id="productsGrid">
                <?php if ($products->num_rows > 0): ?>
                    <?php while ($product = $products->fetch_assoc()): ?>
                        <div class="product-card" data-category="<?php echo htmlspecialchars($product['category']); ?>">
                            <?php if ($product['featured']): ?>
                                <div class="featured-badge">
                                    <i class="fas fa-star"></i> Featured
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product['photo']): ?>
                                <img src="church/uploads/<?php echo htmlspecialchars($product['photo']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                     class="product-image">
                            <?php else: ?>
                                <div class="product-image-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="product-content">
                                <div class="product-category"><?php echo htmlspecialchars($product['category']); ?></div>
                                <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                                
                                <?php if ($product['description']): ?>
                                    <p class="product-description">
                                        <?php echo htmlspecialchars(substr($product['description'], 0, 120)) . (strlen($product['description']) > 120 ? '...' : ''); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                                
                                <div class="product-details">
                                    <?php if ($product['weight']): ?>
                                        <span class="product-detail">
                                            <i class="fas fa-weight"></i> <?php echo htmlspecialchars($product['weight']); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($product['material']): ?>
                                        <span class="product-detail">
                                            <i class="fas fa-cube"></i> <?php echo htmlspecialchars($product['material']); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($product['color']): ?>
                                        <span class="product-detail">
                                            <i class="fas fa-palette"></i> <?php echo htmlspecialchars($product['color']); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($product['stock_quantity'] > 0): ?>
                                        <span class="product-detail">
                                            <i class="fas fa-check-circle"></i> In Stock
                                        </span>
                                    <?php else: ?>
                                        <span class="product-detail" style="background: #f8d7da; color: #721c24;">
                                            <i class="fas fa-times-circle"></i> Out of Stock
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="product-actions">
                                    <a href="contact.php" class="btn btn-primary">
                                        <i class="fas fa-envelope"></i> Inquire
                                    </a>
                                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline">
                                        <i class="fas fa-info-circle"></i> Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-products">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>No Products Available</h3>
                        <p>Check back soon for our latest products!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'components/footer.inc.php'; ?>

    <script>
        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get category to filter
                const category = this.dataset.category;
                
                // Filter products
                const productCards = document.querySelectorAll('.product-card');
                productCards.forEach(card => {
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Product details function (now handled by direct links)
        // function showProductDetails(productId) {
        //     // Redirected to individual product pages
        // }

        // Add some animations
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
