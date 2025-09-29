<?php
// Get current page name for active navigation
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <?php if(isset($general_data['icon']) && !empty($general_data['icon'])): ?>
                <img src="church/uploads/<?php echo htmlspecialchars($general_data['icon']); ?>" alt="Logo" height="40" class="me-2">
            <?php else: ?>
                <i class="fas fa-church me-2 text-primary"></i>
            <?php endif; ?>
            <?php echo isset($general_data['client_name']) ? htmlspecialchars($general_data['client_name']) : 'Church'; ?>
        </a>

        <!-- Mobile toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'index') ? 'active fw-bold' : ''; ?>" href="index.php">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>

                <!-- Dynamic Navigation Items from Database -->
                <?php if(!empty($navbar_items)): ?>
                    <?php foreach($navbar_items as $item): ?>
                        <?php
                        $page_name = strtolower(str_replace(' ', '', $item['page_name']));
                        $is_active = false;
                        
                        // Check if current page matches this nav item
                        if($current_page == $page_name || 
                           ($current_page == 'about' && $page_name == 'aboutus') ||
                           ($current_page == 'gallery' && $page_name == 'photogallery') ||
                           ($current_page == 'news' && $page_name == 'news') ||
                           ($current_page == 'contact' && $page_name == 'contactus') ||
                           ($current_page == 'questions' && $page_name == 'questions') ||
                           ($current_page == 'events' && $page_name == 'events')) {
                            $is_active = true;
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $is_active ? 'active fw-bold' : ''; ?>" href="<?php echo htmlspecialchars($item['page_link']); ?>">
                                <?php
                                // Add appropriate icons based on page name
                                $icon = 'fas fa-file-alt';
                                if(strpos(strtolower($item['page_name']), 'about') !== false) $icon = 'fas fa-info-circle';
                                elseif(strpos(strtolower($item['page_name']), 'gallery') !== false) $icon = 'fas fa-images';
                                elseif(strpos(strtolower($item['page_name']), 'news') !== false) $icon = 'fas fa-newspaper';
                                elseif(strpos(strtolower($item['page_name']), 'contact') !== false) $icon = 'fas fa-envelope';
                                elseif(strpos(strtolower($item['page_name']), 'service') !== false) $icon = 'fas fa-hands-praying';
                                elseif(strpos(strtolower($item['page_name']), 'question') !== false) $icon = 'fas fa-question-circle';
                                elseif(strpos(strtolower($item['page_name']), 'event') !== false) $icon = 'fas fa-calendar-alt';
                                ?>
                                <i class="<?php echo $icon; ?> me-1"></i><?php echo htmlspecialchars($item['page_name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default Navigation if no database items -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'about') ? 'active fw-bold' : ''; ?>" href="about.php">
                            <i class="fas fa-info-circle me-1"></i>About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'events') ? 'active fw-bold' : ''; ?>" href="events.php">
                            <i class="fas fa-calendar-alt me-1"></i>Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'gallery') ? 'active fw-bold' : ''; ?>" href="gallery.php">
                            <i class="fas fa-images me-1"></i>Gallery
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'news') ? 'active fw-bold' : ''; ?>" href="news.php">
                            <i class="fas fa-newspaper me-1"></i>News
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'contact') ? 'active fw-bold' : ''; ?>" href="contact.php">
                            <i class="fas fa-envelope me-1"></i>Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'questions') ? 'active fw-bold' : ''; ?>" href="questions.php">
                            <i class="fas fa-question-circle me-1"></i>Questions
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Contact Button -->
                <li class="nav-item ms-2">
                    <a class="btn btn-primary" href="contact.php">
                        <i class="fas fa-phone me-1"></i>Contact Us
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Add top margin to body content to account for fixed navbar -->
<style>
    body {
        padding-top: 80px;
    }
    
    .navbar {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95) !important;
    }
    
    .nav-link.active {
        color: var(--secondary-color) !important;
        position: relative;
    }
    
    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 2px;
        background-color: var(--secondary-color);
        border-radius: 2px;
    }
    
    @media (max-width: 991px) {
        .nav-link.active::after {
            display: none;
        }
        
        .navbar-collapse {
            background-color: white;
            border-radius: 10px;
            margin-top: 10px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    }
</style>
