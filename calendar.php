<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

try {
    $stmt = $pdo->prepare("SELECT * FROM uploads WHERE user_id = ? AND review_date = ?");
    $stmt->execute([$_SESSION['user_id'], $date]);
    $uploads = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Database error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレンダー</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>カレンダー</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <div id="calendar"></div>

        <h2><?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?> の復習</h2>
        <?php foreach ($uploads as $upload): ?>
            <div class="upload-item">
                <img src="<?= htmlspecialchars($upload['image_path'], ENT_QUOTES, 'UTF-8') ?>" alt="Uploaded Image">
                <p class="comment"><?= htmlspecialchars($upload['comment'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

