<?php
require "config.php";
require "auth.php"; // must set $_SESSION["user_id"] after login

$error = "";

// Handle POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title   = trim($_POST["title"] ?? "");
    $content = trim($_POST["content"] ?? "");

    if ($title === "" || $content === "") {
        $error = "Please fill Title and Content.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
            $stmt->execute([$title, $content, $_SESSION["user_id"]]);

            // ✅ Redirect to dashboard
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "Insert failed: " . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create Post</title>
  <link rel="stylesheet" href="style.css">
</head>

<body class="bg">
  <div class="page-center">
    <div class="card">
      <div class="card-header">
        <h1>Create Post</h1>
        <a class="btn btn-light" href="index.php">Back</a>
      </div>

      <?php if ($error): ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" class="form">
        <div class="field">
          <label for="title">Title</label>
          <input id="title" type="text" name="title" placeholder="Enter post title" required>
        </div>

        <div class="field">
          <label for="content">Content</label>
          <textarea id="content" name="content" rows="7" placeholder="Write your content..." required></textarea>
        </div>

        <div class="actions">
          <button type="submit" class="btn btn-primary">Save</button>
          <a class="btn btn-outline" href="index.php">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
