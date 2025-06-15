<?php
require 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);

    $stmt = $conn->prepare("SELECT id FROM kullanicilar WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        $token = bin2hex(random_bytes(16));
        $stmt->close();

        $stmt = $conn->prepare("UPDATE kullanicilar SET reset_token = ? WHERE id = ?");
        $stmt->bind_param("si", $token, $user_id);
        $stmt->execute();

        $reset_link = "http://localhost/arac_modifiye/reset_password.php?token=" . $token;
        $message = "Şifre sıfırlama linkiniz: <a href='$reset_link'>$reset_link</a>";
    } else {
        $message = "Kullanıcı bulunamadı.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Şifre Sıfırlama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Şifre Sıfırlama</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Kullanıcı Adı</label>
            <input type="text" id="username" name="username" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-success">Şifre Sıfırlama Linki Gönder</button>
        <a href="login.php" class="btn btn-link">Giriş Ekranına Dön</a>
    </form>
</div>
<div class="footer">
    🚘 Tasarım & Kodlama: <strong>İsmihan Kırmızıoğlan</strong> ✨ | 2025
</div>
</body>
</html>