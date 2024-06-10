<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

   
        $checkSql = "SELECT * FROM kayıtOl WHERE email='$email'";
        $result = $baglanti->query($checkSql);
        
        if ($result->num_rows > 0) {
          
            $updateSql = "UPDATE kayıtOl SET fullname='$fullname', phone='$phone' WHERE email='$email'";

            if ($baglanti->query($updateSql) === TRUE) {
                $response = array("success" => true, "message" => "Bilgileriniz başarıyla güncellendi.");
            } else {
                $response = array("success" => false, "message" => "Bilgileriniz güncellenirken bir hata oluştu: " . $baglanti->error);
            }
        } else {
            
            $response = array("success" => false, "message" => "Böyle bir kullanıcı bulunamadı.");
        }

        echo json_encode($response);
    } else {
        $response = array("success" => false, "message" => "Lütfen tüm bilgileri giriniz.");
        echo json_encode($response);
    }
}

$baglanti->close();
?>


