<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proje";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    echo "Lütfen önce giriş yapınız.";
    exit;
}

$username = $_SESSION['username'];

$sql_user = "SELECT phone, tc FROM kayıtOl WHERE username='$username'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $userPhone = $row_user['phone'];
    $kayit_tc = $row_user['tc'];

    $tc = $_POST['tc'];

    if ($tc != $kayit_tc) {
        echo "Girdiğiniz TC Kimlik Numarası Size Ait Değil.";
        exit;
    }

    $sql_check_subscription = "SELECT * FROM doğalgaz_abonelik WHERE telefon='$userPhone'";
    $result_check_subscription = $conn->query($sql_check_subscription);

    if ($result_check_subscription->num_rows > 0) {
        
        $row_subscription = $result_check_subscription->fetch_assoc();
        $iptal_tarihi = $row_subscription['ertelemeTarihi'];
        $iptal_nedeni = $row_subscription['ertelemeNedeni'];

        
        $sql_cancel = "UPDATE doğalgaz_abonelik SET ertelemeTarihi=NULL, ertelemeNedeni=NULL WHERE telefon='$userPhone'";
        if ($conn->query($sql_cancel) !== TRUE) {
            echo "Erteleme iptal edilirken bir hata oluştu.";
        } else {
            if (!empty($iptal_tarihi) && !empty($iptal_nedeni)) {
                echo "$iptal_nedeni nedeniyle $iptal_tarihi tarihine kadar yapmış olduğunuz erteleme iptal edilmiştir.";
            } else {
                echo "Önceden ertelediğiniz bir sayaç okutma işlemi bulunmamaktadır.";
            }
        }

        $messageBody = "Sayaç okuma işleminiz $iptal_nedeni nedeniyle iptal edilmiştir. Yeni bir tarih belirleyebilirsiniz.";
        $twilioAccountSid = 'ACbb04c4f0c60eabd4588f78dbcab4dc0f';
        $twilioAuthToken = '9be003a5e034dbe7dc45a7f4ecab488a';
        $twilioFromNumber = '+14243478691';

        $twilioUrl = "https://api.twilio.com/2010-04-01/Accounts/$twilioAccountSid/Messages.json";

        $data = array(
            'To' => $userPhone,
            'From' => $twilioFromNumber,
            'Body' => $messageBody
        );

        $curl = curl_init($twilioUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "$twilioAccountSid:$twilioAuthToken");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($response === false) {
            echo "SMS gönderirken bir hata oluştu: " . $error;
        } else {
            echo "SMS başarıyla gönderildi.";
        }
    } else {
        
        echo "Herhangi bir ertelemeniz bulunmamaktadır.";
    }
} else {
    echo "Kullanıcı bilgileri bulunamadı.";
}
?>
