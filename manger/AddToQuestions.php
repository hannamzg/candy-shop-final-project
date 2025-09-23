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
    <title>Manage Questions</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        h1 {
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .question-container {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        .question {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>Add New Question</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="question_text">Question:</label><br>
        <input type="text" id="question_text" name="question_text" required><br>
        <label for="option1">Option 1:</label><br>
        <input type="text" id="option1" name="option1" required><br>
        <input type="submit" name="add_question" value="Add Question">
    </form>

    <h1>Edit/Delete Question</h1>
    <?php
    // Fetch questions from database
    $sql = "SELECT * FROM questions WHERE client_id = $clientID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
            echo "<input type='hidden' name='question_id' value='" . $row["id"] . "'>";
            echo "Question: <input type='text' name='question_text' value='" . htmlspecialchars($row["question_text"]) . "' required><br>";
            echo "Option 1: <input type='text' name='option1' value='" . htmlspecialchars($row["option1"]) . "' required><br>";
            echo "<input type='submit' name='edit_question' value='Edit'>";
            echo "<input type='submit' name='delete_question' value='Delete'>";
            echo "</form><br>";
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
</body>

</html>
