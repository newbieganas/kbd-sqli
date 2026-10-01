<?php
include 'db.php';
$result_msg = "";
$rows = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = $1 AND password = $2";
    $res = pg_query_params($conn, $query, [$username, $password]);

    if ($res) {
        $rows = pg_fetch_all($res) ?: [];
        if (count($rows) > 0) {
            $result_msg = "LOGIN BERHASIL sebagai: " . htmlspecialchars($rows[0]['username']);
        } else {
            $result_msg = "Login gagal: username/password salah.";
        }
    } else {
        $result_msg = "Query error: " . pg_last_error($conn);
    }
    $last_query = $query;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Simulasi Login - SECURE</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container secure">
    <h1>Login (AMAN - Prepared Statement)</h1>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">
        <label>Password</label>
        <input type="text" name="password" value="<?= isset($password) ? htmlspecialchars($password) : '' ?>">
        <button type="submit">Login</button>
    </form>

    <?php if ($result_msg): ?>
    <div class="result <?= str_contains($result_msg, 'BERHASIL') ? 'success' : 'fail' ?>">
        <?= $result_msg ?>
    </div>
    <?php endif; ?>

    <?php if (isset($last_query)): ?>
    <div class="debug">
        <strong>Query (parameterized, debug):</strong>
        <code><?= htmlspecialchars($last_query) ?></code>
    </div>
    <?php endif; ?>

    <p><a href="vulnerable.php">Versi Rentan</a></p>
</div>
</body>
</html>
