<?php
require_once 'data.php';

$users = getUsers();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Data - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container container-wide">
        <h2>Read Data</h2>

        <?php if (!empty($users)): ?>
            <?php foreach ($users as $row): ?>
                <div class="user-card">
                    <div class="user-info">
                        <h4><?= htmlspecialchars($row['username']) ?></h4>
                        <p><?= htmlspecialchars($row['email']) ?></p>
                    </div>
                    <div class="user-actions">
                        <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                        <a href="#" class="btn btn-delete"
                           onclick="confirmDelete(<?= $row['id'] ?>)">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; color:#888; margin-bottom:16px;">Belum ada data.</p>
        <?php endif; ?>

        <div class="nav">
            <a href="create.php">CREATE</a>
            <a href="read.php">READ</a>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</body>
</html>
