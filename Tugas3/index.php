"saya mengerjakan tugas ini sendiri tanpa melakukan kecurangan seperti menggunakan, mendupliaksi kode perogram kode program yang ada. jia saya melakukan kecurangan dalam perngerjaan tugas ini maka saya siap menerima sanksi atau hukuman dari dari dosen mata kuliah dan tuhan / allah  swt"
<?php
session_start();

// Default warna
if (!isset($_SESSION['bg_color'])) {
    $_SESSION['bg_color'] = '#3b6dbf';
}
if (!isset($_SESSION['text_color'])) {
    $_SESSION['text_color'] = '#cc0000';
}

// Simpan warna jika form di-submit
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($requestMethod === 'POST') {
    if (isset($_POST['bg_color']) && preg_match('/^#[0-9A-Fa-f]{6}$/', $_POST['bg_color'])) {
        $_SESSION['bg_color'] = $_POST['bg_color'];
    }
    if (isset($_POST['text_color']) && preg_match('/^#[0-9A-Fa-f]{6}$/', $_POST['text_color'])) {
        $_SESSION['text_color'] = $_POST['text_color'];
    }
    header('Location: index.php');
    exit;
}

$bg_color    = $_SESSION['bg_color'];
$text_color  = $_SESSION['text_color'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferensi Warna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: <?= htmlspecialchars($bg_color) ?>;">

    <div class="container">
        <h1 class="judul" style="color: <?= htmlspecialchars($text_color) ?>;">Preferensi Warna</h1>

        <form method="POST" action="index.php">
            <fieldset>
                <legend style="color: <?= htmlspecialchars($text_color) ?>;">Warna</legend>

                <ol>
                    <li style="color: <?= htmlspecialchars($text_color) ?>;">
                        Warna latarbelakang
                        <span class="color-box"
                              id="box-bg"
                              style="background-color: <?= htmlspecialchars($bg_color) ?>;"
                              onclick="bukaModal('bg')"></span>
                    </li>
                    <li style="color: <?= htmlspecialchars($text_color) ?>;">
                        Warna teks
                        <span class="color-box"
                              id="box-text"
                              style="background-color: <?= htmlspecialchars($text_color) ?>;"
                              onclick="bukaModal('text')"></span>
                    </li>
                </ol>
            </fieldset>

            <!-- Hidden inputs yang akan diisi JS -->
            <input type="hidden" name="bg_color"   id="input-bg"   value="<?= htmlspecialchars($bg_color) ?>">
            <input type="hidden" name="text_color"  id="input-text" value="<?= htmlspecialchars($text_color) ?>">

            <button type="submit" class="btn-simpan">Simpan</button>
        </form>
    </div>

    <!-- Modal Pilih Warna -->
    <div id="modal-overlay" class="modal-overlay hidden" onclick="tutupModal(event)">
        <div class="modal-box" onclick="event.stopPropagation()">
            <div class="modal-header">
                <button type="button" class="btn-cancel" onclick="tutupModal()">Cancel</button>
                <span class="modal-title">Choose a color</span>
                <button type="button" class="btn-select" onclick="pilihWarna()">Select</button>
            </div>

            <div class="color-grid" id="color-grid">
                <!-- Warna diisi oleh JS -->
            </div>

            <div class="custom-section">
                <span class="custom-label">Custom</span>
                <button type="button" class="btn-plus" onclick="document.getElementById('custom-color-picker').click()">+</button>
                <div id="custom-swatches" class="custom-swatches"></div>
                <input type="color" id="custom-color-picker" style="display:none;" onchange="tambahCustom(this.value)">
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>