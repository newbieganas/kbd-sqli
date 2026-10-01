<?php
include 'db.php';
$result_msg = "";
$rows = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    $res = pg_query($conn, $query);

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
<title>Simulasi Login - VULNERABLE</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Login (VULNERABLE)</h1>

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
        <strong>Query yang dieksekusi (debug):</strong>
        <code><?= htmlspecialchars($last_query) ?></code>
    </div>
    <?php endif; ?>

    <?php if (!empty($rows)): ?>
    <div class="debug">
        <strong>Data yang berhasil diambil:</strong>
        <table>
            <tr><th>id</th><th>username</th><th>password</th></tr>
            <?php foreach ($rows as $r): ?>
            <tr><td><?= htmlspecialchars($r['id']) ?></td><td><?= htmlspecialchars($r['username']) ?></td><td><?= htmlspecialchars($r['password']) ?></td></tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>

    <p><a href="secure.php">Ke Versi Secure</a></p>
</div>
</body>
</html>
