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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ertelemeTarihi']) && isset($_POST['ertelemeNedeni'])) {

    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        echo "Lütfen önce giriş yapınız.";
        exit;
    }

    $username = $_SESSION['username'];

    $sql_user = "SELECT phone FROM kayıtOl WHERE username='$username'";
    $result_user = $conn->query($sql_user);

    if ($result_user) {
        if ($result_user->num_rows > 0) {
            $row_user = $result_user->fetch_assoc();
            $userPhone = $row_user['phone'];

            $sql_check_subscription = "SELECT * FROM elektrik_abonelik WHERE telefon='$userPhone'";
            $result_check_subscription = $conn->query($sql_check_subscription);

            if ($result_check_subscription) {
                if ($result_check_subscription->num_rows > 0) {
                    $row_subscription = $result_check_subscription->fetch_assoc();
                    $ertelemeTarihi = $row_subscription['ertelemeTarihi'];

                    if (!empty($ertelemeTarihi)) {
                        $currentDate = date("Y-m-d");
                        if ($currentDate < $ertelemeTarihi) {
                            $message = "Önceden sayaç okutma tarihini ertelediğiniz için tekrar ertelemeyebilirsiniz. {$row_subscription['ertelemeNedeni']} nedeninden dolayı bu tarihe kadar $ertelemeTarihi ertelediğiniz için tekrar bir erteleme yapamazsınız. Önce ertelemeyi iptal etmeniz gerekmektedir.";
                            echo $message;
                            exit; 
                        } else {
                            echo "Önceki ertelemenin tarihi geçtiği için tekrar erteleyebilirsiniz.";
                        }
                    }

                    $ertelemeTarihi = $_POST['ertelemeTarihi'];
                    $ertelemeNedeni = $_POST['ertelemeNedeni'];

                    $sql_update = "UPDATE elektrik_abonelik SET ertelemeTarihi='$ertelemeTarihi', ertelemeNedeni='$ertelemeNedeni' WHERE telefon='$userPhone'";
                    if ($conn->query($sql_update) !== TRUE) {
                        echo "Ertelme kaydedilirken bir hata oluştu.";
                    } else {
                        $message = "Sayaç okutma işleminiz $ertelemeNedeni nedeninden dolayı $ertelemeTarihi tarihine kadar ertelenmiştir. $userPhone numaralı telefonunuza SMS ile bildirilecektir.";
                        echo "$message";

                       
                        $twilioAccountSid = 'ACbb04c4f0c60eabd4588f78dbcab4dc0f';
                        $twilioAuthToken = '9be003a5e034dbe7dc45a7f4ecab488a';
                        $twilioFromNumber = '+14243478691';

                        $messageBody = $message;

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
                    }
                } else {
                    echo "Aboneliğiniz bulunmamaktadır. Lütfen önce abone olunuz.";
                }
            } else {
                echo "Abonelik bilgileri alınamadı.";
            }
        } else {
            echo "Kullanıcı bilgileri bulunamadı.";
        }
    } else {
        echo "Kullanıcı bilgileri alınamadı.";
    }
}
?>
