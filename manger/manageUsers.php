<?php
session_start();
require('../connect.php');
require('../GetClient.php');

// Redirect if admin is not logged in
if (!isset($_SESSION['adminUserName']) || empty($_SESSION['adminUserName'])) {
    header("Location: LogInToAdmin.php");
    exit();
}

include('../manger/nav.php');

// Function to add a new admin user
function addAdmin($conn, $username, $password) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        return false;
    }
    
    $stmt->bind_param("ss", $username, $hashedPassword);
    
    if ($stmt->execute()) {
        echo "New admin user created successfully.";
        return true;
    } else {
        echo "Error creating admin user: " . $stmt->error;
        return false;
    }
    
    $stmt->close();
}

// Function to update admin user
function updateAdmin($conn, $id, $username) {
    $stmt = $conn->prepare("UPDATE admins SET username=? WHERE admin_Id=?");
    
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        return false;
    }
    
    $stmt->bind_param("si", $username, $id);
    
    if ($stmt->execute()) {
        echo "Admin user updated successfully.";
        return true;
    } else {
        echo "Error updating admin user: " . $stmt->error;
        return false;
    }
    
    $stmt->close();
}

// Function to delete admin user
function deleteAdmin($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM admins WHERE admin_Id=?");
    
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        return false;
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Admin user deleted successfully.";
        return true;
    } else {
        echo "Error deleting admin user: " . $stmt->error;
        return false;
    }
    
    $stmt->close();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_admin"])) {
        $username = $conn->real_escape_string($_POST["username"]);
        $password = $_POST["password"];
        
        addAdmin($conn, $username, $password);
    } elseif (isset($_POST["edit_admin"])) {
        $id = $_POST["admin_id"];
        $username = $conn->real_escape_string($_POST["username"]);
        
        updateAdmin($conn, $id, $username);
    } elseif (isset($_POST["delete_admin"])) {
        $id = $_POST["admin_id"];
        deleteAdmin($conn, $id);
    }
}

// Fetch existing admins
$admins_query = "SELECT * FROM admins ORDER BY created_at DESC";
$admins_result = $conn->query($admins_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Church Management</title>
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
        .form-group select {
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
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
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

        .user-id {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .user-role {
            background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
            color: #fff;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
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

        .password-strength {
            margin-top: 5px;
            font-size: 0.8rem;
        }

        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #28a745; }

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
            <h1><i class="fas fa-users-cog"></i> Manage Users</h1>
            <p>Add and manage admin users for your church management system</p>
        </div>

        <div class="content-grid">
            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-user-plus"></i>
                    <h2>Add New Admin</h2>
                </div>
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" id="username" name="username" required placeholder="Enter username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required placeholder="Enter password" minlength="6">
                        <div class="password-strength" id="password-strength"></div>
                    </div>

                    <button type="submit" name="add_admin" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Add Admin User
                    </button>
                </form>
            </div>

            <div class="table-card">
                <div class="table-header">
                    <h2><i class="fas fa-list"></i> Existing Admin Users</h2>
                </div>
                
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($admins_result && $admins_result->num_rows > 0) {
                                while ($row = $admins_result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><span class='user-id'>" . htmlspecialchars($row["admin_Id"]) . "</span></td>";
                                    echo "<td><strong>" . htmlspecialchars($row["username"]) . "</strong></td>";
                                    echo "<td><span class='user-role'>Admin</span></td>";
                                    echo "<td>" . date('M d, Y', strtotime($row["created_at"])) . "</td>";
                                    echo "<td>";
                                    echo "<div class='action-buttons'>";
                                    
                                    // Edit form
                                    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' class='edit-form'>";
                                    echo "<input type='hidden' name='admin_id' value='" . $row["admin_Id"] . "'>";
                                    echo "<div class='form-group'>";
                                    echo "<label>Username:</label>";
                                    echo "<input type='text' name='username' value='" . htmlspecialchars($row["username"]) . "' required>";
                                    echo "</div>";
                                    echo "<button type='submit' name='edit_admin' class='btn btn-success btn-sm'>";
                                    echo "<i class='fas fa-save'></i> Save";
                                    echo "</button>";
                                    echo "</form>";
                                    
                                    // Delete button
                                    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' style='display: inline;'>";
                                    echo "<input type='hidden' name='admin_id' value='" . $row["admin_Id"] . "'>";
                                    echo "<button type='submit' name='delete_admin' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this admin user?\")'>";
                                    echo "<i class='fas fa-trash'></i> Delete";
                                    echo "</button>";
                                    echo "</form>";
                                    
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>";
                                echo "<div class='empty-state'>";
                                echo "<i class='fas fa-users'></i>";
                                echo "<h3>No Admin Users Found</h3>";
                                echo "<p>Start by adding some admin users using the form on the left.</p>";
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

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('password-strength');
            
            if (password.length === 0) {
                strengthDiv.textContent = '';
                return;
            }
            
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            if (strength < 2) {
                strengthDiv.textContent = 'Weak password';
                strengthDiv.className = 'password-strength strength-weak';
            } else if (strength < 4) {
                strengthDiv.textContent = 'Medium strength';
                strengthDiv.className = 'password-strength strength-medium';
            } else {
                strengthDiv.textContent = 'Strong password';
                strengthDiv.className = 'password-strength strength-strong';
            }
        });
    </script>
</body>
</html>
