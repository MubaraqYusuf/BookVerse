<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

include('db_connect.php');

$filter_user   = $_GET['user']     ?? '';
$filter_cat    = $_GET['category'] ?? '';
$filter_status = $_GET['status']   ?? '';
$filter_from   = $_GET['from']     ?? '';
$filter_to     = $_GET['to']       ?? '';

$conditions = [];

if ($filter_user !== '') {
    $u = $conn->real_escape_string($filter_user);
    $conditions[] = "u.name LIKE '%$u%'";
}

if ($filter_cat !== '') {
    $c = $conn->real_escape_string($filter_cat);
    $conditions[] = "bk.category = '$c'";
}

if ($filter_status !== '') {
    $s = $conn->real_escape_string($filter_status);
    $conditions[] = "b.status = '$s'";
}

if ($filter_from !== '') {
    $conditions[] = "b.borrow_date >= '$filter_from'";
}

if ($filter_to !== '') {
    $conditions[] = "b.borrow_date <= '$filter_to'";
}

$where = count($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

$sql = "
    SELECT b.*, 
           u.name AS user_name, 
           bk.title AS book_title,
           bk.category
    FROM borrow b
    LEFT JOIN users u ON b.user_id = u.id
    LEFT JOIN books bk ON b.book_id = bk.id
    $where
    ORDER BY b.id DESC
";

$records = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Borrow History</title>
    <link rel="stylesheet" href="style.css">

<style>
    .page-container {
        max-width: 1200px;
        margin: auto;
        padding: 30px;
    }

    .filter-box {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(8px);
        padding: 25px;
        border-radius: 14px;
        margin-bottom: 30px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-bottom: 10px;
    }

    .filter-btn {
        width: 100%;
        padding: 12px;
        background: #2563eb;
        color: white;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }
    .filter-btn:hover {
        background: #1e40af;
    }

    .table-wrapper {
        margin-top: 20px;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(10px);
        color: white;
        border-radius: 14px;
        overflow: hidden;
    }

    th, td {
        padding: 14px;
        border-bottom: 1px solid rgba(255,255,255,0.10);
        text-align: left;
        white-space: nowrap;
    }

    th {
        background: rgba(15,23,42,0.9);
        font-weight: 600;
    }

</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar fade-in">
    <span class="brand">📘 Borrow History</span>

    <div>
        <a href="dashboard_admin.php">Dashboard</a>
        <a href="logout.php" class="btn-light">Logout</a>
    </div>
</div>

<!-- PAGE CONTENT -->
<div class="page-container fade-in">

    <h1>Borrow History Filters</h1>

    <form method="get" class="filter-box">

        <div class="filter-grid">
            <input type="text" name="user" placeholder="User name" value="<?= $filter_user; ?>">

            <select name="category">
                <option value="">All Categories</option>
                <?php
                $cats = $conn->query("SELECT DISTINCT category FROM books");
                while ($c = $cats->fetch_assoc()):
                    $sel = ($filter_cat == $c['category']) ? "selected" : "";
                ?>
                    <option <?= $sel ?>><?= $c['category']; ?></option>
                <?php endwhile; ?>
            </select>

            <select name="status">
                <option value="">All Status</option>
                <option value="Borrowed" <?= ($filter_status=="Borrowed"?"selected":""); ?>>Borrowed</option>
                <option value="Returned" <?= ($filter_status=="Returned"?"selected":""); ?>>Returned</option>
            </select>

            <input type="date" name="from" value="<?= $filter_from; ?>">
            <input type="date" name="to" value="<?= $filter_to; ?>">
        </div>

        <button class="filter-btn">Filter</button>
    </form>

    <h2>Borrow Records</h2>

    <div class="table-wrapper">
        <table>
            <tr>
                <th>User</th>
                <th>Book</th>
                <th>Category</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>

            <?php while ($r = $records->fetch_assoc()): ?>
            <tr>
                <td><?= $r['user_name']; ?></td>
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
