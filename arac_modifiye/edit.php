<?php
session_start();
require 'config.php';

// Giriş kontrolü
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$mod_id = intval($_GET["id"]);
$message = "";

// Güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modname = trim($_POST["modname"]);
    $details = trim($_POST["details"]);

    if ($modname !== "" && $details !== "") {
        $stmt = $conn->prepare("UPDATE modifiyeler SET modname = ?, details = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $modname, $details, $mod_id, $user_id);
        $stmt->execute();
        $message = "Güncelleme başarılı!";
    } else {
        $message = "Alanlar boş bırakılamaz.";
    }
}

// Güncellenmeden önce mevcut bilgileri çek
$stmt = $conn->prepare("SELECT modname, details FROM modifiyeler WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $mod_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: index.php");
    exit;
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Modifiye Düzenle</h2>
    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Modifiye Adı</label>
            <input type="text" name="modname" class="form-control" value="<?= htmlspecialchars($row["modname"]) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Detaylar</label>
            <textarea name="details" class="form-control" rows="4" required><?= htmlspecialchars($row["details"]) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="index.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>
<div class="footer">
    🚘 Tasarım & Kodlama: <strong>İsmihan Kırmızıoğlan</strong> ✨ | 2025
</div>
</body>
</html>