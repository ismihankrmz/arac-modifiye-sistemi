# GELİŞTİRME SÜRECİ CHATGPT DANIŞMALARI
### Kullanıcı Girişi ve Şifreleme

**Soru:**

PHP'de güvenli bir kullanıcı girişi nasıl yapılır? Şifreleri nasıl hash’leyebilirim?

**Yanıt:**

password_hash() fonksiyonu ile Şifreler hash’lenip veritabanına güvenli şekilde kaydedilir. Giriş sırasında password_verify() fonksiyonu ile karşılaştırma yapılır.
```php
$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); if (password_verify($_POST['password'], $storedHash)) { $_SESSION['user_id'] = $row['id']; }
```

---
### Veritabanı Tasarımı

**Soru:**

Modifiye işlemlerini kullanıcılarla ilişkilendirmek için nasıl bir tablo yapısı kurmalıyım?

**Yanıt:**

İki tablo kullanılmalıdır: kullanicilar ve modifiyeler. Aralarında foreign key ile ilişki kurulmalı:
```
CREATE TABLE modifiyeler ( id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, modname VARCHAR(100), details TEXT, FOREIGN KEY (user_id) REFERENCES kullanicilar(id) );
```

---
### Dosya Yapısı ve Organizasyon

**Soru:**

Proje dosyalarını nasıl organize etmeliyim?

**Yanıt:**

Tüm dosyalar htdocs/arac_modifiye/ klasöründe toplanmalı. Dosya yapısı şu şekildedir:

index.php

login.php

register.php

logout.php

edit.php

delete.php

reset_password.php

config.php

style.css (isteğe bağlı)

---
### Sayfa Güvenliği (Session Kontrolü)

**Soru:**

Giriş yapılmadan sayfalara erişimi nasıl engellerim?

**Yanıt:**

Sayfa başına şu kod eklenmelidir:
```php
session_start(); if (!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; }
```

---
### Arayüz ve Tasarım

**Soru:**

Bootstrap kullanarak sade ve kullanıcı dostu bir arayüz nasıl oluşturulur?

**Yanıt:**

Bootstrap 5 kullanarak responsive form yapıları, tablolama, navbar gibi öğeler kullanıldı. Ek olarak koyu tema ve ikonlar (emoji) ile sistem daha canlı hale getirildi.

---
### CRUD İşlemleri

**Soru:**

PHP ile güvenli CRUD işlemleri nasıl yapılır?

**Yanıt:**

Veritabanı işlemleri için mysqli ve prepared statements kullanıldı:
```php
$stmt = $conn->prepare("INSERT INTO modifiyeler (user_id, modname, details) VALUES (?, ?, ?)"); $stmt->bind_param("iss", $user_id, $modname, $details); $stmt->execute();
```

---
### Form Doğrulama ve Uyarı Mesajları

**Soru:**

Kullanıcı boş alan bırakırsa nasıl uyarı verebilirim?

**Yanıt:**


```php
if (empty($_POST['modname']) || empty($_POST['details'])) { $error = "Tüm alanları doldurmanız gerekmektedir."; }
```

---
### PHP Hata Ayıklama

**Soru:**

Beyaz ekran alıyorum, hataları nasıl görebilirim?

**Yanıt:**

Kodun en üstüne şu satırları ekleyin:
```php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
```

---
### Yönlendirme ve Bilgi Mesajları

**Soru:**

Silme veya ekleme sonrası kullanıcıya bilgi mesajı göstermek istiyorum.

**Yanıt:**

Session üzerinden mesaj taşıyarak yapılabilir:
```php
$_SESSION["message"] = "Silme işlemi başarılı."; header("Location: index.php"); 
Ve hedef sayfada:
if (isset($_SESSION["message"])) { echo "<div class='alert alert-info'>" . $_SESSION["message"] . "</div>"; unset($_SESSION["message"]); }
```

---
### Canlı Ortam ve Yayınlama

**Soru:**

XAMPP’ta çalıştırdığım projeyi canlıya nasıl alırım?

**Yanıt:**

Sunucu bilgileri (localhost, port) hosting ortamına göre güncellenmeli. Ayrıca config.php içindeki bağlantı bilgileri canlı sunucuya göre ayarlanmalıdır.

---
### Github Yükleme ve Gizlilik

**Soru:**

Projeyi Github’a yüklerken dikkat etmem gereken şeyler nelerdir?

**Yanıt:**

config.php gibi dosyalar gizli kalmalı. Hosting şifreleri, API anahtarları paylaşılmamalı. .gitignore dosyası kullanılabilir. Readme, AI.md, ekran görüntüleri ve tanıtım videosu eklenmelidir.

---
📌 Not:

Bu projede yapay zekâ yalnızca rehberlik ve teknik danışmanlık amacıyla kullanılmıştır. Tüm kodlama, veritabanı tasarımı ve uygulama geliştirme işlemleri proje geliştiricisi tarafından özgün olarak gerçekleştirilmiştir.
📅 Geliştirme Süreci: Haziran 2025

