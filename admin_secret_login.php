<?php
session_start();
include('db_connect.php');

$error = "";

if (isset($_POST['login'])) {
    $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND role='admin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role']    = "admin";
            $_SESSION['name']    = $user['name'];
            header("Location: dashboard_admin.php");
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Admin account not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Secure Login</title>
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
        #adminEmailError {
            color:red; font-size:12px; margin:0; display:none; text-align:left;
        }
    </style>
</head>
<body>

<div class="form-box fade-in">
    <h2>Admin Secure Portal</h2>

    <?php if ($error): ?>
        <p style="color:#fecaca;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="email" id="adminEmail" name="email" placeholder="Admin Email" required>
        <p id="adminEmailError">Please enter a valid email address.</p>

        <div class="password-wrapper">
            <input type="password" id="admin_pass" name="password" placeholder="Password" required>
            <span id="toggleAdminPass" class="toggle-icon">👁️</span>
        </div>

        <button name="login">Login</button>
    </form>
</div>

<script>
const adminEmail     = document.getElementById("adminEmail");
const adminEmailErr  = document.getElementById("adminEmailError");
const adminForm      = document.querySelector("form");
const adminPass      = document.getElementById("admin_pass");
const toggleAdmin    = document.getElementById("toggleAdminPass");

toggleAdmin.addEventListener("click", () => {
    if (adminPass.type === "password") {
        adminPass.type = "text";
        toggleAdmin.textContent = "🙈";
    } else {
        adminPass.type = "password";
        toggleAdmin.textContent = "👁️";
    }
});

adminEmail.addEventListener("input", () => {
    const email = adminEmail.value;
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!pattern.test(email)) {
        adminEmail.style.border = "2px solid red";
        adminEmailErr.style.display = "block";
    } else {
        adminEmail.style.border = "1px solid #d1d5db";
        adminEmailErr.style.display = "none";
    }
});

adminForm.addEventListener("submit", (e) => {
    const email = adminEmail.value;
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!pattern.test(email)) {
        e.preventDefault();
        adminEmail.style.border = "2px solid red";
        adminEmailErr.style.display = "block";
    }
});
</script>

</body>
</html>
