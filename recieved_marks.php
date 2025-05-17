<?php
session_start();

if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: student_login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "sai";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch assignments with marks for the student
$sql = "SELECT a.question, sa.marks, a.marks as max_marks
        FROM submitted_assignments sa
        JOIN assignments a ON sa.assignment_id = a.assignment_id
        WHERE sa.student_id = '$student_id'
        AND sa.marks IS NOT NULL";  // Only fetch assignments with marks
$result = $conn->query($sql);

if (!$result) {
    die("Error: " . $conn->error);
}

$assignments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $assignments[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Received Marks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .marks-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .marks-info {
            margin-bottom: 10px;
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Received Marks</h1>

    <?php if (empty($assignments)): ?>
        <p>No marks received yet.</p>
    <?php else: ?>
        <?php foreach ($assignments as $assignment): ?>
            <div class="marks-item">
                <div class="marks-info">
                    Question: <?php echo $assignment['question']; ?>
                </div>
                <p>
                    Marks Obtained: <?php echo $assignment['marks']; ?> / <?php echo $assignment['max_marks']; ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <p><a href="student_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
