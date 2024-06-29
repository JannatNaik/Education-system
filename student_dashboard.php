<!-- <?php
// session_start();
// include "connect.php"; // Include database connection

// if (!isset($_SESSION['student_name']) && !isset($_SESSION['student_course'])) {
//     header('Location: student_login.php');
//     exit;
// }


// $student_name = $_SESSION['student_name'];
// $student_course_id = $_SESSION['student_course'];

// // Fetch the course name for display
// $course_query = "SELECT coursename FROM course WHERE courseid = ?";
// $stmt = $con->prepare($course_query);
// $stmt->bind_param("s", $student_course_id);
// $stmt->execute();
// $stmt->bind_result($course_name);
// $stmt->fetch();
// $stmt->close();

// // Fetch subjects related to the selected course
// $subjects_query = "SELECT subject_name FROM subject WHERE courseid = ?";
// $stmt = $con->prepare($subjects_query);
// $stmt->bind_param("s", $student_course_id);
// $stmt->execute();
// $stmt->bind_result($subject_name);

// $subjects = [];
// while ($stmt->fetch()) {
//     $subjects[] = $subject_name;
// }
// $stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .dashboard-container {
            width: 80%;
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .dashboard-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .course-info {
            margin-bottom: 20px;
        }
        .course-info p {
            margin: 0;
            font-weight: bold;
        }
        .subjects-list {
            list-style-type: none;
            padding: 0;
        }
        .subjects-list li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, <?php //echo htmlspecialchars($student_name); ?>!</h1>
        <div class="course-info">
            <p>Selected Course: <?php //echo htmlspecialchars($course_name); ?></p>
        </div>
        <h2>Subjects for <?php //echo htmlspecialchars($course_name); ?></h2>
        <ul class="subjects-list">
            <?php //foreach ($subjects as $subject): ?>
                <li><?php //echo htmlspecialchars($subject); ?></li>
            <?php //endforeach; ?>
        </ul>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html> -->
<?php
session_start();
include "connect.php"; // Include database connection

if (!isset($_SESSION['student_name']) && !isset($_SESSION['student_course'])) {
    header('Location: student_login.php');
    exit;
}

$student_name = $_SESSION['student_name'];
$student_course_id = $_SESSION['student_course'];

// Fetch the course name for display
$course_query = "SELECT coursename FROM course WHERE courseid = ?";
$stmt = $con->prepare($course_query);
$stmt->bind_param("s", $student_course_id);
$stmt->execute();
$stmt->bind_result($course_name);
$stmt->fetch();
$stmt->close();

// Fetch subjects related to the selected course
$subjects_query = "SELECT subject_name, subjectid FROM subject WHERE courseid = ?";
$stmt = $con->prepare($subjects_query);
$stmt->bind_param("s", $student_course_id);
$stmt->execute();
$stmt->bind_result($subject_name, $subjectid);

$subjects = [];
while ($stmt->fetch()) {
    $subjects[] = [
        'name' => $subject_name,
        'id' => $subjectid
    ];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #007bff;
            /* Bootstrap primary color */
        }

        .navbar-brand {
            color: #fff;
            /* White text color */
            font-weight: bold;
        }

        .dashboard-container {
            width: 80%;
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .dashboard-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .course-info {
            margin-bottom: 20px;
        }

        .course-info p {
            margin: 0;
            font-weight: bold;
        }

        .subjects-list {
            list-style-type: none;
            padding: 0;
        }

        .subjects-list li {
            margin-bottom: 5px;
        }

        .logout-link {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #007bff;
            /* Bootstrap primary color */
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand text-light" href="#">SMART EDUCATION PLATFORM</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="btn border-light nav-link logout-link text-light" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($student_name); ?>!</h1>
        <div class="course-info">
            <p>Selected Course: <?php echo htmlspecialchars($course_name); ?></p>
        </div>
        <h2>Subjects for <?php echo htmlspecialchars($course_name); ?></h2>
        <ul class="subjects-list">
            <?php foreach ($subjects as $subject): ?>
                <li>
                    <a href="lesson_page.php?subjectid=<?php echo urlencode($subject['id']); ?>" class="btn btn-primary"><?php echo htmlspecialchars($subject['name']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Bootstrap JS and dependencies (for responsive navigation) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>