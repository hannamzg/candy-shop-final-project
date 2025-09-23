<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .page-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            margin-bottom: 40px;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .hero-section h1 {
            color: #fff;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .hero-section p {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
            margin: 0;
        }

        .faq-container {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .faq-item {
            margin-bottom: 20px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #e1e5e9;
        }

        .faq-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .faq-question {
            width: 100%;
            padding: 20px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            text-align: right;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
            direction: rtl;
        }

        .faq-question:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }

        .faq-question.active {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }

        .faq-icon {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
            margin-left: 15px;
        }

        .faq-icon.rotated {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
        }

        .faq-answer.show {
            max-height: 200px;
        }

        .faq-answer-content {
            padding: 25px;
            color: #555;
            line-height: 1.6;
            font-size: 1rem;
            direction: rtl;
            text-align: right;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        .empty-state p {
            font-size: 1rem;
            color: #666;
        }

        .search-container {
            margin-bottom: 30px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 50px;
            font-size: 1rem;
            background: #fff;
            transition: all 0.3s ease;
            direction: rtl;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.2rem;
        }

        .stats-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-item {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            min-width: 120px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            display: block;
        }

        .stat-label {
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 0 15px;
            }

            .hero-section {
                padding: 30px 20px;
            }

            .hero-section h1 {
                font-size: 2rem;
            }

            .faq-container {
                padding: 20px;
            }

            .faq-question {
                padding: 15px 20px;
                font-size: 1rem;
            }

            .faq-answer-content {
                padding: 20px;
            }

            .stats-container {
                gap: 15px;
            }

            .stat-item {
                min-width: 100px;
                padding: 15px;
            }

            .stat-number {
                font-size: 1.5rem;
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<?php require('GetClient.php');?>
<body>
    <div class="page-container">
        <!-- Hero Section -->
        <div class="hero-section fade-in">
            <h1>
                <?php
                    if ($clientID == 1) {
                        echo "اسئلة وأجوبة عن المسيحية";
                    } else {
                        echo "שאלות נפוצות";
                    }
                ?>
            </h1>
            <p>
                <?php
                    if ($clientID == 1) {
                        echo "اكتشف إجابات الأسئلة الشائعة حول الإيمان المسيحي";
                    } else {
                        echo "גלה תשובות לשאלות הנפוצות על האמונה הנוצרית";
                    }
                ?>
            </p>
        </div>

        <!-- FAQ Container -->
        <div class="faq-container fade-in">
            <?php
                require('connect.php');
                $sql = "SELECT * FROM questions WHERE client_id = $clientID";
                $result = $conn->query($sql);
                $questionCount = $result->num_rows;
            ?>

            <!-- Stats Section -->
            <div class="stats-container">
                <div class="stat-item">
                    <span class="stat-number"><?= $questionCount ?></span>
                    <div class="stat-label">
                        <?php
                            if ($clientID == 1) {
                                echo "أسئلة متاحة";
                            } else {
                                echo "שאלות זמינות";
                            }
                        ?>
                    </div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">
                        <i class="fas fa-question-circle"></i>
                    </span>
                    <div class="stat-label">
                        <?php
                            if ($clientID == 1) {
                                echo "مساعدة";
                            } else {
                                echo "עזרה";
                            }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Questions List -->
            <div id="questions-list">
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $question_id = $row['id'];
                            echo "<div class='faq-item'>
                                    <button class='faq-question' onclick='toggleFAQ({$question_id})'>
                                        <span>" . htmlspecialchars($row['question_text']) . "</span>
                                        <i class='fas fa-chevron-down faq-icon' id='icon-{$question_id}'></i>
                                    </button>
                                    <div class='faq-answer' id='answer-{$question_id}'>
                                        <div class='faq-answer-content'>
                                            " . htmlspecialchars($row['option1']) . "
                                        </div>
                                    </div>
                                  </div>";
                        }
                    } else {
                        echo "<div class='empty-state'>
                                <i class='fas fa-question-circle'></i>
                                <h3>";
                        if ($clientID == 1) {
                            echo "لا توجد أسئلة متاحة حالياً";
                        } else {
                            echo "אין שאלות זמינות כרגע";
                        }
                        echo "</h3>
                                <p>";
                        if ($clientID == 1) {
                            echo "يرجى المحاولة مرة أخرى لاحقاً";
                        } else {
                            echo "אנא נסה שוב מאוחר יותר";
                        }
                        echo "</p>
                              </div>";
                    }
                ?>
            </div>
        </div>
    </div>

    <script>
        function toggleFAQ(questionId) {
            const answer = document.getElementById('answer-' + questionId);
            const icon = document.getElementById('icon-' + questionId);
            const question = answer.previousElementSibling;
            
            // Close all other FAQs
            document.querySelectorAll('.faq-answer').forEach(function(item) {
                if (item.id !== 'answer-' + questionId) {
                    item.classList.remove('show');
                    item.previousElementSibling.classList.remove('active');
                    item.previousElementSibling.querySelector('.faq-icon').classList.remove('rotated');
                }
            });
            
            // Toggle current FAQ
            if (answer.classList.contains('show')) {
                answer.classList.remove('show');
                question.classList.remove('active');
                icon.classList.remove('rotated');
            } else {
                answer.classList.add('show');
                question.classList.add('active');
                icon.classList.add('rotated');
            }
        }

        // Add smooth animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    item.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });

        // Close FAQ when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.faq-item')) {
                document.querySelectorAll('.faq-answer').forEach(function(answer) {
                    answer.classList.remove('show');
                    answer.previousElementSibling.classList.remove('active');
                    answer.previousElementSibling.querySelector('.faq-icon').classList.remove('rotated');
                });
            }
        });
    </script>
</body>

</html>
