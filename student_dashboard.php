<?php
session_start();

if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: student_login.php");
    exit;
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
$course = $_SESSION['course'];
$year = $_SESSION['year'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        .navbar {
            background-color: #f0f0f0;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: black;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="student_dashboard.php">Home</a>
        <a href="write_assignment.php">Write Assignment</a>
        <a href="received_assignments.php">Received Assignment Questions</a>
        <a href="received_marks.php">Received Marks</a>
    </div>

    <h2>Student Dashboard</h2>
    <p>Welcome, <?php echo $student_name; ?> (Student ID: <?php echo $student_id; ?>)!</p>
    <p>Course: <?php echo $course; ?></p>
    <p>Year: <?php echo $year; ?></p>
    <a href="student_logout.php">Logout</a>
</body>
</html>

