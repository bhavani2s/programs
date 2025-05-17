<?php
session_start();

if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: student_login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sai";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the POST request
$assignment_id = isset($_POST['assignment_id']) ? $_POST['assignment_id'] : 0;
$assignment_content = isset($_POST['assignment_content']) ? $_POST['assignment_content'] : '';
$teacher_id = isset($_POST['teacher_id']) ? $_POST['teacher_id'] : 0; // Get teacher ID

$submission_date = date("Y-m-d H:i:s");
$assignment_content = mysqli_real_escape_string($conn, $assignment_content);

// Insert into submitted_assignments
$sql = "INSERT INTO submitted_assignments (student_id, teacher_id, assignment_id, submission_content, submission_date)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiss", $student_id, $teacher_id, $assignment_id, $assignment_content, $submission_date);

if ($stmt->execute()) {
    echo "Assignment Submitted Successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
