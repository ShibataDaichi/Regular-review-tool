<?php
include 'config.php';

try {
    // Create users table if it does not exist
    $createUsersTable = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    $pdo->exec($createUsersTable);
    echo "Users table created or already exists.<br>";

    // Create uploads table if it does not exist
    $createUploadsTable = "CREATE TABLE IF NOT EXISTS uploads (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        image_path VARCHAR(255) NOT NULL,
        review_date DATE NOT NULL,
        comment TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    $pdo->exec($createUploadsTable);
    echo "Uploads table created or already exists.<br>";

    // Check if 'comment' column exists
    $result = $pdo->query("SHOW COLUMNS FROM uploads LIKE 'comment'");
    $columnExists = $result->rowCount() > 0;

    // Add 'comment' column if it does not exist
    if (!$columnExists) {
        $alterUploadsTable = "ALTER TABLE uploads ADD COLUMN comment TEXT";
        $pdo->exec($alterUploadsTable);
        echo "Column 'comment' added to uploads table.<br>";
    } else {
        echo "Column 'comment' already exists in uploads table.<br>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
