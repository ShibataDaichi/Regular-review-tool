<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $review_date = $_POST['review_date'];
    $comment = $_POST['comment'];
    $image_path = 'uploads/' . basename($_FILES['image']['name']);

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    try {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $stmt = $pdo->prepare("INSERT INTO uploads (user_id, image_path, review_date, comment) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $image_path, $review_date, $comment]);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アップロード</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>アップロード</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label>画像: <input type="file" name="image" required></label><br>
            <label>復習日付: <input type="date" name="review_date" required></label><br>
            <label>コメント: <textarea name="comment" rows="4" placeholder="コメントを入力"></textarea></label><br>
            <button type="submit">アップロード</button>
        </form>
    </div>
</body>
</html>
