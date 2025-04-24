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

$sql = "SELECT a.question, a.teacher_id, t.teacher_name
        FROM assignments a
        JOIN teachers t ON a.teacher_id = t.teacher_id
        WHERE a.student_id = '$student_id'
        ORDER BY a.sent_at DESC";
$result = $conn->query($sql);

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
    <title>Received Assignments</title>
    <style>
        .assignment-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .teacher-info {
            font-size: small;
            color: #777;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h2>Received Assignment Questions</h2>

    <?php if (empty($assignments)): ?>
        <p>No assignments received yet.</p>
    <?php else: ?>
        <?php foreach ($assignments as $assignment): ?>
            <div class="assignment-item">
                <div class="teacher-info">
                    Sent by Teacher: <?php echo $assignment['teacher_name']; ?> (ID: <?php echo $assignment['teacher_id']; ?>)
                </div>
                <p><?php echo $assignment['question']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <p><a href="student_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
