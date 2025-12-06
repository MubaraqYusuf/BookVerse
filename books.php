<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

include('db_connect.php');
$books = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
    <link rel="stylesheet" href="style.css">

<style>
/* FIXED COLUMN TABLE SYSTEM */
.table-wrapper table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
}

.table-wrapper th,
.table-wrapper td {
    padding: 12px;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.table-wrapper th {
    background: rgba(15,23,42,0.9);
    color: white;
}

/* COLUMN WIDTHS */
.col-img { width: 80px; }
.col-title { width: 220px; }
.col-author { width: 160px; }
.col-cat { width: 130px; }
.col-qty { width: 70px; text-align:center; }
.col-status { width: 110px; }
.col-actions { width: 150px; }

/* IMAGE STYLE */
.book-thumb {
    width: 55px;
    height: 75px;
    border-radius: 6px;
    object-fit: cover;
}
</style>

</head>
<body>

<div class="navbar fade-in">
    <span class="brand">📘 Book List</span>
    <div>
        <a href="dashboard_admin.php">Dashboard</a>
        <a href="logout.php" class="btn-light">Logout</a>
    </div>
</div>

<div class="page-container fade-in">

<h1>Book List</h1>

<div class="table-wrapper">
<table>
    <tr>
        <th class="col-img">Image</th>
        <th class="col-title">Title</th>
        <th class="col-author">Author</th>
        <th class="col-cat">Category</th>
        <th class="col-qty">Qty</th>
        <th class="col-status">Status</th>
        <th class="col-actions">Actions</th>
    </tr>

    <?php while($b = $books->fetch_assoc()): ?>
    <tr>
        <td><img src="uploads/<?= $b['image']; ?>" class="book-thumb"></td>
        <td><?= $b['title']; ?></td>
        <td><?= $b['author']; ?></td>
        <td><?= $b['category']; ?></td>
        <td style="text-align:center;"><?= $b['quantity']; ?></td>
        <td><?= $b['status']; ?></td>
        <td>
            <a href="update_book.php?id=<?= $b['id']; ?>">Edit</a> |
            <a href="books.php?delete=<?= $b['id']; ?>" onclick="return confirm('Delete book?');">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</div>

</div>
</body>
</html>
