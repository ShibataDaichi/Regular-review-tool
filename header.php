<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<header>
    <nav>
        <ul>
            <li><a href="index.php">ホーム</a></li>
            <li><a href="upload.php">アップロード</a></li>
            <li><a href="review.php">復習</a></li>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </nav>
</header>
