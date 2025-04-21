<?php
// student_dashboard.php
session_start();

if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: student_login.php");
    exit;
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
$student_course = $_SESSION['course']; // Retrieve course from session
$student_year = $_SESSION['year'];   // Retrieve year from session
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
    <h2>Student Dashboard</h2>
    <p>Welcome, <?php echo $student_name; ?> (Student ID: <?php echo $student_id; ?>)!</p>
    <?php if (isset($student_course) && isset($student_year)): ?>
        <p>Course: <?php echo strtoupper($student_course); ?></p>
        <p>Year: <?php echo $student_year; ?> Year</p>
    <?php endif; ?>
    <a href="student_logout.php">Logout</a>
</body>
</html>
