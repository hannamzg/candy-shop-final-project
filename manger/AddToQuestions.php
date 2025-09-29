<?php
session_start();
include '../connect.php';
include '../GetClient.php';

// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}

include('../manger/nav.php');

// Function to add a new question
function addQuestion($conn, $question_text, $option1, $option2, $option3, $correct_option, $clientID) {
    $stmt = $conn->prepare("INSERT INTO questions (client_id, question_text, option1, option2, option3, correct_option, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        return false;
    }
    
    $stmt->bind_param("issssi", $clientID, $question_text, $option1, $option2, $option3, $correct_option);
    
    if ($stmt->execute()) {
        echo "New question created successfully.";
        return true;
    } else {
        echo "Error creating question: " . $stmt->error;
        return false;
    }
    
    $stmt->close();
}

// Function to update question
function updateQuestion($conn, $id, $question_text, $option1, $option2, $option3, $correct_option) {
    $stmt = $conn->prepare("UPDATE questions SET question_text=?, option1=?, option2=?, option3=?, correct_option=? WHERE id=?");
    
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        return false;
    }
    
    $stmt->bind_param("ssssii", $question_text, $option1, $option2, $option3, $correct_option, $id);
    
    if ($stmt->execute()) {
        echo "Question updated successfully.";
        return true;
    } else {
        echo "Error updating question: " . $stmt->error;
        return false;
    }
    
    $stmt->close();
}

// Function to delete question
function deleteQuestion($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM questions WHERE id=?");
    
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        return false;
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Question deleted successfully.";
        return true;
    } else {
        echo "Error deleting question: " . $stmt->error;
        return false;
    }
    
    $stmt->close();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_question"])) {
        $question_text = $conn->real_escape_string($_POST["question_text"]);
        $option1 = $conn->real_escape_string($_POST["option1"]);
        $option2 = $conn->real_escape_string($_POST["option2"]);
        $option3 = $conn->real_escape_string($_POST["option3"]);
        $correct_option = $_POST["correct_option"];
        
        addQuestion($conn, $question_text, $option1, $option2, $option3, $correct_option, $clientID);
    } elseif (isset($_POST["edit_question"])) {
        $id = $_POST["question_id"];
        $question_text = $conn->real_escape_string($_POST["question_text"]);
        $option1 = $conn->real_escape_string($_POST["option1"]);
        $option2 = $conn->real_escape_string($_POST["option2"]);
        $option3 = $conn->real_escape_string($_POST["option3"]);
        $correct_option = $_POST["correct_option"];
        
        updateQuestion($conn, $id, $question_text, $option1, $option2, $option3, $correct_option);
    } elseif (isset($_POST["delete_question"])) {
        $id = $_POST["question_id"];
        deleteQuestion($conn, $id);
    }
}

// Fetch existing questions
$questions_query = "SELECT * FROM questions WHERE client_id = $clientID ORDER BY created_at DESC";
$questions_result = $conn->query($questions_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions - Church Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .page-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .page-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 25px;
            border: 1px solid #e1e5e9;
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f2f6;
        }

        .form-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.3rem;
        }

        .form-header i {
            color: #667eea;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-danger {
            background: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .table-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e1e5e9;
        }

        .table-header {
            background: #f8f9fa;
            padding: 20px 25px;
            border-bottom: 1px solid #e1e5e9;
        }

        .table-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-header i {
            color: #667eea;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #667eea;
            color: #fff;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #e1e5e9;
            vertical-align: top;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        .question-id {
            background: #667eea;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 0.85rem;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .empty-state h3 {
            margin: 0 0 10px;
            color: #495057;
        }

        .empty-state p {
            margin: 0;
            font-size: 0.9rem;
        }

        .edit-form {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #e1e5e9;
        }

        .edit-form .form-group {
            margin-bottom: 15px;
        }

        .edit-form input,
        .edit-form select,
        .edit-form textarea {
            background: #fff;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .data-table {
                font-size: 0.85rem;
            }
            
            .data-table th,
            .data-table td {
                padding: 10px 8px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="page-header">
            <h1><i class="fas fa-question-circle"></i> Manage Questions</h1>
            <p>Add and manage questions for your church community</p>
        </div>

        <div class="content-grid">
            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-plus"></i>
                    <h2>Add New Question</h2>
                </div>
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="question_text">Question Text *</label>
                        <textarea id="question_text" name="question_text" required placeholder="Enter your question"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="option1">Option 1 *</label>
                        <input type="text" id="option1" name="option1" required placeholder="Enter first option">
                    </div>

                    <div class="form-group">
                        <label for="option2">Option 2 *</label>
                        <input type="text" id="option2" name="option2" required placeholder="Enter second option">
                    </div>

                    <div class="form-group">
                        <label for="option3">Option 3 *</label>
                        <input type="text" id="option3" name="option3" required placeholder="Enter third option">
                    </div>

                    <div class="form-group">
                        <label for="correct_option">Correct Option *</label>
                        <select id="correct_option" name="correct_option" required>
                            <option value="">Select correct option</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                        </select>
                    </div>

                    <button type="submit" name="add_question" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Add Question
                    </button>
                </form>
            </div>

            <div class="table-card">
                <div class="table-header">
                    <h2><i class="fas fa-list"></i> Existing Questions</h2>
                </div>
                
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Options</th>
                                <th>Correct</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($questions_result && $questions_result->num_rows > 0) {
                                while ($row = $questions_result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><span class='question-id'>" . htmlspecialchars($row["id"]) . "</span></td>";
                                    echo "<td><strong>" . htmlspecialchars($row["question_text"]) . "</strong></td>";
                                    echo "<td>";
                                    echo "<div style='font-size: 0.85rem;'>";
                                    echo "1. " . htmlspecialchars($row["option1"]) . "<br>";
                                    echo "2. " . htmlspecialchars($row["option2"]) . "<br>";
                                    echo "3. " . htmlspecialchars($row["option3"]);
                                    echo "</div>";
                                    echo "</td>";
                                    echo "<td><strong>Option " . $row["correct_option"] . "</strong></td>";
                                    echo "<td>" . date('M d, Y', strtotime($row["created_at"])) . "</td>";
                                    echo "<td>";
                                    echo "<div class='action-buttons'>";
                                    
                                    // Edit form
                                    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' class='edit-form'>";
                                    echo "<input type='hidden' name='question_id' value='" . $row["id"] . "'>";
                                    echo "<div class='form-group'>";
                                    echo "<label>Question:</label>";
                                    echo "<textarea name='question_text' required>" . htmlspecialchars($row["question_text"]) . "</textarea>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                    echo "<label>Option 1:</label>";
                                    echo "<input type='text' name='option1' value='" . htmlspecialchars($row["option1"]) . "' required>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                    echo "<label>Option 2:</label>";
                                    echo "<input type='text' name='option2' value='" . htmlspecialchars($row["option2"]) . "' required>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                    echo "<label>Option 3:</label>";
                                    echo "<input type='text' name='option3' value='" . htmlspecialchars($row["option3"]) . "' required>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                    echo "<label>Correct Option:</label>";
                                    echo "<select name='correct_option' required>";
                                    echo "<option value='1'" . ($row["correct_option"] == 1 ? " selected" : "") . ">Option 1</option>";
                                    echo "<option value='2'" . ($row["correct_option"] == 2 ? " selected" : "") . ">Option 2</option>";
                                    echo "<option value='3'" . ($row["correct_option"] == 3 ? " selected" : "") . ">Option 3</option>";
                                    echo "</select>";
                                    echo "</div>";
                                    echo "<button type='submit' name='edit_question' class='btn btn-success btn-sm'>";
                                    echo "<i class='fas fa-save'></i> Save";
                                    echo "</button>";
                                    echo "</form>";
                                    
                                    // Delete button
                                    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' style='display: inline;'>";
                                    echo "<input type='hidden' name='question_id' value='" . $row["id"] . "'>";
                                    echo "<button type='submit' name='delete_question' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this question?\")'>";
                                    echo "<i class='fas fa-trash'></i> Delete";
                                    echo "</button>";
                                    echo "</form>";
                                    
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>";
                                echo "<div class='empty-state'>";
                                echo "<i class='fas fa-question-circle'></i>";
                                echo "<h3>No Questions Found</h3>";
                                echo "<p>Start by adding some questions using the form on the left.</p>";
                                echo "</div>";
                                echo "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const requiredFields = this.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.style.borderColor = '#dc3545';
                        isValid = false;
                    } else {
                        field.style.borderColor = '#e1e5e9';
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                }
            });
        });
    </script>
</body>
</html>