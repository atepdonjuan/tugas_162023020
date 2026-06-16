<?php
require_once 'data.php';

$msg = "";
$msg_type = "";

// Ambil ID dari parameter
$id = intval($_GET["id"] ?? 0);

if ($id <= 0) {
    header("Location: read.php");
    exit;
}

// Ambil data user
$user = getUserById($id);

if (!$user) {
    header("Location: read.php");
    exit;
}

// Proses update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $email    = trim($_POST["email"] ?? "");

    // Validasi: tidak boleh kosong
    if ($username === "" || $email === "") {
        $msg = "Field tidak boleh kosong";
        $msg_type = "error";
    }
    // Validasi: format email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Format email tidak valid";
        $msg_type = "error";
    }
    // Cek duplikasi username (kecuali milik sendiri)
    elseif (isUsernameTaken($username, $id)) {
        $msg = "Username sudah terdaftar, gunakan username lain";
        $msg_type = "error";
    }
    // Cek duplikasi email (kecuali milik sendiri)
    elseif (isEmailTaken($email, $id)) {
        $msg = "Email sudah terdaftar, gunakan email lain";
        $msg_type = "error";
    }
    // Semua lolos → update
    else {
        updateUser($id, $username, $email);
        $msg = "Data berhasil diperbarui.";
        $msg_type = "success";
        $user['username'] = $username;
        $user['email'] = $email;
    }

    // Jika error, tampilkan input user
    if ($msg_type === "error") {
        $user['username'] = $username;
        $user['email'] = $email;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Update Data</h2>

        <?php if ($msg !== ""): ?>
            <div class="msg-<?= $msg_type ?>">
                <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="update.php?id=<?= $id ?>" id="updateForm" novalidate>
            <label for="username">Name:</label>
            <input type="text" id="username" name="username"
                   value="<?= htmlspecialchars($user['username']) ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($user['email']) ?>" required>

            <button type="submit" class="btn btn-update">Update</button>
        </form>

        <div class="nav">
            <a href="create.php">CREATE</a>
            <a href="read.php">READ</a>
        </div>
    </div>

    <script>
        document.getElementById('updateForm').addEventListener('submit', function(e) {
            var username = document.getElementById('username').value.trim();
            var email = document.getElementById('email').value.trim();

            if (username === '' || email === '') {
                alert('Field tidak boleh kosong');
                e.preventDefault();
                return;
            }

            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Format email tidak valid');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>
