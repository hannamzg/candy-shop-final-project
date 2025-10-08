<?php

if (isset($_GET['logout'])) {
    unset($_SESSION['adminUserName']);
    session_destroy();
    header("Location: LogInToAdmin.php");
    exit();
}

session_start();
// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}
?>

<meta name="robots" content="noindex, nofollow">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: all 0.3s ease;
        overflow-y: auto;
    }

    .sidebar-header {
        padding: 20px;
        background: rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
    }

    .sidebar-header h3 {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .sidebar-header p {
        color: #bdc3c7;
        font-size: 0.8rem;
    }

    .nav-menu {
        padding: 20px 0;
    }

    .nav-section {
        margin-bottom: 30px;
    }

    .nav-section-title {
        color: #95a5a6;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 0 20px 10px;
        margin-bottom: 10px;
    }

    .nav-item {
        display: block;
        color: #ecf0f1;
        text-decoration: none;
        padding: 12px 20px;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        position: relative;
    }

    .nav-item:hover {
        background: rgba(255, 255, 255, 0.1);
        border-left-color: #3498db;
        color: #fff;
        transform: translateX(5px);
    }

    .nav-item.active {
        background: rgba(52, 152, 219, 0.2);
        border-left-color: #3498db;
        color: #3498db;
    }

    .nav-item i {
        width: 20px;
        margin-right: 12px;
        text-align: center;
        font-size: 1rem;
    }

    .nav-item .nav-text {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .nav-item.logout {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 20px;
        color: #e74c3c;
    }

    .nav-item.logout:hover {
        background: rgba(231, 76, 60, 0.1);
        border-left-color: #e74c3c;
        color: #e74c3c;
    }

    .main-content {
        margin-left: 280px;
        min-height: 100vh;
        transition: all 0.3s ease;
    }

    .top-bar {
        background: #fff;
        padding: 15px 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
    }

    .content-area {
        padding: 30px;
    }

    .mobile-toggle {
        display: none;
        background: none;
        border: none;
        color: #2c3e50;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 5px;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
        }

        .mobile-toggle {
            display: block;
        }

        .content-area {
            padding: 20px 15px;
        }
    }

    /* Scrollbar styling */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
</style>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3></i> Admin Panel</h3>
        <p>Management System</p>
    </div>
    
    <nav class="nav-menu">
        <div class="nav-section">
            <div class="nav-section-title">Dashboard</div>
            <a href="../manger/index.php" class="nav-item">
                <i class="fas fa-home"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Content Management</div>
            <a href="../manger/AddToMainImgSilder.php" class="nav-item">
                <i class="fas fa-images"></i>
                <span class="nav-text">Main Slider Images</span>
            </a>
            <a href="../manger/mangeText.php" class="nav-item">
                <i class="fas fa-edit"></i>
                <span class="nav-text">Manage Text Content</span>
            </a>
            <a href="../manger/AddToQuestions.php" class="nav-item">
                <i class="fas fa-question-circle"></i>
                <span class="nav-text">Questions & Answers</span>
            </a>
            <a href="../manger/productManage.php" class="nav-item">
                <i class="fas fa-shopping-bag"></i>
                <span class="nav-text">Product Management</span>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Class Management</div>
            <a href="../manger/classMange.php" class="nav-item">
                <i class="fas fa-chalkboard-teacher"></i>
                <span class="nav-text">Class Content</span>
            </a>
            <a href="../manger/addAndDeleteClass.php" class="nav-item">
                <i class="fas fa-plus-circle"></i>
                <span class="nav-text">Add/Delete Classes</span>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Settings</div>
            <a href="../manger/calendarMange.php" class="nav-item">
                <i class="fas fa-calendar-alt"></i>
                <span class="nav-text">Calendar Management</span>
            </a>
            <a href="../manger/SetGeneral.php" class="nav-item">
                <i class="fas fa-cog"></i>
                <span class="nav-text">General Settings</span>
            </a>
            <a href="../manger/manageUsers.php" class="nav-item">
                <i class="fas fa-users-cog"></i>
                <span class="nav-text">Manage Users</span>
            </a>
        </div>

        <div class="nav-section">
            <a href="/index.php" class="nav-item">
                <i class="fas fa-external-link-alt"></i>
                <span class="nav-text">View Main Website</span>
            </a>
            <a href="?logout" class="nav-item logout">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-text">Logout</span>
            </a>
        </div>
    </nav>
</div>

<div class="main-content">
    <div class="top-bar">
        <button class="mobile-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title" id="pageTitle">Dashboard</h1>
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </div>
    <div class="content-area">

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
}

// Set active nav item based on current page
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname;
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        if (item.getAttribute('href') && currentPage.includes(item.getAttribute('href'))) {
            item.classList.add('active');
        }
    });

    // Update page title based on active nav item
    const activeItem = document.querySelector('.nav-item.active');
    if (activeItem) {
        const pageTitle = document.getElementById('pageTitle');
        const navText = activeItem.querySelector('.nav-text').textContent;
        pageTitle.textContent = navText;
    }
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const mobileToggle = document.querySelector('.mobile-toggle');
    
    if (window.innerWidth <= 768 && 
        !sidebar.contains(event.target) && 
        !mobileToggle.contains(event.target)) {
        sidebar.classList.remove('open');
    }
});
</script>