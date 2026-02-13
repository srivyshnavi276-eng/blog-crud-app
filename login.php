<?php
require "config.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: index.php");
        exit;
    } else {
        $msg = "Invalid username or password!";
    }
}
?>

<!doctype html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

<h2>Login</h2>

<?php if ($msg): ?>
    <div class="error"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<form method="POST">
    <label>Username</label>
    <input class="input" name="username" required>

    <label style="display:block;margin-top:12px;">Password</label>
    <input class="input" name="password" type="password" required>

    <button class="btn" type="submit" style="margin-top:12px;">Login</button>
</form>

<p style="margin-top:12px;">
    <a href="register.php">Register</a>
</p>

</div>
</body>
</html>
