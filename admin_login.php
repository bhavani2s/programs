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
    $admin_id = $_POST["admin_id"];
    $password = $_POST["password"];
    
    if(!isset($_POST['captcha_answer'])){
        $error_message = "Please enter the text shown in the CAPTCHA.";
    }
    else{
        $captcha_answer = $_POST["captcha_answer"]; 
        $stored_answer = $_SESSION["captcha_answer"];

        $admin_id = mysqli_real_escape_string($conn, $admin_id);
        $sql = "SELECT * FROM admins WHERE admin_id = '$admin_id'";
        $result = $conn->query($sql);

        if (strtolower($captcha_answer) == strtolower($stored_answer)) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                if ($password === $row["password"]) {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $admin_id;
                    header("Location: admin_dashboard.php");
                    exit;
                } else {
                    $error_message = "Incorrect password.";
                }
            } else {
                $error_message = "Incorrect Admin ID.";
            }
        } else {
            $error_message = "Incorrect CAPTCHA answer. Please try again.";
        }
    }
    
}



function generate_captcha() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $captcha_string = '';
    for ($i = 0; $i < 6; $i++) { 
        $captcha_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    $answer = strtolower($captcha_string);
    
    return array("question" => $captcha_string, "answer" => $answer);
}

if (!isset($_SESSION['captcha_answer'])) {
    $captcha_data = generate_captcha();
    $_SESSION["captcha_answer"] = $captcha_data["answer"];
    $captcha_question = $captcha_data["question"];
} else {
     $captcha_question = $_SESSION["captcha_answer"];
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        .captcha-container {
            margin-bottom: 20px;
        }
        .captcha-text {
            padding: 10px;
            border: 2px solid #ccc;
            text-align: center;
            margin: 5px;
            display: inline-block;
            width: 150px;
            user-select: none;
            font-family: monospace; 
            font-size: 1.2em; 
            background-color: #f0f0f0; 
            border-radius: 5px;
        }
        .captcha-input {
            padding: 8px;
            margin-top: 10px;
            width: 150px;
        }
        .refresh-captcha {
            cursor: pointer;
            margin-left: 10px;
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Admin Login</h2>

    <?php if (isset($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="admin_id">Admin ID:</label>
        <input type="text" name="admin_id" id="admin_id" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <p>Enter the text shown below:</p>
        <div class="captcha-container">
            <div class="captcha-text"><?php echo $captcha_question; ?></div>
            <button type="button" class="refresh-captcha" onclick="refreshCaptcha()">Refresh</button>
            <input type="text" name="captcha_answer" id="captcha_answer" class = "captcha-input" required>
        </div>

        <input type="submit" value="Login">
    </form>
    
    <script>
        function refreshCaptcha() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "admin_captch_generate.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.querySelector('.captcha-text').textContent = response.question; // Corrected line
                    document.getElementById('captcha_answer').value = '';
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
