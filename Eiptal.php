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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!isset($_SESSION['username'])) {
        die("Oturum hatası. Lütfen tekrar giriş yapın.");
    }

    $username = $_SESSION['username'];

  
    $ad_soyad = $_POST['ad_soyad'];
    $tc = $_POST['tc'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];

    $abonelik_sorgu = "SELECT * FROM elektrik_abonelik WHERE email = '$email' AND tc = '$tc' AND ad_soyad = '$ad_soyad' AND telefon = '$telefon'";

    $abonelik_sonuc = $conn->query($abonelik_sorgu);

    if ($abonelik_sonuc->num_rows > 0) {
     
        $iptal_sorgu = "DELETE FROM elektrik_abonelik WHERE email = '$email' AND tc = '$tc' AND ad_soyad = '$ad_soyad' AND telefon = '$telefon'";

        if ($conn->query($iptal_sorgu) === TRUE) {
  
            $response = array("success" => true, "message" => "Aboneliğiniz başarıyla iptal edildi.");
            echo json_encode($response);
        } else {
    
            $response = array("success" => false, "message" => "Abonelik iptali sırasında bir hata oluştu: " . $conn->error);
            echo json_encode($response);
        }
    } else {
     
        $response = array("success" => false, "message" => "Aboneliğiniz bulunamadı veya girdiğiniz bilgilerle eşleşen bir abonelik bulunmamaktadır.");
        echo json_encode($response);
    }
}

$conn->close();
?>
