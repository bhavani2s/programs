<?php
session_start();

if (!isset($_SESSION['teacher_logged_in']) || $_SESSION['teacher_logged_in'] !== true) {
    header("Location: teacher_login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];

// Check if assignment_id and max_marks are provided
if (!isset($_GET['assignment_id']) || !isset($_GET['max_marks'])) {
    die("Error: assignment_id and max_marks are required.");
}

$assignment_id = $_GET['assignment_id'];
$max_marks = $_GET['max_marks'];

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "sai";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the student's submission for this assignment
$sql = "SELECT sa.student_id, s.student_name, sa.submission_content 
        FROM submitted_assignments sa
        JOIN students s ON sa.student_id = s.student_id
        WHERE sa.assignment_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: No submission found for this assignment.");
}

$submission = $result->fetch_assoc();
$student_name = $submission['student_name'];
$student_id = $submission['student_id'];
$submission_content = $submission['submission_content'];


// Check if marks have already been allocated
$marks_check_sql = "SELECT marks FROM submitted_assignments WHERE assignment_id = ?";
$marks_check_stmt = $conn->prepare($marks_check_sql);
$marks_check_stmt->bind_param("i", $assignment_id);
$marks_check_stmt->execute();
$marks_check_result = $marks_check_stmt->get_result();

if ($marks_check_result->num_rows > 0 && $marks_check_row = $marks_check_result->fetch_assoc()) {
    if ($marks_check_row['marks'] !== null) {
        $error_message = "Marks have already been allocated for this assignment.";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marks = $_POST['marks'];
    $marks = intval($marks);

    if ($marks > $max_marks || $marks < 0) {
        $error_message = "Marks must be between 0 and " . $max_marks . ".";
    } else {
        // Update the submitted_assignments table with the marks
        $update_sql = "UPDATE submitted_assignments SET marks = ? WHERE assignment_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $marks, $assignment_id);

        if ($update_stmt->execute()) {
            echo "<script>alert('Marks allocated successfully!'); window.location.href='teacher_received_assignment.php';</script>";
            exit;
        } else {
            $error_message = "Error allocating marks: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Allocate Marks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .submission-info {
            margin-bottom: 10px;
            font-size: 0.9em;
            color: #555;
        }
        .submission-content {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
            white-space: pre-line;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="number"] {
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        button[type="submit"]:hover {
            background-color: #218838;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Allocate Marks</h1>

    <?php if (isset($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <div class="submission-info">
        Student Name: <?php echo htmlspecialchars($student_name); ?> (Student ID: <?php echo htmlspecialchars($student_id); ?>)
    </div>

    <h2>Submission Content:</h2>
    <div class="submission-content">
        <?php 
            $submission_content = str_replace(array('\\r\\n', '\\r', '\\n'), '<br>', $submission_content);
            echo strip_tags(trim($submission_content));
         ?>
    </div>

    <form method="post" action="">
        <label for="marks">Marks (out of <?php echo $max_marks; ?>):</label>
        <input type="number" id="marks" name="marks" required min="0" max="<?php echo $max_marks; ?>">
        <button type="submit">Submit Marks</button>
    </form>

    <p><a href="teacher_received_assignment.php">Back to Received Assignments</a></p>
</body>
</html>
