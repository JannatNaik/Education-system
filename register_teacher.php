<?php
session_start();
include "connect.php"; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'teacher'; // Set the role to teacher for this page

    // Server-side validation
    $errors = [];

    if (empty($username)) {
        $errors[] = 'Username is required.';
    }

    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        // Check if user already exists
        $check_query = "SELECT * FROM teacher WHERE tname = '$username'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // User already exists
            echo '<script>
                    alert("User already exists. Redirecting to login page.");
                    window.location.href = "teacher_login.php";
                  </script>';
        } else {
            // Hash password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $sql = "INSERT INTO `teacher` (`tname`, `password`) VALUES ('$username', '$hashed_password')";
            
            if (mysqli_query($con, $sql)) {
                $_SESSION["teacher_name"] = $username;
                echo '<script>alert("Teacher registered successfully.");</script>';
                // Redirect to a success page or login page
                header('Location: teacher_dashboard.php');
                exit;
            } else {
                echo '<script>alert("Error occurred while registering the teacher.");</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Teacher</title>  
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
        .register-form {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.9); /* White with 90% opacity */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .register-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #fff; /* White text color */
        }
        .register-form .form-group label {
            font-weight: 500;
            color: #fff; /* White text color */
        }
        .register-form .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .register-form .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .register-form .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .register-form .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .log{
            margin-left: 130px;
        }
    </style>
</head>
<body>
    <div class="register-form">
        <form action="register_teacher.php" method="POST" onsubmit="return validateForm()">
            <h2 class="text-center">Register as Teacher</h2>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
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
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            
            <button type="button" class="btn btn-secondary btn-block" onclick="window.history.back();">Back</button>
            <div class="text-light my-4 log">already registred? &nbsp;<a href="teacher_login.php">login </a></div>
        
        </form>
    </div>
    <script>
        function validateForm() {
            // Client-side validation
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (username === '' || password === '') {
                alert('Please fill in all fields.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
