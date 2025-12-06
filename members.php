<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

include('db_connect.php');

// ADD MEMBER
if (isset($_POST['add_member'])) {
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("INSERT INTO members (name, email, contact) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $contact);
    $stmt->execute();

    echo "<script>alert('Member added successfully.'); window.location='members.php';</script>";
    exit;
}

// DELETE MEMBER
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM members WHERE id=$id");
    echo "<script>alert('Member deleted.'); window.location='members.php';</script>";
    exit;
}

$members = $conn->query("SELECT * FROM members ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Members</title>
    <link rel="stylesheet" href="style.css">

<style>
/* PAGE SPACING */
.page-container {
    padding: 30px;
}

/* FORM BOX MATCHES SYSTEM THEME */
.member-form {
    max-width: 600px;
    background: rgba(255,255,255,0.12);
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 40px;
}

/* SUBMIT BUTTON */
.member-btn {
    width: 100%;
    padding: 12px;
    background: #2563eb;
    color: white;
    font-weight: 600;
    border-radius: 10px;
    transition: .25s;
}
.member-btn:hover {
    background: #1e40af;
}

/* TABLE AREA — **NO COLOR CHANGES**, JUST FIXED WIDTH + ALIGNMENT */
.table-wrapper {
    width: 100%;
    margin-top: 20px;
}

.table-wrapper table {
    width: 100%;
    border-collapse: collapse;
}

.table-wrapper th,
.table-wrapper td {
    padding: 12px 16px;
    text-align: left;
}

.table-wrapper th {
    font-weight: 600;
}

/* Keep your existing row background colors from style.css */
.table-wrapper tr:nth-child(even) {
    background: inherit;
}

.table-wrapper a {
    color: #93c5fd;
    font-weight: 500;
}
.table-wrapper a:hover {
    color: white;
    text-decoration: underline;
}
</style>

</head>
<body>

<!-- NAVBAR -->
<div class="navbar fade-in">
    <span class="brand">👥 Manage Members</span>
    <div>
        <a href="dashboard_admin.php">Dashboard</a>
        <a href="logout.php" class="btn-light">Logout</a>
    </div>
</div>

<div class="page-container fade-in">

    <h1>Add Member</h1>

    <!-- ADD MEMBER FORM -->
    <div class="member-form">
        <form method="post">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="contact" placeholder="Contact Number" required>
            <button name="add_member" class="member-btn">Add Member</button>
        </form>
    </div>

    <h2>Member List</h2>

    <!-- MEMBER TABLE -->
    <div class="table-wrapper">
        <table>
            <tr>
                <th style="width:30%;">Name</th>
                <th style="width:35%;">Email</th>
                <th style="width:20%;">Contact</th>
                <th style="width:15%;">Actions</th>
            </tr>

            <?php while ($m = $members->fetch_assoc()): ?>
            <tr>
                <td><?= $m['name']; ?></td>
                <td><?= $m['email']; ?></td>
                <td><?= $m['contact']; ?></td>
                <td>
                    <a href="update_member.php?id=<?= $m['id']; ?>">Edit</a> |
                    <a href="members.php?delete=<?= $m['id']; ?>" onclick="return confirm('Delete this member?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>

</body>
</html>
