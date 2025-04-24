<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $admin_id; ?>!</h2>
    
    <h4>Admin Dashboard</h4>

    <button>
        <a href="logout.php">Logout</a>
    </button>
</body>
</html>
