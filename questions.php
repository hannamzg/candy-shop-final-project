<?php 
require('connect.php');
require('GetClient.php');
require('components/head.inc.php'); 
include('components/navbar.inc.php'); 

// Get page data from pages table (page = 5 for Questions)
$page_query = "SELECT * FROM pages WHERE id = 5";
$page_result = $conn->query($page_query);
$page_data = $page_result ? $page_result->fetch_assoc() : null;

// Get questions from database
$questions_query = "SELECT * FROM questions WHERE client_id = $clientID ORDER BY id ASC";
$questions_result = $conn->query($questions_query);
$questions = [];
while($row = $questions_result->fetch_assoc()) {
    $questions[] = $row;
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><?php echo isset($page_data['pageName']) ? htmlspecialchars($page_data['pageName']) : 'Questions'; ?></h1>
        <p><?php echo isset($page_data['description']) ? htmlspecialchars($page_data['description']) : 'Test your knowledge with our questions'; ?></p>
    </div>
</section>

<!-- Questions Section -->
<section class="content-section">
    <div class="container">
        <?php if(!empty($questions)): ?>
            <div class="questions-container">
                <?php foreach($questions as $index => $question): ?>
                    <div class="question-card">
                        <div class="question-header">
                            <div class="question-number"><?php echo $index + 1; ?></div>
                            <h3 class="question-title"><?php echo htmlspecialchars($question['question_text']); ?></h3>
                        </div>
                        <div class="question-options">
                            <div class="option-item">
                                <span class="option-label">Answer:</span>
                                <span class="option-text"><?php echo htmlspecialchars($question['option1']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3>No Questions Available</h3>
                <p>We are working on adding questions. Please check back soon!</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 80px 0;
    text-align: center;
    margin-bottom: 50px;
}

.page-header h1 {
    font-size: 3rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.page-header p {
    font-size: 1.2rem;
    margin: 15px 0 0;
    opacity: 0.9;
}

.questions-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px 0;
}

.question-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    overflow: hidden;
    border: 1px solid #e1e5e9;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.question-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.question-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
}

.question-number {
    background: rgba(255, 255, 255, 0.2);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: bold;
    flex-shrink: 0;
}

.question-title {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    line-height: 1.4;
}

.question-options {
    padding: 25px;
}

.option-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.option-label {
    font-weight: 600;
    color: #667eea;
    min-width: 80px;
}

.option-text {
    color: #2c3e50;
    font-size: 1.1rem;
    line-height: 1.5;
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #6c757d;
}

.empty-icon {
    margin-bottom: 30px;
}

.empty-icon i {
    font-size: 5rem;
    color: #dee2e6;
}

.empty-state h3 {
    font-size: 2rem;
    margin-bottom: 15px;
    color: #495057;
}

.empty-state p {
    font-size: 1.2rem;
    margin: 0;
    max-width: 500px;
    margin: 0 auto;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }
    
    .question-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .question-number {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .question-title {
        font-size: 1.1rem;
    }
    
    .option-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .option-label {
        min-width: auto;
    }
}

@media (max-width: 480px) {
    .questions-container {
        padding: 10px;
    }
    
    .question-header,
    .question-options {
        padding: 20px;
    }
}
</style>

<?php require('components/footer.inc.php'); ?>
