<?php
include('db_connect.php');

$message = "";

if (isset($_POST['register'])) {
    $name     = htmlspecialchars(trim($_POST['name']));
    $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    try {
        $conn->query("
            INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$hashed', 'user')
        ");
        echo "<script>alert('Registration successful. You can login now.');window.location='user_login.php';</script>";
        exit;
    } catch (Exception $e) {
        $message = "Email already exists or an error occurred.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - BookVerse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box fade-in">
    <h2>Create User Account</h2>

    <?php if ($message): ?>
        <p style="color:#fecaca;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="register">Register</button>
    </form>

    <p style="margin-top:10px;font-size:14px;">
        Already have an account? <a href="user_login.php">Login</a>
    </p>
</div>

</body>
</html>
