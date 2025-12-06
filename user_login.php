<?php
session_start();
include('db_connect.php');

$error = "";

if (isset($_POST['login'])) {
    $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND role='user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role']    = $user['role'];
            $_SESSION['name']    = $user['name'];

            header("Location: dashboard_user.php");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Account not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Login - BookVerse</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .password-wrapper {
            position:relative;
        }
        .password-wrapper input {
            padding-right:40px;
        }
        .toggle-icon {
            position:absolute;
            right:10px;
            top:12px;
            cursor:pointer;
        }
        #emailError {
            color:red;
            font-size:12px;
            margin:0;
            display:none;
            text-align:left;
        }
    </style>
</head>
<body>

<div class="form-box fade-in">
    <h2>User Login</h2>

    <?php if ($error): ?>
        <p style="color:#fecaca;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="email" id="email" name="email" placeholder="Email Address" required>
        <p id="emailError">Please enter a valid email address.</p>

        <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <span id="togglePassword" class="toggle-icon">👁️</span>
        </div>

        <button name="login">Sign In</button>
    </form>

    <p style="margin-top:10px;font-size:14px;">
        Don’t have an account? <a href="register.php">Sign up</a><br>
        <a href="forgot_password.php">Forgot password?</a>
    </p>
</div>

<script>
const toggle = document.getElementById("togglePassword");
const password = document.getElementById("password");
toggle.addEventListener("click", () => {
    if (password.type === "password") {
        password.type = "text";
        toggle.textContent = "🙈";
    } else {
        password.type = "password";
        toggle.textContent = "👁️";
    }
});

const emailField = document.getElementById("email");
const emailError = document.getElementById("emailError");
const loginForm = document.querySelector("form");

emailField.addEventListener("input", function () {
    const email = emailField.value;
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!pattern.test(email)) {
        emailField.style.border = "2px solid red";
        emailError.style.display = "block";
    } else {
        emailField.style.border = "1px solid #d1d5db";
        emailError.style.display = "none";
    }
});

loginForm.addEventListener("submit", function (e) {
    const email = emailField.value;
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!pattern.test(email)) {
        e.preventDefault();
        emailField.style.border = "2px solid red";
        emailError.style.display = "block";
    }
});
</script>

</body>
</html>
