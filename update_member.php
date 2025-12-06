<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

include('db_connect.php');

if (!isset($_GET['id'])) {
    header("Location: members.php");
    exit;
}

$id = intval($_GET['id']);
$member = $conn->query("SELECT * FROM members WHERE id=$id")->fetch_assoc();

if (!$member) {
    echo "<script>alert('Member not found'); window.location='members.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $contact = $_POST['contact'];

    $conn->query("
        UPDATE members
        SET name='$name', email='$email', contact='$contact'
        WHERE id=$id
    ");

    echo "<script>alert('Member updated'); window.location='members.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar fade-in">
    <span class="brand">✏️ Edit Member</span>
    <div>
        <a href="members.php">Back</a>
        <a href="logout.php" class="btn-light" style="padding:6px 14px;border-radius:8px;">Logout</a>
    </div>
</div>

<div class="page-container fade-in">
    <div class="form-box">
        <h2>Edit Member</h2>

        <form method="post">
            <input type="text"   name="name"    value="<?php echo $member['name']; ?>" required>
            <input type="email"  name="email"   value="<?php echo $member['email']; ?>" required>
            <input type="text"   name="contact" value="<?php echo $member['contact']; ?>" required>

            <button name="update" style="margin-top:10px;">Save Changes</button>
        </form>
    </div>
</div>

</body>
</html>
