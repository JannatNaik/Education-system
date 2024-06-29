<?php
session_start();
include "connect.php"; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $course = $_POST['course'];
    $role = 'student'; // Set the role to student for this page

    // Server-side validation
    $errors = [];

    if (empty($username)) {
        $errors[] = 'Username is required.';
    }

    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    if (empty($course)) {
        $errors[] = 'Course is required.';
    }

    if (empty($errors)) {
        // Check if user already exists
        $check_query = "SELECT * FROM student WHERE sname = '$username'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // User already exists
            echo '<script>
                    alert("User already exists. Redirecting to login page.");
                    window.location.href = "student_login.php";
                  </script>';
        } else {
            // Hash password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $sql = "INSERT INTO `student` (`sname`, `password`, `courseid`) VALUES ('$username', '$hashed_password', '$course')";
            
            if (mysqli_query($con, $sql)) {
                $_SESSION['student_name'] = $username;
                $_SESSION['student_course'] = $course;
                echo '<script>alert("Student registered successfully.");</script>';
                // Redirect to a success page
                header('Location: student_dashboard.php');
                exit;
            } else {
                echo '<script>alert("Error occurred while registering the student.");</script>';
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
    <title>Register as Student</title>
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
        .register-form .btn-login {
            background-color: #28a745;
            border-color: #28a745;
        }
        .register-form .btn-login:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .log{
            margin-left: 130px;
        }
    </style>
</head>
<body>
    <div class="register-form">
        <form action="register_student.php" method="POST" onsubmit="return validateForm()">
            <h2 class="text-center">Register as Student</h2>
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
            <div class="form-group">
                <label for="course">Course</label>
                <select name="course" id="course" class="form-control" required>
                    <option value="">Select a Course</option>
                    <?php
                    $select_query = "SELECT * FROM course";
                    $result = mysqli_query($con, $select_query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $course_id = $row['courseid'];
                        $course_name = $row['coursename'];
                        echo "<option value='$course_id'>$course_name</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <!-- <button type="button" class="btn btn-secondary btn-block" onclick="window.history.back();">Back</button> -->
            <!-- <button type="" class="text primary" onclick="window.location.href='student_login.php';">Login</button> -->
           
            <div class="text-light my-4 log">already registred? &nbsp;<a href="student_login.php">login </a></div>
        
        </form>
    </div>
    <script>
        function validateForm() {
            // Client-side validation
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const course = document.getElementById('course').value;

            if (username === '' || password === '' || course === '') {
                alert('Please fill in all fields.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>

<?php
// include "connect.php"; // Include the database connection

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $username = $_POST['username'];
//     $password = $_POST['password'];
//     $course = $_POST['course'];
//     $role = 'student'; // Set the role to student for this page

//     // Server-side validation
//     $errors = [];

//     if (empty($username)) {
//         $errors[] = 'Username is required.';
//     }

//     if (empty($password)) {
//         $errors[] = 'Password is required.';
//     }

//     if (empty($course)) {
//         $errors[] = 'Course is required.';
//     }

//     if (empty($errors)) {
//         // Check if user already exists
//         $check_query = "SELECT * FROM student WHERE sname = '$username'";
//         $check_result = mysqli_query($con, $check_query);

//         if (mysqli_num_rows($check_result) > 0) {
//             // User already exists
//             echo '<script>alert("User already exists. Please use a different username.");</script>';
//         } else {
//             // Hash password for security
//             $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//             // Insert user into database
//             $sql = "INSERT INTO `student` (`sname`, `password`, `courseid`) VALUES ('$username', '$hashed_password', '$course')";
            
//             if (mysqli_query($con, $sql)) {
//                 echo '<script>alert("Student registered successfully.");</script>';
//                 // Redirect to a success page
//                 header('Location: index.php');
//                 exit;
//             } else {
//                 echo '<script>alert("Error occurred while registering the student.");</script>';
//             }
//         }
//     }
// }
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Student</title>
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
    </style>
</head>
<body>
    <div class="register-form">
        <form action="register_student.php" method="POST" onsubmit="return validateForm()">
            <h2 class="text-center">Register as Student</h2>
            <?php //if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php //foreach ($errors as $error): ?>
                        <p><?php //echo htmlspecialchars($error); ?></p>
                    <?php //endforeach; ?>
                </div>
            <?php //endif; ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <select name="course" id="course" class="form-control" required>
                    <option value="">Select a Course</option>
                    <?php
                    // $select_query = "SELECT * FROM course";
                    // $result = mysqli_query($con, $select_query);
                    // while ($row = mysqli_fetch_assoc($result)) {
                    //     $course_id = $row['courseid'];
                    //     $course_name = $row['coursename'];
                    //     echo "<option value='$course_id'>$course_name</option>";
                    // }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <button type="button" class="btn btn-secondary btn-block" onclick="window.history.back();">Back</button>
        </form>
    </div>
    <script>
        function validateForm() {
            // Client-side validation
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const course = document.getElementById('course').value;

            if (username === '' || password === '' || course === '') {
                alert('Please fill in all fields.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html> -->
