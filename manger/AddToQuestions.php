<?php
session_start();

// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}

require('../connect.php');
include('../manger/nav.php');
include '../GetClient.php';

// Add question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_question"])) {
    $question_text = $conn->real_escape_string($_POST["question_text"]);
    $option1 = $conn->real_escape_string($_POST["option1"]);

    $sql = "INSERT INTO questions (question_text, option1, client_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $question_text, $option1, $clientID);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Edit question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_question"])) {
    $question_id = $conn->real_escape_string($_POST["question_id"]);
    $question_text = $conn->real_escape_string($_POST["question_text"]);
    $option1 = $conn->real_escape_string($_POST["option1"]);

    $sql = "UPDATE questions SET question_text=?, option1=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $question_text, $option1, $question_id);

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

// Delete question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_question"])) {
    $question_id = $conn->real_escape_string($_POST["question_id"]);

    $sql = "DELETE FROM questions WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $question_id);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions - Church Management</title>
    <link rel="icon" href="../img/CrossIcon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #333;
        }

        .page-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 50px 40px;
            border-radius: 20px;
            margin-bottom: 40px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .page-header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }

        .page-header p {
            margin: 15px 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .form-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 35px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f1f2f6;
        }

        .form-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .form-header i {
            color: #667eea;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 1rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: #fff;
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 107, 107, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
            color: #fff;
            box-shadow: 0 8px 25px rgba(81, 207, 102, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(81, 207, 102, 0.4);
        }

        .table-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .table-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px 30px;
            border-bottom: 1px solid #e1e5e9;
        }

        .table-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-header i {
            color: #667eea;
            font-size: 1.5rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 20px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 20px 15px;
            border-bottom: 1px solid #f1f2f6;
            vertical-align: top;
        }

        .data-table tr {
            transition: all 0.3s ease;
        }

        .data-table tr:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            transform: scale(1.01);
        }

        .content-preview {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .empty-state {
            text-align: center;
            padding: 60px 40px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .empty-state h3 {
            margin: 0 0 15px;
            color: #495057;
            font-size: 1.5rem;
        }

        .empty-state p {
            margin: 0;
            font-size: 1rem;
        }

        .edit-form {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid #e1e5e9;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .edit-form .form-group {
            margin-bottom: 18px;
        }

        .edit-form input {
            background: #fff;
        }

        .question-id {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .page-header {
                padding: 30px 20px;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .form-card,
            .table-card {
                padding: 25px;
            }
            
            .data-table {
                font-size: 0.9rem;
            }
            
            .data-table th,
            .data-table td {
                padding: 15px 10px;
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
            <p>Add and manage your church questions and answers</p>
        </div>

        <div class="content-grid">
            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-plus-circle"></i>
                    <h2>Add New Question</h2>
                </div>
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="question_text">Question Text *</label>
                        <textarea id="question_text" name="question_text" required placeholder="Enter your question here..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="option1">Answer *</label>
                        <input type="text" id="option1" name="option1" required placeholder="Enter the answer">
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
                                <th>Answer</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch questions from database
                            $sql = "SELECT * FROM questions WHERE client_id = $clientID ORDER BY id DESC";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><span class='question-id'>" . htmlspecialchars($row["id"]) . "</span></td>";
                                    echo "<td><div class='content-preview'>" . htmlspecialchars($row["question_text"]) . "</div></td>";
                                    echo "<td><div class='content-preview'>" . htmlspecialchars($row["option1"]) . "</div></td>";
                                    echo "<td>";
                                    echo "<div class='action-buttons'>";
                                    
                                    // Edit form
                                    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' class='edit-form'>";
                                    echo "<input type='hidden' name='question_id' value='" . $row["id"] . "'>";
                                    echo "<div class='form-group'>";
                                    echo "<label>Question:</label>";
                                    echo "<input type='text' name='question_text' value='" . htmlspecialchars($row["question_text"]) . "' required>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                    echo "<label>Answer:</label>";
                                    echo "<input type='text' name='option1' value='" . htmlspecialchars($row["option1"]) . "' required>";
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
                                echo "<tr><td colspan='4'>";
                                echo "<div class='empty-state'>";
                                echo "<i class='fas fa-inbox'></i>";
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
