<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proje";

$baglanti = new mysqli($servername, $username, $password, $dbname);

if ($baglanti->connect_error) {
    die("Veritabanı bağlantısı başarısız oldu: " . $baglanti->connect_error);
}

$baglanti->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["fullname"], $_POST["phone"], $_POST["email"])) {
        $fullname = $_POST["fullname"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];

        $sql = "SELECT * FROM kayıtOl WHERE fullname='$fullname' AND phone='$phone' AND email='$email'";
        $result = $baglanti->query($sql);

        if ($result->num_rows > 0) {
    
            $newPassword = generateRandomPassword();

            $updateSql = "UPDATE kayıtOl SET password='$newPassword' WHERE email='$email'";
            if ($baglanti->query($updateSql) === TRUE) {
                $response = array("success" => true, "message" => "Yeni şifre başarıyla oluşturuldu ve e-posta adresinize gönderildi.");
                echo json_encode($response);
            } else {
                $response = array("success" => false, "message" => "Şifre güncelleme hatası: " . $baglanti->error);
                echo json_encode($response);
            }
        } else {
            $response = array("success" => false, "message" => "Girilen bilgilere sahip bir kullanıcı bulunamadı.");
            echo json_encode($response);
        }
    } else {
        $response = array("success" => false, "message" => "Lütfen ad soyad, telefon ve e-posta adresi giriniz.");
        echo json_encode($response);
    }
}

$baglanti->close();

function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}
?>
