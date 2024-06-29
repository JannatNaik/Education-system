<?php
session_start();
include "connect.php"; // Include database connection

// Check if teacher is logged in
if (!isset($_SESSION['teacher_name'])) {
    header('Location: teacher_login.php'); // Redirect to teacher login if not logged in
    exit;
}

$teacher_name = $_SESSION['teacher_name'];

// Logout handling
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy session data
    header('Location: teacher_login.php'); // Redirect to teacher login page
    exit;
}

// Fetch student list with their assignments
$students_query = "SELECT sid, sname FROM student";
$stmt_students = $con->prepare($students_query);
$stmt_students->execute();
$stmt_students->bind_result($student_id, $student_name);

$students = [];
while ($stmt_students->fetch()) {
    $students[$student_id] = [
        'name' => $student_name,
        'assignments' => []
    ];
}
$stmt_students->close();

// Fetch assignments uploaded by students
$assignments_query = "SELECT sid, assignment_id, assignment_title, assignment_description FROM assignments";
$stmt_assignments = $con->prepare($assignments_query);
$stmt_assignments->execute();
$stmt_assignments->bind_result($student_id, $assignment_id, $assignment_title, $assignment_description);

$assignments = [];
while ($stmt_assignments->fetch()) {
    $assignments[$student_id][] = [
        'id' => $assignment_id,
        'title' => $assignment_title,
        'description' => $assignment_description
    ];
}
$stmt_assignments->close();

// Handle sending lessons
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_lesson'])) {
    $lesson_title = $_POST['lesson_title'];
    $lesson_content = $_POST['lesson_content'];

    // Example: Insert lesson into database or send to students
    // Insertion or sending logic here

    // Example success message (adjust as per actual implementation)
    $lesson_sent = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
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
        .student-list-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .student-list-table th, .student-list-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .student-list-table th {
            background-color: #f2f2f2;
        }
        .assignments-btn {
            background-color: #007bff;
            /* Bootstrap primary color */
            color: #fff;
            /* White text color */
            border: none;
            padding: 6px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 4px;
        }
        .assignments-btn:hover {
            background-color: #0056b3;
            /* Darker shade of primary color */
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
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <button type="submit" class="btn btn-light" name="logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($teacher_name); ?>!</h1>

        <h2>Students and Their Assignments</h2>
        <table class="student-list-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Assignments</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student_id => $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td>
                            <?php if (isset($assignments[$student_id])): ?>
                                <?php foreach ($assignments[$student_id] as $assignment): ?>
                                    <button class="assignments-btn" onclick="location.href='assignment_details.php?id=<?php echo $assignment['id']; ?>'">
                                        <?php echo htmlspecialchars($assignment['title']); ?>
                                    </button>
                                <?php endforeach; ?>
                            <?php else: ?>
                                No assignments
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="send-lesson-form">
            <h2>Send Lesson</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="lesson_title">Lesson Title</label>
                    <input type="text" class="form-control" id="lesson_title" name="lesson_title" required>
                </div>
                <div class="form-group">
                    <label for="lesson_content">Lesson Content</label>
                    <textarea class="form-control" id="lesson_content" name="lesson_content" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="send_lesson">Send Lesson</button>
                <?php if (isset($lesson_sent) && $lesson_sent): ?>
                    <p class="text-success mt-2">Lesson sent successfully!</p>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (for responsive navigation) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
