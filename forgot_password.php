<?php
session_start();
include('db_connect.php');

$message = "";

if (isset($_POST['reset_request'])) {

    // Get and clean email
    $email = trim($_POST['email']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {

        // Generate 6-digit code
        $code   = (string) random_int(100000, 999999);
        $expiry = date('Y-m-d H:i:s', time() + 15 * 60); // 15 minutes from now

        // Save code + expiry in DB
        $stmt2 = $conn->prepare("
            UPDATE users
            SET reset_code = ?, reset_expiry = ?
            WHERE email = ?
        ");
        $stmt2->bind_param("sss", $code, $expiry, $email);
        $stmt2->execute();

        // Store email in session instead of URL
        $_SESSION['reset_email'] = $email;

        echo "<script>
                alert('Your password reset code is: $code');
                window.location='reset_password.php';
              </script>";
        exit;

    } else {
        $message = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h2>Forgot Password</h2>

    <?php if (!empty($message)) : ?>
        <p style="color:#fecaca;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Enter your email" required><br>
        <button name="reset_request">Send Reset Code</button>
    </form>

    <a href="user_login.php">Back to Login</a>
</div>

</body>
</html>
