<?php
session_start();
include "connect.php"; // Include database connection

// Check if student is logged in
if (!isset($_SESSION['student_name'])) {
    header('Location: student_login.php');
    exit;
}

// Fetch student details from session
$student_name = $_SESSION['student_name'];
// Assuming you have the subjectid from the URL parameter
if (isset($_GET['subjectid'])) {
    $subjectid = $_GET['subjectid'];
} else {
    // Redirect or handle error if subjectid is not provided
    header('Location: student_dashboard.php');
    exit;
}

// Fetch subject details (for display purpose)
$subject_query = "SELECT subject_name FROM subject WHERE subjectid = ?";
$stmt = $con->prepare($subject_query);
$stmt->bind_param("s", $subjectid);
$stmt->execute();
$stmt->bind_result($subject_name);
$stmt->fetch();
$stmt->close();

// Fetch lessons related to the subject
$lessons_query = "SELECT lesson_title, lesson_content FROM lessons WHERE subjectid = ?";
$stmt = $con->prepare($lessons_query);
$stmt->bind_param("s", $subjectid);
$stmt->execute();
$stmt->bind_result($lesson_title, $lesson_content);

$lessons = [];
while ($stmt->fetch()) {
    $lessons[] = [
        'title' => $lesson_title,
        'content' => $lesson_content
    ];
}
$stmt->close();

// Fetch assignments related to the subject
$assignments_query = "SELECT assignment_title, assignment_description FROM assignments WHERE subjectid = ?";
$stmt = $con->prepare($assignments_query);
$stmt->bind_param("s", $subjectid);
$stmt->execute();
$stmt->bind_result($assignment_title, $assignment_description);

$assignments = [];
while ($stmt->fetch()) {
    $assignments[] = [
        'title' => $assignment_title,
        'description' => $assignment_description
    ];
}
$stmt->close();

// Fetch tasks related to the subject
$tasks_query = "SELECT task_title, task_description FROM tasks WHERE subjectid = ?";
$stmt = $con->prepare($tasks_query);
$stmt->bind_param("s", $subjectid);
$stmt->execute();
$stmt->bind_result($task_title, $task_description);

$tasks = [];
while ($stmt->fetch()) {
    $tasks[] = [
        'title' => $task_title,
        'description' => $task_description
    ];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesson Page - <?php echo htmlspecialchars($subject_name); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .lesson-container {
            width: 80%;
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .lesson-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .lesson-section {
            margin-bottom: 20px;
        }
        .lesson-section h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .lesson-section p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="lesson-container">
        <h1>Lessons and Assignments - <?php echo htmlspecialchars($subject_name); ?></h1>

        <!-- Lessons Section -->
        <div class="lesson-section">
            <h2>Lessons</h2>
            <?php if (!empty($lessons)): ?>
                <ul>
                    <?php foreach ($lessons as $lesson): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($lesson['title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($lesson['content'])); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No lessons available for this subject.</p>
            <?php endif; ?>
        </div>

        <!-- Assignments Section -->
        <div class="lesson-section">
            <h2>Assignments</h2>
            <?php if (!empty($assignments)): ?>
                <ul>
                    <?php foreach ($assignments as $assignment): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($assignment['title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($assignment['description'])); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No assignments available for this subject.</p>
            <?php endif; ?>
        </div>

        <!-- Tasks Section -->
        <div class="lesson-section">
            <h2>Tasks</h2>
            <?php if (!empty($tasks)): ?>
                <ul>
                    <?php foreach ($tasks as $task): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No tasks available for this subject.</p>
            <?php endif; ?>
        </div>

        <!-- Link back to dashboard -->
        <a href="student_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>

    <!-- Bootstrap JS and dependencies (for responsive navigation) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
