<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

include('db_connect.php');

// Fetch data
$books   = $conn->query("SELECT * FROM books ORDER BY title ASC");
$members = $conn->query("SELECT * FROM members ORDER BY name ASC");

$borrow = $conn->query("
    SELECT b.*, 
           u.name AS user_name,
           m.name AS member_name,
           bk.title AS book_title,
           bk.category
    FROM borrow b
    LEFT JOIN users   u ON b.user_id   = u.id
    LEFT JOIN members m ON b.member_id = m.id
    LEFT JOIN books   bk ON b.book_id  = bk.id
    ORDER BY b.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Library Reports</title>
    <link rel="stylesheet" href="style.css">

<style>
/* CONTAINER */
.page-container {
    padding: 30px;
}

/* PRINT BUTTON */
.print-btn {
    padding: 10px 18px;
    background: #2563eb;
    color: white;
    border-radius: 8px;
    font-weight: 600;
}
.print-btn:hover { background: #1e40af; }

/* TABLE WRAPPER FIX */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
    margin-top: 20px;
}

.table-wrapper table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
}

.table-wrapper th,
.table-wrapper td {
    padding: 12px 16px;
    text-align: left;
}

/* Column width balancing */
.table-wrapper th:nth-child(1) { width: 20%; }
.table-wrapper th:nth-child(2) { width: 20%; }
.table-wrapper th:nth-child(3) { width: 20%; }
.table-wrapper th:nth-child(4) { width: 20%; }
.table-wrapper th:nth-child(5) { width: 20%; }

/* Ensure print-friendly */
@media print {
    .navbar, .print-btn { display: none; }
    body { background: white; color: black; }
}
</style>

</head>
<body>

<!-- NAVBAR -->
<div class="navbar fade-in">
    <span class="brand">📊 Library Reports</span>
    <div>
        <a href="dashboard_admin.php">Dashboard</a>
        <a href="logout.php" class="btn-light">Logout</a>
    </div>
</div>

<div class="page-container fade-in">

<h1>BookVerse Library Report</h1>

<a href="#" class="print-btn" onclick="window.print()">🖨 Print Report</a>

<!-- BOOKS TABLE -->
<h2 style="margin-top:35px;">Books</h2>
<div class="table-wrapper">
<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Status</th>
    </tr>

    <?php while($b = $books->fetch_assoc()): ?>
    <tr>
        <td><?= $b['title']; ?></td>
        <td><?= $b['author']; ?></td>
        <td><?= $b['category']; ?></td>
        <td><?= $b['quantity']; ?></td>
        <td><?= $b['status']; ?></td>
    </tr>
    <?php endwhile; ?>

</table>
</div>

<!-- MEMBERS TABLE -->
<h2 style="margin-top:35px;">Members</h2>
<div class="table-wrapper">
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Contact</th>
    </tr>

    <?php while($m = $members->fetch_assoc()): ?>
    <tr>
        <td><?= $m['name']; ?></td>
        <td><?= $m['email']; ?></td>
        <td><?= $m['contact']; ?></td>
    </tr>
    <?php endwhile; ?>

</table>
</div>

<!-- BORROW RECORDS -->
<h2 style="margin-top:35px;">Borrow Records</h2>
<div class="table-wrapper">
<table>
    <tr>
        <th>User</th>
        <th>Member</th>
        <th>Book</th>
        <th>Category</th>
        <th>Borrow Date</th>
        <th>Due Date</th>
        <th>Return Date</th>
        <th>Status</th>
    </tr>

    <?php while($r = $borrow->fetch_assoc()): ?>
    <tr>
        <td><?= $r['user_name'] ?: '—'; ?></td>
        <td><?= $r['member_name'] ?: '—'; ?></td>
        <td><?= $r['book_title']; ?></td>
        <td><?= $r['category']; ?></td>
        <td><?= $r['borrow_date']; ?></td>
        <td><?= $r['due_date'] ?: '—'; ?></td>
        <td><?= $r['return_date'] ?: '—'; ?></td>
        <td><?= $r['status']; ?></td>
    </tr>
    <?php endwhile; ?>

</table>
</div>

</div>
</body>
</html>
