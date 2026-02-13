<?php
require "config.php";
require "auth.php";

$posts = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html>
<head>
    <title>Blog</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<h2>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?></h2>
<a href="create.php">+ New Post</a> |
<a href="logout.php">Logout</a>
<hr>

<?php foreach ($posts as $p): ?>
    <h3><?= htmlspecialchars($p["title"]) ?></h3>
    <p><?= nl2br(htmlspecialchars($p["content"])) ?></p>
    <small><?= $p["created_at"] ?></small><br>
    <a href="edit.php?id=<?= $p["id"] ?>">Edit</a> |
    <a href="delete.php?id=<?= $p["id"] ?>" onclick="return confirm('Delete?')">Delete</a>
    <hr>
<?php endforeach; ?>

</body>
</html>
