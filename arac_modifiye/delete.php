<?php
session_start();
require 'config.php';

// Giriş kontrolü
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// GET ile gelen id kontrolü
if (isset($_GET["id"])) {
    $mod_id = intval($_GET["id"]);

    // Sadece kendi modifiyeni silebilirsin
    $stmt = $conn->prepare("DELETE FROM modifiyeler WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $mod_id, $user_id);
    $stmt->execute();
}

// Silindikten sonra ana sayfaya dön
header("Location: index.php");
exit;
?>