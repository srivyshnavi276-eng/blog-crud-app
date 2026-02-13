<?php
require "config.php";
require "auth.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $content = trim($_POST["content"] ?? "");

    $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->execute([$title, $content]);

    header("Location: index.php");
    exit;
}
?>

<!doctype html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<h2>Create Post</h2>

<form method="POST">
    <input name="title" placeholder="Title" required><br><br>
    <textarea name="content" rows="6" placeholder="Content" required></textarea><br><br>
    <button type="submit">Save</button>
</form>

<a href="index.php">Back</a>

</body>
</html>
