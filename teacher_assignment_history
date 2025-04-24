<?php
session_start();

if (!isset($_SESSION['teacher_logged_in']) || $_SESSION['teacher_logged_in'] !== true) {
    header("Location: teacher_login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "sai";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define all courses
$all_courses = ['bca', 'bba', 'bcom', 'ba', 'bvoc'];

$selected_course = isset($_GET['course']) ? $_GET['course'] : '';
$selected_year = isset($_GET['year']) ? intval($_GET['year']) : 0;

// Fetch assignment history if a course and year are selected
$assignment_history = [];
if (!empty($selected_course) && $selected_year > 0) {
    $history_sql = "SELECT a.student_id, s.student_name, a.question, a.sent_at 
                    FROM assignments a
                    JOIN students s ON a.student_id = s.student_id  -- Join to get student name
                    WHERE a.course = '$selected_course' AND a.year = $selected_year
                    ORDER BY a.sent_at DESC";
    $history_result = $conn->query($history_sql);
    if ($history_result->num_rows > 0) {
        while ($row = $history_result->fetch_assoc()) {
            $assignment_history[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assignment History</title>
    <style>
        .container {
            display: flex;
        }
        .course-list {
            width: 200px;
            padding: 20px;
            border-right: 1px solid #ddd;
            position: relative; /* For back button positioning */
        }
        .history-details {
            flex: 1;
            padding: 20px;
        }
        .year-dropdown {
            margin-bottom: 20px;
        }
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .history-table, .history-table th, .history-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .history-table th {
            background-color: #f0f0f0;
        }
        .back-button {
            position: fixed;
            bottom: 50%;
            left: 20px;
            padding: 10px 15px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: black;
        }
        .back-button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="course-list">
            <h2>Courses</h2>
            <ul>
                <?php foreach ($all_courses as $course): ?>
                    <li>
                        <a href="teacher_assignment_history.php?course=<?php echo $course; ?>"
                           style="text-decoration: none; color: <?php echo ($selected_course == $course) ? 'blue' : 'black'; ?>">
                            <?php echo strtoupper($course); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="teacher_dashboard.php" class="back-button">Back to Dashboard</a>
        </div>
        <div class="history-details">
            <h2>Assignment History</h2>

            <?php if (!empty($selected_course)): ?>
                <div class="year-dropdown">
                    <label for="year-select">Select Year:</label>
                    <select id="year-select" onchange="window.location.href=this.value;">
                        <option value="">Select Year</option>
                        <option value="teacher_assignment_history.php?course=<?php echo $selected_course; ?>&year=1" <?php if ($selected_year == 1) echo "selected"; ?>>1st Year</option>
                        <option value="teacher_assignment_history.php?course=<?php echo $selected_course; ?>&year=2" <?php if ($selected_year == 2) echo "selected"; ?>>2nd Year</option>
                        <option value="teacher_assignment_history.php?course=<?php echo $selected_course; ?>&year=3" <?php if ($selected_year == 3) echo "selected"; ?>>3rd Year</option>
                    </select>
                </div>

                <?php if ($selected_year > 0): ?>
                    <p>Assignment history for <?php echo strtoupper($selected_course); ?> - <?php echo $selected_year; ?> Year</p>
                    <?php if (empty($assignment_history)): ?>
                        <p>No assignments sent for this course and year.</p>
                    <?php else: ?>
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Question</th>
                                    <th>Sent At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assignment_history as $record): ?>
                                    <tr>
                                        <td><?php echo $record['student_id']; ?></td>
                                        <td><?php echo $record['student_name']; ?></td>
                                        <td><?php echo $record['question']; ?></td>
                                        <td><?php echo $record['sent_at']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Select a year to view assignment history.</p>
                <?php endif; ?>

            <?php else: ?>
                <p>Select a course to view assignment history.</p>
            <?php endif; ?>

        </div>
    </div>
</body>
</html>
