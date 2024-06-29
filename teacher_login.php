<?php
session_start();
include "connect.php"; // Include the database connection


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Server-side validation
    $errors = [];

    if (empty($username)) {
        $errors[] = 'Username is required.';
    }

    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        // Prepare and bind
        $stmt = $con->prepare("SELECT * FROM teacher WHERE tname = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Password is correct
                $_SESSION['teacher_name'] = $username;
                // $_SESSION["teacher_name"] = $username;
                header('Location: teacher_dashboard.php');
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: skyblue url('background_img.jpg') no-repeat;
            background-size: cover;
        }
        .login-form {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.9); /* White with 90% opacity */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #fff; /* White text color */
        }
        .login-form .form-group label {
            font-weight: 500;
            color: #fff; /* White text color */
        }
        .login-form .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .login-form .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .login-form .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .login-form .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .login-form .register-link {
            color: #fff;
        }
        .login-form .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <form action="teacher_login.php" method="POST">
            <h2 class="text-center">Teacher Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <button type="button" class="btn btn-secondary btn-block" onclick="window.history.back();">Back</button>
            <div class="text-center mt-4">
                <a href="register_teacher.php" class="register-link">Don't have an account? Register here</a>
            </div>
        </form>
    </div>
</body>
</html>
