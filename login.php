<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'ユーザー名またはパスワードが間違っています';
        }
    } catch (PDOException $e) {
        $error = 'Database error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>ログイン</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <form method="post">
            <label>ユーザー名: <input type="text" name="username" required></label><br>
            <label>パスワード: <input type="password" name="password" required></label><br>
            <button type="submit">ログイン</button>
        </form>
        <p>新規の方ですか？ <a href="register.php">ユーザー登録はこちら</a></p>
    </div>
</body>
</html>