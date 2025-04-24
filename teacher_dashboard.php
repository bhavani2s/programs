<?php
// Filename: teacher_dashboard.php
session_start();

if (!isset($_SESSION['teacher_logged_in']) || $_SESSION['teacher_logged_in'] !== true) {
    header("Location: teacher_login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$teacher_name = $_SESSION['teacher_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
    <style>
        /* Existing CSS for Assignment Generation (DO NOT MODIFY) */
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

        .dropdown {
            float: left;
            overflow: hidden;
        }

        .dropdown .dropbtn {
            font-size: 16px;
            border: none;
            outline: none;
            color: black;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .course-dropdown {
            position: relative;
            display: block;
        }

        .course-dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 2;
            left: 100%;
            top: 0;
        }

        .course-dropdown:hover .course-dropdown-content {
            display: block;
        }

        .year-link {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
            text-align: left;
        }

        .year-link:hover {
            background-color: #ddd;
        }

        /* Style for the View History link (MODIFIED) */
        .history-link {
            float: left;
            display: block;
            color: black;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .history-link:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="teacher_dashboard.php">Home</a>
        <div class="dropdown">
            <button class="dropbtn">Assignment Question Generation</button>
            <div class="dropdown-content">
                <div class="course-dropdown">
                    <a href="#">BCA</a>
                    <div class="course-dropdown-content">
                        <a class="year-link" href="select_students_for_assignment.php?course=bca&year=1">1st Year</a>
                        <a class="year-link" href="select_students_for_assignment.php?course=bca&year=2">2nd Year</a>
                        <a class="year-link" href="select_students_for_assignment.php?course=bca&year=3">3rd Year</a>
                    </div>
                </div>
                <div class="course-dropdown">
                    <a href="#">BCOM</a>
                    <div class="course-dropdown-content">
                        <a class="year-link" href="select_students_for_assignment.php?course=bcom&year=1">1st Year</a>
                        <a class="year-link" href="select_students_for_assignment.php?course=bcom&year=2">2nd Year</a>
                        <a class="year-link" href="select_students_for_assignment.php?course=bcom&year=3">3rd Year</a>
                    </div>
                </div>
                <div class="course-dropdown">
                    <a href="#">BA</a>
                    <div class="course-dropdown-content">
                        <a class="year-link" href="select_students_for_assignment.php?course=ba&year=1">1st Year</a>
                        <a class="year-link" href="select_students_for_assignment.php?course=ba&year=2">2nd Year</a>
                        <a class="year-link" href="select_students_for_assignment.php?course=ba&year=3">3rd Year</a>
                    </div>
                </div>
                <div class="course-dropdown">
                    <a href="#">BBA</a>
                    <div class="course-dropdown-content">
                        <a class="year-link" href="select_students_for_assignment.php?course=bba&year=1">1st Year</a>
                        <a class="year-link" href="select_students_for_assignment.php?course=bba&year=2">2nd Year</a>
                        <a class="year-link" href="select_students_for_assignment.php?course=bba&year=3">3rd Year</a>
                    </div>
                </div>
                <div class="course-dropdown">
                    <a href="#">BVOC</a>
                    <div class="course-dropdown-content">
                        <a class="year-link" href="select_students_for_assignment.php?course=bvoc&year=1">1st Year</a>
                        <a class="year-link" href="select_students_for_assignment.php?course=bvoc&year=2">2nd Year</a>
                        <a class="year-link" href="select_students_for_assignment.php?course=bvoc&year=3">3rd Year</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="received_assignments.php">Received Assignments</a>
        <a href="teacher_assignment_history.php" class="history-link">View History</a>
    </div>

    <h2>Teacher Dashboard</h2>
    <p>Welcome, <?php echo $teacher_name; ?> (Teacher ID: <?php echo $teacher_id; ?>)!</p>
    <a href="teacher_logout.php">Logout</a>
</body>
</html>
