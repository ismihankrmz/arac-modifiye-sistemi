<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$message = "";

// Modifiye ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modname = trim($_POST["modname"]);
    $details = trim($_POST["details"]);

    if ($modname != "" && $details != "") {
        $stmt = $conn->prepare("INSERT INTO modifiyeler (user_id, modname, details) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $modname, $details);
        $stmt->execute();
        $message = "Modifiye başarıyla eklendi.";
    } else {
        $message = "Lütfen tüm alanları doldurun.";
    }
}

// Kullanıcının modifiyelerini çek
$stmt = $conn->prepare("SELECT id, modname, details FROM modifiyeler WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ana Sayfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">🚗 Araç Modifiye Takip</span>
        <div class="text-white">Hoşgeldin, <?= htmlspecialchars($username) ?> |
            <a href="logout.php" class="btn btn-outline-light btn-sm">Çıkış</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <h3>Yeni Modifiye Ekle</h3>
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="modname" class="form-label">Modifiye Adı</label>
            <input type="text" name="modname" id="modname" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="details" class="form-label">Detaylar</label>
            <textarea name="details" id="details" rows="3" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ekle</button>
    </form>

    <h3>Modifiyelerim</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Adı</th>
                <th>Detay</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["modname"]) ?></td>
                    <td><?= nl2br(htmlspecialchars($row["details"])) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                        <a href="delete.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<div class="footer">
    🚘 Tasarım & Kodlama: <strong>İsmihan Kırmızıoğlan</strong> ✨ | 2025
</div>
</body>
</html>