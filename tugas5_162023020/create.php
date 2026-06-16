<?php
require_once 'data.php';

$msg = "";
$msg_type = "";
$username = "";
$email = "";

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
    // Cek duplikasi username
    elseif (isUsernameTaken($username)) {
        $msg = "Username sudah terdaftar, gunakan username lain";
        $msg_type = "error";
    }
    // Cek duplikasi email
    elseif (isEmailTaken($email)) {
        $msg = "Email sudah terdaftar, gunakan email lain";
        $msg_type = "error";
    }
    // Semua lolos → simpan
    else {
        addUser($username, $email);
        $msg = "User has been successfully inserted.";
        $msg_type = "success";
        $username = "";
        $email = "";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Data - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Create Data</h2>

        <?php if ($msg !== ""): ?>
            <div class="msg-<?= $msg_type ?>">
                <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" id="createForm" novalidate>
            <label for="username">Name:</label>
            <input type="text" id="username" name="username" placeholder="Your name"
                   value="<?= htmlspecialchars($username) ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your email"
                   value="<?= htmlspecialchars($email) ?>" required>

            <button type="submit" class="btn btn-primary">Insert</button>
        </form>

        <div class="nav">
            <a href="create.php">CREATE</a>
            <a href="read.php">READ</a>
        </div>
    </div>

    <script>
        document.getElementById('createForm').addEventListener('submit', function(e) {
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
