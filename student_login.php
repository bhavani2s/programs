<?php

session_start();

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "sai";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $password = $_POST["password"];

    $student_id = mysqli_real_escape_string($conn, $student_id);

    $sql = "SELECT student_id, student_name, password, course, year FROM students WHERE student_id = '$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password === $row["password"]) {
            $_SESSION['student_logged_in'] = true;
            $_SESSION['student_id'] = $row["student_id"];
            $_SESSION['student_name'] = $row["student_name"];
            $_SESSION['course'] = $row["course"]; 
            $_SESSION['year'] = $row["year"];   
            header("Location: student_dashboard.php");
            exit;
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "Incorrect Student ID.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
</head>
<body>
    <h2>Student Login</h2>

    <?php if (isset($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="student_id">Student ID:</label>
        <input type="text" name="student_id" id="student_id" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
