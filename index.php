<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>ホーム</h1>
        <p>アップロードまたは復習を選択してください。</p>
        <div>
            <a href="upload.php" class="button">アップロード</a>
            <a href="review.php" class="button">復習</a>
        </div>
    </div>
</body>
</html>
