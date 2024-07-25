<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Database error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>ユーザー登録</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <form method="post">
            <label>ユーザー名: <input type="text" name="username" required></label><br>
            <label>パスワード: <input type="password" name="password" required></label><br>
            <button type="submit">登録</button>
        </form>
        <p>既に登録済みですか？ <a href="login.php">ログインはこちら</a></p>
    </div>
</body>
</html>