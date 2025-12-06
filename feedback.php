<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $text = trim($_POST['message']);

    if ($name && $text) {
        if (!is_dir(__DIR__ . "/data")) {
            mkdir(__DIR__ . "/data", 0777, true);
        }
        $file = __DIR__ . "/data/feedback.txt";
        $line = date("Y-m-d H:i:s") . " | $name: $text" . PHP_EOL;
        file_put_contents($file, $line, FILE_APPEND);

        $message = "Thank you, your feedback has been saved.";
    } else {
        $message = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Feedback - BookVerse</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page-container fade-in">
    <h1>Library Feedback</h1>

    <?php if ($message): ?>
        <p style="color:#bfdbfe;"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="card" style="max-width:500px;">
        <form method="post">
            <input type="text" name="name" placeholder="Your name" required>
            <textarea name="message" rows="4" placeholder="Your message" required></textarea>
            <button type="submit" style="margin-top:10px;">Send Feedback</button>
        </form>
    </div>

    <p style="margin-top:15px;"><a href="home.php">Back to Home</a></p>
</div>

</body>
</html>
