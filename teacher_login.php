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
    $teacher_id = $_POST["teacher_id"];
    $password = $_POST["password"];

    $teacher_id = mysqli_real_escape_string($conn, $teacher_id);

    $sql = "SELECT teacher_id, teacher_name, password, department FROM teachers WHERE teacher_id = '$teacher_id'"; 
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password === $row["password"]) {
            $_SESSION['teacher_logged_in'] = true;
            $_SESSION['teacher_id'] = $row["teacher_id"];
            $_SESSION['teacher_name'] = $row["teacher_name"];
            $_SESSION['teacher_department'] = $row["department"]; 
            header("Location: teacher_dashboard.php");
            exit;
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "Incorrect Teacher ID.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Login</title>
</head>
<body>
    <h2>Teacher Login</h2>

    <?php if (isset($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="teacher_id">Teacher ID:</label>
        <input type="text" name="teacher_id" id="teacher_id" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
