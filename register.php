<?php
require "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if ($username === "" || $password === "") {
        $error = "Please fill Username and Password.";
    } else {
        try {
            // Check if user already exists
            $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $check->execute([$username]);

            if ($check->fetch()) {
                $error = "Username already exists. Try another one.";
            } else {
                // Hash password
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // Insert user
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->execute([$username, $hash]);

                // Redirect to login
                header("Location: login.php");
                exit;
            }
        } catch (PDOException $e) {
            $error = "Register failed: " . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>

<body class="bg">
  <div class="page-center">
    <div class="card" style="max-width:520px;">
      <div class="card-header">
        <h1>Create Account</h1>
        <a class="btn btn-light" href="login.php">Login</a>
      </div>

      <?php if ($error): ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" class="form">
        <div class="field">
          <label for="username">Username</label>
          <input id="username" type="text" name="username" placeholder="Enter username" required>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" placeholder="Enter password" required>
        </div>

        <div class="actions" style="justify-content: space-between;">
          <button type="submit" class="btn btn-primary">Register</button>
          <a class="btn btn-outline" href="login.php">Already have an account?</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
