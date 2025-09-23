<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('components/head.inc.php'); 
include('components/navbar.inc.php');
require('connect.php');
require('GetClient.php');

// Get program data
function getProgram() {
    global $conn, $clientID;
    
    // Check if table exists, if not create it
    $checkTable = $conn->query("SHOW TABLES LIKE 'weekly_program'");
    if ($checkTable->num_rows == 0) {
        $createTable = "CREATE TABLE `weekly_program` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL,
            `description` text NOT NULL,
            `date` date NOT NULL,
            `time` time NOT NULL,
            `location` varchar(255) NOT NULL,
            `client_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        
        if ($conn->query($createTable)) {
            // Insert sample data based on language
            $isHebrew = isset($clientInfo['lang']) && $clientInfo['lang'] === 'he';
            
            if ($isHebrew) {
                $sampleData = [
                    "INSERT INTO `weekly_program` (`title`, `description`, `date`, `time`, `location`, `client_id`) VALUES ('תפילת שחרית', 'תפילת שחרית יומית', CURDATE(), '08:00:00', 'בית הכנסת', $clientID)",
                    "INSERT INTO `weekly_program` (`title`, `description`, `date`, `time`, `location`, `client_id`) VALUES ('לימוד תורה', 'שיעור תורה שבועי', DATE_ADD(CURDATE(), INTERVAL 1 DAY), '19:00:00', 'בית הכנסת', $clientID)",
                    "INSERT INTO `weekly_program` (`title`, `description`, `date`, `time`, `location`, `client_id`) VALUES ('תפילת מנחה', 'תפילת מנחה יומית', CURDATE(), '18:30:00', 'בית הכנסת', $clientID)"
                ];
            } else {
                $sampleData = [
                    "INSERT INTO `weekly_program` (`title`, `description`, `date`, `time`, `location`, `client_id`) VALUES ('صلاة الفجر', 'صلاة الفجر اليومية', CURDATE(), '08:00:00', 'المسجد', $clientID)",
                    "INSERT INTO `weekly_program` (`title`, `description`, `date`, `time`, `location`, `client_id`) VALUES ('درس القرآن', 'درس القرآن الأسبوعي', DATE_ADD(CURDATE(), INTERVAL 1 DAY), '19:00:00', 'المسجد', $clientID)",
                    "INSERT INTO `weekly_program` (`title`, `description`, `date`, `time`, `location`, `client_id`) VALUES ('صلاة المغرب', 'صلاة المغرب اليومية', CURDATE(), '18:30:00', 'المسجد', $clientID)"
                ];
            }
            
            foreach ($sampleData as $sql) {
                $conn->query($sql);
            }
        }
    }
    
    // Query with client_id filtering
    $result = $conn->query("SELECT * FROM weekly_program WHERE client_id = $clientID ORDER BY date, time");
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; 
    }
}

$programData = getProgram();

// Debug information
if (empty($programData)) {
    // Check if table exists and has data
    $checkTable = $conn->query("SHOW TABLES LIKE 'weekly_program'");
    if ($checkTable->num_rows == 0) {
        $error_message = "Table 'weekly_program' does not exist";
    } else {
        $countResult = $conn->query("SELECT COUNT(*) as count FROM weekly_program WHERE client_id = $clientID");
        $totalCountResult = $conn->query("SELECT COUNT(*) as count FROM weekly_program");
        $count = $countResult ? $countResult->fetch_assoc()['count'] : 0;
        $totalCount = $totalCountResult ? $totalCountResult->fetch_assoc()['count'] : 0;
        $error_message = "No events found for client_id: $clientID (Client events: $count, Total events: $totalCount)";
    }
}

// Language detection and setup
$isHebrew = isset($clientInfo['lang']) && $clientInfo['lang'] === 'he';
$lang = $isHebrew ? 'he' : 'ar';
$direction = $isHebrew ? 'rtl' : 'rtl'; // Both Hebrew and Arabic are RTL

// Language-specific text
$texts = [
    'he' => [
        'title' => 'התוכנית השבועית',
        'title_label' => 'כותרת',
        'description_label' => 'תיאור',
        'date_label' => 'תאריך',
        'time_label' => 'שעה',
        'location_label' => 'מיקום',
        'no_events' => 'אין אירועים מתוכננים השבוע',
        'add_event' => 'הוסף אירוע'
    ],
    'ar' => [
        'title' => 'البرنامج الأسبوعي',
        'title_label' => 'العنوان',
        'description_label' => 'الوصف',
        'date_label' => 'التاريخ',
        'time_label' => 'الوقت',
        'location_label' => 'الموقع',
        'no_events' => 'لا توجد أحداث مجدولة هذا الأسبوع',
        'add_event' => 'إضافة حدث'
    ]
];

$currentTexts = $texts[$lang];
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $direction ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $currentTexts['title'] ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: <?= $isHebrew ? "'Segoe UI', 'Arial Hebrew', 'David', sans-serif" : "'Segoe UI', 'Arial Arabic', 'Tahoma', sans-serif" ?>;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            direction: <?= $direction ?>;
        }

        .calendar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .calendar-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .calendar-header h1 {
            font-size: <?= $isHebrew ? '2.5rem' : '2.2rem' ?>;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .calendar-header p {
            color: #666;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .events-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .events-grid {
            display: grid;
            gap: 20px;
        }

        .event-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #e1e5e9;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            <?= $isHebrew ? 'right' : 'left' ?>: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .event-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            line-height: 1.3;
        }

        .event-date-time {
            display: flex;
            flex-direction: column;
            align-items: <?= $isHebrew ? 'flex-start' : 'flex-end' ?>;
            gap: 5px;
        }

        .event-date {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .event-time {
            background: #f8f9fa;
            color: #495057;
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 500;
            font-size: 0.85rem;
            border: 1px solid #e9ecef;
        }

        .event-description {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .event-location {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .event-location i {
            font-size: 1rem;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .empty-state h3 {
            margin: 0 0 10px;
            color: #495057;
            font-size: 1.3rem;
        }

        .empty-state p {
            margin: 0;
            font-size: 1rem;
        }

        .add-event-btn {
            position: fixed;
            <?= $isHebrew ? 'left' : 'right' ?>: 30px;
            bottom: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 15px 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
        }

        .add-event-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .add-event-btn i {
            font-size: 1.2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .calendar-container {
                padding: 15px;
            }

            .calendar-header {
                padding: 20px;
            }

            .calendar-header h1 {
                font-size: <?= $isHebrew ? '2rem' : '1.8rem' ?>;
            }

            .events-container {
                padding: 20px;
            }

            .event-header {
                flex-direction: column;
                align-items: <?= $isHebrew ? 'flex-end' : 'flex-start' ?>;
            }

            .event-date-time {
                align-items: <?= $isHebrew ? 'flex-end' : 'flex-start' ?>;
            }

            .add-event-btn {
                <?= $isHebrew ? 'left' : 'right' ?>: 20px;
                bottom: 20px;
                padding: 12px 20px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .calendar-header h1 {
                font-size: <?= $isHebrew ? '1.8rem' : '1.6rem' ?>;
            }

            .event-card {
                padding: 20px;
            }

            .event-title {
                font-size: 1.2rem;
            }
        }

        /* Hebrew specific adjustments */
        <?php if ($isHebrew): ?>
        .event-card::before {
            right: 0;
            left: auto;
        }

        .event-date-time {
            align-items: flex-start;
        }

        .event-location {
            direction: rtl;
        }

        .add-event-btn {
            left: 30px;
            right: auto;
        }

        @media (max-width: 768px) {
            .add-event-btn {
                left: 20px;
                right: auto;
            }
        }
        <?php endif; ?>

        /* Animation for cards */
        .event-card {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stagger animation for multiple cards */
        .event-card:nth-child(1) { animation-delay: 0.1s; }
        .event-card:nth-child(2) { animation-delay: 0.2s; }
        .event-card:nth-child(3) { animation-delay: 0.3s; }
        .event-card:nth-child(4) { animation-delay: 0.4s; }
        .event-card:nth-child(5) { animation-delay: 0.5s; }
    </style>
</head>
<body>
    <div class="calendar-container">
        <div class="calendar-header">
            <h1><i class="fas fa-calendar-alt"></i> <?= $currentTexts['title'] ?></h1>
            <p><?= $isHebrew ? 'האירועים והפעילויות השבועיות שלנו' : 'أحداث وأنشطتنا الأسبوعية' ?></p>
        </div>

        <div class="events-container">
            <?php if (!empty($programData)): ?>
                <div class="events-grid">
                    <?php foreach ($programData as $index => $item): ?>
                        <div class="event-card">
                            <div class="event-header">
                                <h3 class="event-title"><?= htmlspecialchars($item['title']) ?></h3>
                                <div class="event-date-time">
                                    <div class="event-date">
                                        <i class="fas fa-calendar"></i> <?= htmlspecialchars($item['date']) ?>
                                    </div>
                                    <div class="event-time">
                                        <i class="fas fa-clock"></i> <?= htmlspecialchars($item['time']) ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!empty($item['description'])): ?>
                                <div class="event-description">
                                    <?= htmlspecialchars($item['description']) ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($item['location'])): ?>
                                <div class="event-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?= htmlspecialchars($item['location']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h3><?= $currentTexts['no_events'] ?></h3>
                    <p><?= $isHebrew ? 'נא לבדוק שוב מאוחר יותר' : 'يرجى التحقق مرة أخرى لاحقاً' ?></p>
                    <?php if (isset($error_message)): ?>
                        <div style="margin-top: 20px; padding: 15px; background: #f8d7da; color: #721c24; border-radius: 8px; font-size: 0.9rem;">
                            <strong>Debug Info:</strong> <?= htmlspecialchars($error_message) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Event Button (for admin access) -->
    <?php if (isset($_SESSION['adminUserName'])): ?>
        <a href="/manger/calendarMange.php" class="add-event-btn">
            <i class="fas fa-plus"></i>
            <?= $currentTexts['add_event'] ?>
        </a>
    <?php endif; ?>

    <script>
        // Add some interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate event cards on load
            const eventCards = document.querySelectorAll('.event-card');
            eventCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
</body>
</html>
