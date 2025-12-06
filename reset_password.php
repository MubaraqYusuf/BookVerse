<?php
session_start();
include('db_connect.php');

// Ensure we have the email from the previous step
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit;
}

$email = $_SESSION['reset_email'];

if (isset($_POST['reset_password'])) {
    $code     = trim($_POST['code']);
    $password = $_POST['password'];

    // Check code + expiry
    $stmt = $conn->prepare("
        SELECT id FROM users
        WHERE email = ?
          AND reset_code = ?
          AND reset_expiry >= NOW()
    ");
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Update password and clear reset fields
        $stmt2 = $conn->prepare("
            UPDATE users
            SET password = ?, reset_code = NULL, reset_expiry = NULL
            WHERE email = ?
        ");
        $stmt2->bind_param("ss", $hashed, $email);
        $stmt2->execute();

        // Clear session email
        unset($_SESSION['reset_email']);

        echo "<script>
                alert('Password reset successful! Please login.');
                window.location='user_login.php';
              </script>";
        exit;

    } else {
        echo "<script>alert('Invalid or expired reset code.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box fade-in">
    <h2>Reset Password</h2>

    <form method="post">
        <input type="text" name="code" placeholder="Reset code" required>
        <input type="password" name="password" placeholder="New password" required>
        <button name="reset_password">Reset Password</button>
    </form>

    <p style="margin-top:10px;">
        <a href="user_login.php">Back to Login</a>
    </p>
</div>

</body>
</html>
