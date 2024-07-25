<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM uploads WHERE id = ? AND user_id = ?");
            $stmt->execute([$delete_id, $_SESSION['user_id']]);
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    } elseif (isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $edit_comment = $_POST['edit_comment'];
        try {
            $stmt = $pdo->prepare("UPDATE uploads SET comment = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$edit_comment, $edit_id, $_SESSION['user_id']]);
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM uploads WHERE user_id = ? AND review_date = CURDATE()");
    $stmt->execute([$_SESSION['user_id']]);
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
    <title>復習</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>今日の復習</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <div class="uploads-container">
            <?php $counter = 1; ?>
            <?php foreach ($uploads as $upload): ?>
                <div class="upload-item">
                    <p>今日の復習 (<?= $counter ?>)</p>
                    <img src="<?= htmlspecialchars($upload['image_path'], ENT_QUOTES, 'UTF-8') ?>" alt="Uploaded Image">
                    <p class="comment"><?= htmlspecialchars($upload['comment'], ENT_QUOTES, 'UTF-8') ?></p>
                    <form method="post" class="delete-form">
                        <input type="hidden" name="delete_id" value="<?= $upload['id'] ?>">
                        <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                    </form>
                    <form method="post" class="edit-form">
                        <input type="hidden" name="edit_id" value="<?= $upload['id'] ?>">
                        <textarea name="edit_comment" rows="2"><?= htmlspecialchars($upload['comment'], ENT_QUOTES, 'UTF-8') ?></textarea>
                        <button type="submit">コメントを編集</button>
                    </form>
                </div>
                <?php $counter++; ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

