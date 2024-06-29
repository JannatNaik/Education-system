<?php
session_start();
include_once 'conn.php';
include('p/_modal.php');
include('p/boot.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background: url('p/back.png') no-repeat;
            background-size: cover;
            margin: 0;
            color: #fff; /* Set default text color to white */
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }
        .card {
            background-color: rgba(0, 0, 0, 0.7);
            width: 300px;
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .card-link {
            text-decoration: none;
            color: #fff;
            background-color: #ff9800;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        .card-link:hover {
            background-color: #e68900;
        }
        #sidebar {
            position: absolute;
            width: 300px;
            height: 100%;
            background: #000;
            left: -300px;
            transition: .4s;
            z-index: 3; /* Ensure sidebar is above overlay */
        }
        #sidebar.active {
            left: 0px;
        }
        #sidebar ul li {
            list-style: none;
            color: #fff;
            font-size: 20px;
            padding: 20px 24px;
        }
        #sidebar .toggle-btn {
            position: absolute;
            top: 30px;
            left: 330px;
            z-index: 4; /* Ensure toggle button is above overlay */
        }
        .toggle-btn span {
            width: 45px;
            height: 4px;
            background: #fff;
            display: block;
            margin-top: 6px;
        }
        .menu {
            width: 100%;
            background: rgba(0, 0, 0, 0.3); /* Adjusted background color and opacity */
            overflow: auto;
            padding: 10px 20px;
            position: relative;
            z-index: 2; /* Ensure top navigation stays above sidebar */
        }
        .menu ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
            line-height: 40px; /* Adjusted line height */
            float: right;
        }
        .menu li {
            float: left;
            margin-right: 20px;
        }
        .menu ul li a {
            background: #142b47;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            color: #f2f2f2;
            font-size: 16px;
            font-family: sans-serif;
        }
        .menu li a:hover {
            color: #fff;
            opacity: 0.8; /* Adjusted opacity on hover */
        }
        input[type=text] {
            padding: 7px;
            border: none;
            font-size: 16px;
            font-family: sans-serif;
        }
        button {
            background: orange;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            padding: 7px 15px;
            font-family: sans-serif;
            border: none;
            font-size: 16px;
        }
        #log-out {
            margin-right: 20px;
        }
        /* Overlay styles */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
            z-index: 1; /* Ensure overlay is above everything except sidebar */
            display: none; /* Initially hidden */
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul>
            <li><a href="leader.php"><button type="button">Leader Dashboard</button></a></li>
            <li><a href="task.php"><button type="button">Task</button></a></li>
            <li><a href="group.php"><button type="button">Group</button></a></li>
            <li><a href="course.php"><button type="button">Course</button></a></li>
        </ul>
    </div>
    <nav class="menu">
        <a href="logout.php" style="padding-left: 60%;"><button type="button">Log-out</button></a>
    </nav>
    <div class="overlay" onclick="toggleSidebar()"></div>
    <div class="card-container">
        <?php
        $query = "SELECT * FROM subject"; // Assuming you have a table for subjects
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='card'>";
                echo "<div class='card-title'>{$row['subject_name']}</div>";
                echo "<a href='lecture.php?id={$row['subjectid']}' class='card-link'>Go to Subject</a>";
                echo "</div>";
            }
        } else {
            echo "<div class='card'>";
            echo "<div class='card-title'>No subjects found</div>";
            echo "</div>";
        }
        ?>
    </div>
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
            var overlay = document.querySelector('.overlay');
            overlay.style.display = (sidebar.classList.contains('active')) ? 'block' : 'none';
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
