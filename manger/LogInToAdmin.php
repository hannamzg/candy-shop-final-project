<?php
session_start();
include '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $_POST["password"];

    // Check if the user is temporarily locked out
    $attempts_sql = "SELECT attempts, last_attempt FROM login_attempts WHERE username = ?";
    $attempts_stmt = $conn->prepare($attempts_sql);
    $attempts_stmt->bind_param("s", $username);
    $attempts_stmt->execute();
    $attempts_result = $attempts_stmt->get_result();
    $attempts_row = $attempts_result->fetch_assoc();

    if ($attempts_row) {
        $attempts = $attempts_row['attempts'];
        $last_attempt = strtotime($attempts_row['last_attempt']);
        $current_time = time();

        // Lockout period: 15 minutes
        if ($attempts >= 5 && ($current_time - $last_attempt) < 900) {
            echo "<p class='error-message'>Account locked due to multiple failed attempts. Please try again later.</p>";
            exit();
        }
    }

    $sql = "SELECT admin_Id, password FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];
        //to build hash for the first time
        //echo password_hash('admin123', PASSWORD_DEFAULT), PHP_EOL;
         // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Reset attempts on successful login
            $reset_sql = "DELETE FROM login_attempts WHERE username = ?";
            $reset_stmt = $conn->prepare($reset_sql);
            $reset_stmt->bind_param("s", $username);
            $reset_stmt->execute();

            $_SESSION['adminUserName'] = true;
            header("Location: index.php");
            exit();
        } else {
            // Log the failed attempt
            if ($attempts_row) {
                $update_attempts_sql = "UPDATE login_attempts SET attempts = attempts + 1, last_attempt = NOW() WHERE username = ?";
                $update_stmt = $conn->prepare($update_attempts_sql);
                $update_stmt->bind_param("s", $username);
            } else {
                $insert_attempts_sql = "INSERT INTO login_attempts (username, attempts) VALUES (?, 1)";
                $insert_stmt = $conn->prepare($insert_attempts_sql);
                $insert_stmt->bind_param("s", $username);
            }

            if (isset($update_stmt)) {
                $update_stmt->execute();
            } else {
                $insert_stmt->execute();
            }

            echo "<p class='error-message'>Invalid username or password.</p>";
        }
    } else {
        echo "<p class='error-message'>Invalid username or password.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        p.error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login to Admin</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>
