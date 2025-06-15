<?php
require 'config.php';

$message = "";
$token = $_GET['token'] ?? '';

if (!$token) {
    die("Geçersiz veya eksik token.");
}

// Token ile kullanıcıyı bul
$stmt = $conn->prepare("SELECT id FROM kullanicilar WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows !== 1) {
    die("Geçersiz token.");
}

$stmt->bind_result($user_id);
$stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = trim($_POST["new_password"]);

    if ($new_password === "") {
        $message = "Yeni şifre boş olamaz.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt_update = $conn->prepare("UPDATE kullanicilar SET password = ?, reset_token = NULL WHERE id = ?");
        $stmt_update->bind_param("si", $hashed, $user_id);

        if ($stmt_update->execute()) {
            $message = "Şifreniz başarıyla güncellendi. <a href='login.php'>Giriş yap</a>";
        } else {
            $message = "Şifre güncellenirken hata oluştu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Şifreyi Yenile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Şifreyi Yenile</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <?php if (!$message || strpos($message, 'başarıyla') === false): ?>
    <form method="POST">
        <div class="mb-3">
            <label for="new_password" class="form-label">Yeni Şifre</label>
            <input type="password" id="new_password" name="new_password" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-warning">Şifreyi Güncelle</button>
        <a href="login.php" class="btn btn-link">Giriş Ekranına Dön</a>
    </form>
    <?php endif; ?>
</div>
<div class="footer">
    🚘 Tasarım & Kodlama: <strong>İsmihan Kırmızıoğlan</strong> ✨ | 2025
</div>
</body>
</html>