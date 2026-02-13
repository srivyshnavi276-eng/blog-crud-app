<?php
require "config.php";
require "auth.php";

$id = (int)($_GET["id"] ?? 0);

// Only allow editing own post
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=? AND user_id=?");
$stmt->execute([$id, $_SESSION["user_id"]]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) die("Post not found or access denied.");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = trim($_POST["title"] ?? "");
  $content = trim($_POST["content"] ?? "");

  $upd = $pdo->prepare("UPDATE posts SET title=?, content=? WHERE id=? AND user_id=?");
  $upd->execute([$title, $content, $id, $_SESSION["user_id"]]);

  header("Location: index.php");
  exit;
}
?>
<!doctype html>
<html>
<head>
  <title>Edit Post</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

  <div class="topbar">
    <h2>Edit Post</h2>
    <a href="index.php" class="btn secondary">Back</a>
  </div>

  <form method="POST">
    <label><b>Title</b></label>
    <input class="input" name="title" value="<?= htmlspecialchars($post["title"]) ?>" required>

    <label style="display:block;margin-top:14px;"><b>Content</b></label>
    <textarea name="content" required><?= htmlspecialchars($post["content"]) ?></textarea>

    <button class="btn" type="submit" style="margin-top:14px;">Update Post</button>
  </form>

</div>
</body>
</html>
