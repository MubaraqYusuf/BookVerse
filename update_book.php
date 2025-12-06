<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

include('db_connect.php');

if (!isset($_GET['id'])) {
    header("Location: books.php");
    exit;
}

$id   = intval($_GET['id']);
$book = $conn->query("SELECT * FROM books WHERE id=$id")->fetch_assoc();

if (!$book) {
    echo "<script>alert('Book not found'); window.location='books.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $title    = $_POST['title'];
    $author   = $_POST['author'];
    $category = $_POST['category'];
    $quantity = intval($_POST['quantity']);
    $status   = $_POST['status'];

    $image = $book['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    }

    $conn->query("
        UPDATE books
        SET title='$title', author='$author', category='$category',
            quantity=$quantity, status='$status', image='$image'
        WHERE id=$id
    ");

    echo "<script>alert('Book updated'); window.location='books.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar fade-in">
    <span class="brand">✏️ Edit Book</span>
    <div>
        <a href="books.php">Back to Books</a>
        <a href="logout.php" class="btn-light" style="padding:6px 14px;border-radius:8px;">Logout</a>
    </div>
</div>

<div class="page-container fade-in">

    <div class="form-box">
        <h2>Edit Book</h2>

        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" value="<?php echo $book['title']; ?>" required>
            <input type="text" name="author" value="<?php echo $book['author']; ?>" required>
            <input type="text" name="category" value="<?php echo $book['category']; ?>" required>
            <input type="number" name="quantity" value="<?php echo $book['quantity']; ?>" required>

            <label>Status:</label>
            <select name="status">
                <option <?php if($book['status']=="Available") echo "selected"; ?>>Available</option>
                <option <?php if($book['status']=="Borrowed") echo "selected"; ?>>Borrowed</option>
            </select>

            <label style="margin-top:10px;">Replace Image (optional):</label>
            <input type="file" name="image">

            <button name="update" style="margin-top:10px;">Save Changes</button>
        </form>
    </div>

</div>

</body>
</html>
