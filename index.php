<?php

require 'config.php';

// If not logged in, go to login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch only this user's posts
$stmt = $pdo->prepare("SELECT id, title, content, created_at FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blog CRUD</title>

  <style>
    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background:#f4f6fb;
      color:#111827;
    }

    .container{
      max-width: 900px;
      margin: 40px auto;
      padding: 0 16px;
    }

    .card{
      background:#fff;
      border:1px solid #e5e7eb;
      border-radius: 14px;
      box-shadow: 0 8px 24px rgba(0,0,0,.06);
      overflow:hidden;
    }

    .header{
      padding: 18px 22px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      background: linear-gradient(135deg, #4f46e5, #06b6d4);
      color:white;
    }

    .header h1{
      margin:0;
      font-size: 20px;
      font-weight: 700;
      letter-spacing: .2px;
    }

    .header .user{
      font-weight:600;
      opacity:.95;
      font-size: 14px;
    }

    .top-actions{
      padding: 14px 22px;
      display:flex;
      gap: 10px;
      justify-content: space-between;
      align-items:center;
      border-bottom: 1px solid #e5e7eb;
      background:#fafafa;
      flex-wrap:wrap;
    }

    .btn{
      display:inline-block;
      padding:10px 14px;
      border-radius: 10px;
      text-decoration:none;
      font-weight: 600;
      border:1px solid transparent;
      transition:.15s;
      cursor:pointer;
      font-size: 14px;
    }

    .btn-primary{
      background:#111827;
      color:white;
    }
    .btn-primary:hover{opacity:.92}

    .btn-outline{
      background:white;
      border-color:#d1d5db;
      color:#111827;
    }
    .btn-outline:hover{background:#f3f4f6}

    .posts{
      padding: 18px 22px 22px;
    }

    .post{
      background:#ffffff;
      border:1px solid #e5e7eb;
      border-radius: 14px;
      padding: 16px;
      margin-bottom: 14px;
    }

    .post h2{
      margin:0 0 8px;
      font-size: 18px;
    }

    .post p{
      margin:0 0 10px;
      color:#374151;
      line-height: 1.5;
      white-space: pre-wrap;
    }

    .meta{
      display:flex;
      justify-content: space-between;
      align-items:center;
      gap: 10px;
      flex-wrap:wrap;
      font-size: 13px;
      color:#6b7280;
    }

    .actions a{
      margin-right: 10px;
      font-weight: 700;
      text-decoration:none;
      font-size: 13px;
    }

    .actions a.edit{color:#2563eb}
    .actions a.delete{color:#dc2626}
    .actions a:hover{text-decoration:underline}

    .empty{
      padding: 24px;
      border: 1px dashed #cbd5e1;
      border-radius: 14px;
      background:#f8fafc;
      color:#475569;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card">

      <div class="header">
        <h1>Blog CRUD Dashboard</h1>
        <div class="user">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></div>
      </div>

      <div class="top-actions">
        <a class="btn btn-primary" href="create.php">+ New Post</a>
        <a class="btn btn-outline" href="logout.php">Logout</a>
      </div>

      <div class="posts">
        <?php if ($stmt->rowCount() == 0): ?>
          <div class="empty">
            <b>No posts yet.</b><br>
            Click <b>+ New Post</b> to create your first blog post.
          </div>
        <?php else: ?>
          <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
            <div class="post">
              <h2><?php echo htmlspecialchars($row['title']); ?></h2>
              <p><?php echo htmlspecialchars($row['content']); ?></p>

              <div class="meta">
                <div>Created: <?php echo htmlspecialchars($row['created_at']); ?></div>

                <div class="actions">
                  <a class="edit" href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                  <a class="delete"
                     href="delete.php?id=<?php echo $row['id']; ?>"
                     onclick="return confirm('Delete this post?');">
                     Delete
                  </a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>

    </div>
  </div>
</body>
</html>
