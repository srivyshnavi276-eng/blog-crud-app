<?php
require "config.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $msg = "All fields required!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hash]);

            // IMPORTANT: redirect before any HTML output
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $msg = "Username already exists!";
        }
    }
}
?>
<!doctype html>
<html>
<head><title>Register</title></head>
<link rel="stylesheet" href="style.css">

<body>
<h2>Register</h2>
<p style="color:red"><?= htmlspecialchars($msg) ?></p>

<form method="POST" action="register.php">
    <input name="username" placeholder="Username" required><br><br>
    <input name="password" type="password" placeholder="Password" required><br><br>
    <button type="submit">Register</button>
</form>

<a href="login.php">Login</a>
</body>
</html>
