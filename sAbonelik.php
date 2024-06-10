<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proje";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    $ad_soyad = '';
    $tc = '';
    $telefon = '';
    $email = '';
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM kayıtOl WHERE username = '$username'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $kayit_ad_soyad = isset($row['fullname']) ? $row['fullname'] : ''; 
    $kayit_tc = isset($row['tc']) ? $row['tc'] : ''; 
    $kayit_telefon = isset($row['phone']) ? $row['phone'] : ''; 
    $kayit_email = isset($row['email']) ? $row['email'] : ''; 
	
	$abonelik_sorgu = "SELECT * FROM su_abonelik WHERE email = '$username'";
    $abonelik_sonuc = $conn->query($abonelik_sorgu);
    if ($abonelik_sonuc->num_rows > 0) {
        $_SESSION['abone_mi'] = true; 
    } else {
        $_SESSION['abone_mi'] = false; 
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ad_soyad = $_POST['ad_soyad']; 
    $tc = $_POST['tc']; 
    $telefon = $_POST['telefon']; 
    $email = $_POST['email']; 
    $mulk = $_POST['mulk']; 
    $adres = $_POST['adres']; 
    $onay = isset($_POST['onay']) ? 1 : 0;
	
	$abonelik_sorgu = "SELECT * FROM su_abonelik WHERE email = '$email'";
    $abonelik_sonuc = $conn->query($abonelik_sorgu);
    if ($abonelik_sonuc->num_rows > 0) {
        echo "<script>
    var message = 'Önceden abone olduğunuz için tekrar abone olamazsınız.';
    alert(message); 
    window.location.href = 'bitirmeProjesi/html/anasu.html'; 
</script>";
exit;
    }

   if ($kayit_ad_soyad !== $ad_soyad || $kayit_tc !== $tc || $kayit_telefon !== $telefon || $kayit_email !== $email) {

    echo "<script>var message = 'Kayıt bilgileriniz ile abonelik bilgileriniz eşleşmemektedir.';</script>";
} else  {
  
        $resim_yol = isset($_FILES['resim']['name']) ? $_FILES['resim']['name'] : ''; 
        $resim_on_yol = isset($_FILES['resim-on']['name']) ? $_FILES['resim-on']['name'] : ''; 
        $resim_arka_yol = isset($_FILES['resim-arka']['name']) ? $_FILES['resim-arka']['name'] : ''; 

 
        function generateAbonelikNumarasi() {
            $harfler = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $rakamlar = '0123456789';
            
            $harf = $harfler[rand(0, strlen($harfler) - 1)];
            $rakam1 = $rakamlar[rand(0, strlen($rakamlar) - 1)];
            $rakam2 = $rakamlar[rand(0, strlen($rakamlar) - 1)];
            $rakam3 = $rakamlar[rand(0, strlen($rakamlar) - 1)];
            
            return $harf . $rakam1 . $rakam2 . $rakam3;
        }

        $abonelik_numarasi = generateAbonelikNumarasi();

        $sql = "INSERT INTO su_abonelik (ad_soyad, tc, telefon, email, mulk, adres, resim_yol, resim_on_yol, resim_arka_yol, abonelik_numarasi, onay, abonelik_durumu) VALUES ('$ad_soyad', '$tc', '$telefon', '$email', '$mulk', '$adres', '$resim_yol', '$resim_on_yol', '$resim_arka_yol', '$abonelik_numarasi', '$onay', 'aktif')";

        if ($conn->query($sql) === TRUE) {

            echo "<script>var message = 'Abonelik başarıyla oluşturuldu.';</script>";
			 echo "<script>
            setTimeout(function() {
                window.location.href = 'bitirmeProjesi/html/anasu.html'; 
            }, 3000); 
          </script>";
        } else {
            echo "Abonelik oluşturulurken bir hata oluştu: " . $conn->error;
        }
    }
} else {
   
    $ad_soyad = isset($kayit_ad_soyad) ? $kayit_ad_soyad : '';
    $tc = isset($kayit_tc) ? $kayit_tc : '';
    $telefon = isset($kayit_telefon) ? $kayit_telefon : '';
    $email = isset($kayit_email) ? $kayit_email : '';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Su Abonelik Formu</title>
<link rel="stylesheet" href="bitirmeProjesi/html/css/sAbonelik.css">
<style>
</style>
</head>
<body>
	
    <div class="container">
        <h2 class="title">Su Abonelik Formu</h2>
        <form action="http://localhost/sAbonelik.php" method="POST" enctype="multipart/form-data" class="form-container">
            <div class="form-group">
                <label for="resim">Vesikalık Fotoğraf</label>
                <input type="file" id="resim" name="resim" required>
            </div>
            <div class="form-group">
                <label for="resim-on">Kimlik Fotoğrafı (Ön Yüz)</label>
                <input type="file" id="resim-on" name="resim-on" required>
            </div>
            <div class="form-group">
                <label for="resim-arka">Kimlik Fotoğrafı (Arka Yüz)</label>
                <input type="file" id="resim-arka" name="resim-arka" required>
            </div>
            <div class="form-group">
                <label for="fullname">Ad Soyad:</label>
                <input type="text" id="ad_soyad" name="ad_soyad" value="<?php echo isset($ad_soyad) ? $ad_soyad : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="tc">TC Kimlik Numarası</label>
                <input type="text" id="tc" name="tc" value="<?php echo isset($tc) ? $tc : ''; ?>" minlength="11" maxlength="11" required>
            </div>
            <div class="form-group">
                <label for="telefon">Telefon Numarası</label>
                <input type="text" id="telefon" name="telefon" value="<?php echo isset($telefon) ? $telefon : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail Adresi</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="mulk">Abonelik Mülkiyeti</label>
                <select id="mulk" name="mulk">
                    <option value="kira">Kira</option>
                    <option value="ev_sahibi">Ev Sahibi</option>
                </select>
            </div>
            <div class="form-group">
                <label for="adres">Adres</label>
                <textarea id="adres" name="adres" style="width: 100%;" required></textarea>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="onay" name="onay" required>
                <label for="onay">Su aboneliği sözleşmesi ve aydınlatma metni</label>
            </div>
            <button type="submit">Gönder</button>
        </form>
    </div>
	
	<div class="message-panel" id="messagePanel"></div>
	
    <div id="aydinlatma-panel" class="aydinlatma-panel">
        <div class="aydinlatma-panel-content">
            <span id="close" class="close">&times;</span>
            <p>Bu metin su aboneliği hakkında detaylı bilgi içerir. Su aboneliği sözleşmesi ve aydınlatma metni olarak adlandırılan bu belge, abonelik işlemleri sırasında kullanıcıya sunulan bir belgedir. Bu belgede, su tedarikçisi ve tüketici arasındaki hak ve sorumluluklar, fatura ödeme koşulları, aboneliğin iptali ve diğer önemli bilgiler yer alır. Kullanıcıların bu metni dikkatlice okumaları ve anlamaları önemlidir, çünkü su aboneliği ile ilgili hak ve yükümlülüklerini belirler. Ayrıca, bu metni onaylamadan önce herhangi bir soruları varsa su tedarikçilerine danışmaları önerilir.</p>
        <p>Kanunlarda açıkça öngörülmesi.</p>
         <p>Fiili imkânsızlık nedeniyle rızasını açıklayamayacak durumda bulunan veya rızasına hukuki geçerlilik tanınmayan kişinin kendisinin ya da bir başkasının hayatı veya beden bütünlüğünün korunması için zorunlu olması.</p>
         <p>Bir sözleşmenin kurulması veya ifasıyla doğrudan doğruya ilgili olması kaydıyla, sözleşmenin taraflarına ait kişisel verilerin işlenmesinin gerekli olması.</p>
         <p>Veri sorumlusunun hukuki yükümlülüğünü yerine getirebilmesi için zorunlu olması.</p>
         <p>İlgili kişinin kendisi tarafından alenileştirilmiş olması.</p>
         <p>Bir hakkın tesisi, kullanılması veya korunması için veri işlemenin zorunlu olması.</p>
         <p>İlgili kişinin temel hak ve özgürlüklerine zarar vermemek kaydıyla, veri sorumlusunun meşru menfaatleri için veri işlenmesinin zorunlu olması.</p>
		 <p>Hukuka ve dürüstlük kuralının öngördüğü biçimde,</p>
         <p>İşlenme amaçları ile bağlantılı, sınırlı ve ölçülü olarak,</p>
         <p>Doğru ve güncel olarak,</p>
         <p>Belirli açık ve meşru amaçlar</p>
		<p>Bu metni okuyup onaylıyorum.</p>
        </div>
    </div>

    <script>
	document.addEventListener("DOMContentLoaded", function() {

    function showMessage(message) {
        var panel = document.getElementById("messagePanel");
        panel.textContent = message;
        panel.style.display = "block";
      
        setTimeout(function() {
            panel.style.display = "none";
        }, 5000);
    }

    if (typeof message !== 'undefined') {
        showMessage(message);
    }
}); 

    document.addEventListener("DOMContentLoaded", function() {
        const panel = document.getElementById("aydinlatma-panel");
        const toggle = document.getElementById("onay");

        toggle.addEventListener("click", function() {
            panel.style.display = "block";
        });

        const close = document.getElementById("close");
        close.addEventListener("click", function() {
            panel.style.display = "none";
        });

        window.addEventListener("click", function(event) {
            if (event.target === panel) {
                panel.style.display = "none";
            }
        });
    });
    </script>
</body>
</html>
