<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

include('db_connect.php');

// ISSUE BOOK
if (isset($_POST['issue'])) {
    $member_id = intval($_POST['member_id']);
    $book_id   = intval($_POST['book_id']);

    // Check book availability
    $status = $conn->query("SELECT status FROM books WHERE id=$book_id")->fetch_assoc()['status'];

    if ($status !== 'Available') {
        echo "<script>alert('Book already borrowed.'); window.location='borrow.php';</script>";
        exit;
    }

    // Mark as borrowed
    $conn->query("UPDATE books SET status='Borrowed' WHERE id=$book_id");

    // Insert borrow record
    $conn->query("
        INSERT INTO borrow (member_id, book_id, borrow_date, status)
        VALUES ($member_id, $book_id, NOW(), 'Borrowed')
    ");

    echo "<script>alert('Book issued successfully.'); window.location='borrow.php';</script>";
    exit;
}

// RETURN BOOK
if (isset($_GET['return'])) {
    $id = intval($_GET['return']);

    $record = $conn->query("SELECT * FROM borrow WHERE id=$id")->fetch_assoc();
    $book_id = $record['book_id'];

    $conn->query("UPDATE borrow SET status='Returned', return_date=NOW() WHERE id=$id");
    $conn->query("UPDATE books SET status='Available' WHERE id=$book_id");

    echo "<script>alert('Book returned successfully.'); window.location='borrow.php';</script>";
    exit;
}

$members = $conn->query("SELECT * FROM members ORDER BY name ASC");
$books   = $conn->query("SELECT * FROM books ORDER BY title ASC");

$records = $conn->query("
    SELECT b.*, m.name AS member_name, bk.title AS book_title
    FROM borrow b
    LEFT JOIN members m ON b.member_id = m.id
    LEFT JOIN books   bk ON b.book_id  = bk.id
    WHERE b.member_id IS NOT NULL
    ORDER BY b.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Issue / Return (Members)</title>
    <link rel="stylesheet" href="style.css">

<style>
/* PAGE LAYOUT */
.page-container {
    padding: 30px;
}

/* FORM BOX */
.form-box {
    max-width: 600px;
    background: rgba(255,255,255,0.12);
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 40px;
}

/* BUTTON STYLE */
.issue-btn {
    width: 100%;
    padding: 12px;
    background: #2563eb;
    color: white;
    font-weight: 600;
    border-radius: 10px;
    transition: .25s;
}
.issue-btn:hover {
    background: #1e40af;
}

/* TABLE FIX (NO COLOR CHANGES) */
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

/* Column widths */
.table-wrapper th:nth-child(1) { width: 18%; }
.table-wrapper th:nth-child(2) { width: 18%; }
.table-wrapper th:nth-child(3) { width: 18%; }
.table-wrapper th:nth-child(4) { width: 18%; }
.table-wrapper th:nth-child(5) { width: 18%; }
.table-wrapper th:nth-child(6) { width: 10%; }

.table-wrapper a {
    color: #93c5fd;
    font-weight: 500;
}
.table-wrapper a:hover {
    color: white;
}
</style>

</head>
<body>

<!-- NAVBAR -->
<div class="navbar fade-in">
    <span class="brand">📚 Issue / Return (Members)</span>
    <div>
        <a href="dashboard_admin.php">Dashboard</a>
        <a href="logout.php" class="btn-light">Logout</a>
    </div>
</div>

<div class="page-container fade-in">

    <h1>Issue Book to Member</h1>

    <!-- ISSUE FORM -->
    <div class="form-box">
        <form method="post">

            <label>Member:</label>
            <select name="member_id" required>
                <option value="">Select Member</option>
                <?php while ($m = $members->fetch_assoc()): ?>
                    <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                <?php endwhile; ?>
            </select>

            <label style="margin-top:10px;">Book:</label>
            <select name="book_id" required>
                <option value="">Select Book</option>
                <?php while ($b = $books->fetch_assoc()): ?>
                    <option value="<?= $b['id']; ?>">
                        <?= $b['title'] . " (" . $b['status'] . ")"; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button name="issue" class="issue-btn" style="margin-top:14px;">Issue Book</button>

        </form>
    </div>

    <h2>Member Borrow Records</h2>

    <!-- BORROW RECORD TABLE -->
    <div class="table-wrapper">
        <table>
            <tr>
                <th>Member</th>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while ($r = $records->fetch_assoc()): ?>
            <tr>
                <td><?= $r['member_name']; ?></td>
                <td><?= $r['book_title']; ?></td>
                <td><?= $r['borrow_date']; ?></td>
                <td><?= $r['return_date'] ?: '—'; ?></td>
                <td><?= $r['status']; ?></td>

                <td>
                    <?php if ($r['status'] === 'Borrowed'): ?>
                        <a href="borrow.php?return=<?= $r['id']; ?>">Return</a>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>

        </table>
    </div>

</div>

</body>
</html>
