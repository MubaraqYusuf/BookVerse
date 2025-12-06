<?php
session_start();
include('db_connect.php');

// Only admin allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

// Generate Reset Code for user
if (isset($_GET['generate'])) {
    $uid = (int)$_GET['generate'];

    $code   = random_int(100000, 999999);
    $expiry = date("Y-m-d H:i:s", time() + 900); // 15 minutes

    $stmt = $conn->prepare("UPDATE users SET reset_code=?, reset_expiry=? WHERE id=? AND role='user'");
    $stmt->bind_param("ssi", $code, $expiry, $uid);
    $stmt->execute();

    echo "<script>alert('Reset code for user ID $uid: $code');</script>";
}

// Direct Reset for user only
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)$_POST['user_id'];
    $new = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password=?, reset_code=NULL, reset_expiry=NULL WHERE id=? AND role='user'");
    $stmt->bind_param("si", $new, $id);
    $stmt->execute();

    echo "<script>alert('Password updated successfully');</script>";
}

// Fetch ONLY normal users
$users = $conn->query("SELECT id, name, email FROM users WHERE role='user' ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Panel</title>
    <link rel="stylesheet" href="style.css">

<style>
/* Keep your color theme — only fix layout */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
    margin-top: 25px;
}

.reset-table {
    width: 100%;
    border-collapse: collapse;
}

.reset-table th,
.reset-table td {
    padding: 14px;
    text-align: left;
}

/* Input fixes */
.reset-input {
    width: 200px;
    padding: 10px;
    border-radius: 8px;
    border: none;
    background: rgba(255,255,255,0.12);
    color: white;
}

/* Reset button */
.reset-btn {
    background: #2563eb;
    border: none;
    padding: 10px 16px;
    color: white;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar fade-in">
    <span class="brand">🔐 Password Reset Panel</span>
    <div>
        <a href="dashboard_admin.php">Dashboard</a>
        <a href="logout.php" class="btn-light">Logout</a>
    </div>
</div>

<div class="page-container fade-in">

<h1>Reset Password for Users</h1>
<p style="opacity:.8;">This panel allows administrators to reset passwords for <b>normal users only</b>.  
Admin accounts are excluded for security reasons.</p>

<div class="table-wrapper">
<table class="reset-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Generate Reset Code</th>
            <th>Direct Reset</th>
        </tr>
    </thead>

    <tbody>
        <?php while ($u = $users->fetch_assoc()): ?>
        <tr>
            <td><?= $u['id']; ?></td>
            <td><?= $u['name']; ?></td>
            <td><?= $u['email']; ?></td>

            <td>
                <a href="?generate=<?= $u['id']; ?>"
                   style="color:#4da3ff;text-decoration:none;font-weight:500;">
                   Generate Code
                </a>
            </td>

            <td>
                <form method="post" style="display:flex;gap:10px;">
                    <input type="hidden" name="user_id" value="<?= $u['id']; ?>">

                    <input type="password" name="new_password"
                           class="reset-input"
                           placeholder="New password" required>

                    <button type="submit" class="reset-btn">Reset</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>

</div>
</body>
</html>
