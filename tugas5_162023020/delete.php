<?php
require_once 'data.php';

$id = intval($_GET["id"] ?? 0);

if ($id > 0) {
    deleteUser($id);
}

header("Location: read.php");
exit;
?>
