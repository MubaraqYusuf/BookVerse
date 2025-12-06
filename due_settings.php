<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

include('db_connect.php');

$admin_id = $_SESSION['user_id'];

if (isset($_POST['save'])) {
    $days = intval($_POST['due_days']);
    $conn->query("UPDATE users SET setting_due_days=$days WHERE id=$admin_id");

    echo "<script>alert('Due date setting updated.'); window.location='dashboard_admin.php';</script>";
    exit;
}

$current = $conn->query("SELECT setting_due_days FROM users WHERE id=$admin_id")->fetch_assoc()['setting_due_days'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Due Date Settings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page-container fade-in">
    <h1>Set Borrow Due Date</h1>

    <div class="card" style="max-width:400px;">
        <form method="post">
            <label>Choose Due Date Duration:</label>
            <select name="due_days">
                <option value="7"  <?= $current==7 ? "selected" : "" ?>>7 Days</option>
                <option value="14" <?= $current==14 ? "selected" : "" ?>>14 Days</option>
            </select>

            <button name="save" style="margin-top:10px;">Save Setting</button>
        </form>
    </div>

    <p style="margin-top:10px;"><a href="dashboard_admin.php">Back</a></p>
</div>

</body>
</html>
