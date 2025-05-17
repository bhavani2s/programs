<?php
session_start();

if (!isset($_SESSION['teacher_logged_in']) || $_SESSION['teacher_logged_in'] !== true) {
    header("Location: teacher_login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$teacher_name = $_SESSION['teacher_name'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['selected_students']) && !empty($_POST['selected_students']) && isset($_POST['assignment_question']) && !empty($_POST['assignment_question']) && isset($_POST['deadline'])) {
        $selected_students = $_POST['selected_students'];
        $question = $_POST['assignment_question'];
        $deadline = $_POST['deadline']; // Get deadline

        $course = $_POST['course'];
        $year = intval($_POST['year']);

        $servername = "localhost";
        $username_db = "root";
        $password_db = "";
        $dbname = "sai";

        $conn = new mysqli($servername, $username_db, $password_db, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $question = mysqli_real_escape_string($conn, $question);
        $deadline = mysqli_real_escape_string($conn, $deadline); // Sanitize deadline

        $success_count = 0;
        $error_count = 0; // Keep track of errors
        foreach ($selected_students as $student_id) {
            $student_id = mysqli_real_escape_string($conn, $student_id);
            $sql = "INSERT INTO assignments (teacher_id, teacher_name, student_id, course, year, question, deadline, sent_at) VALUES ('$teacher_id', '$teacher_name', '$student_id', '$course', '$year', '$question', '$deadline', NOW())"; // Added deadline and sent_at, removed status
            if ($conn->query($sql) === TRUE) {
                $success_count++;
            } else {
                $error_count++;
                echo "Error sending assignment to student ID: " . $student_id . "<br>" . $conn->error . "<br>";
            }
        }
        $conn->close();
        if ($error_count == 0) {
            echo "<p>Successfully sent the assignment question to " . $success_count . " students.</p>";
            echo '<p><a href="teacher_dashboard.php">Back to Dashboard</a></p>';
        } else {
            echo "<p style='color:red;'>Failed to send assignment to " . $error_count . " students.</p>";
            echo '<p><a href="teacher_dashboard.php">Back to Dashboard</a></p>';
        }
        exit;

    } else {
        echo "<p style='color: red;'>Please select at least one student and enter the assignment question and deadline.</p>";
        echo '<p><a href="teacher_dashboard.php">Back to Dashboard</a></p>';
        exit;
    }
} else {
    header("Location: teacher_dashboard.php");
    exit;
}
?>

