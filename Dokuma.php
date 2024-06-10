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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['okumaGünü'])) {

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

            $sql_check_subscription = "SELECT * FROM doğalgaz_abonelik WHERE telefon='$userPhone'";
            $result_check_subscription = $conn->query($sql_check_subscription);

            if ($result_check_subscription) {
                if ($result_check_subscription->num_rows > 0) {
                    $row_subscription = $result_check_subscription->fetch_assoc();
                    $okumaGünü = $row_subscription['okumaGünü'];

                    $okumaGünüExists = !empty($okumaGünü);

                    if (!$okumaGünüExists) {

                        $okumaGünü = $_POST['okumaGünü'];

                        $sql_update = "UPDATE doğalgaz_abonelik SET okumaGünü='$okumaGünü' WHERE telefon='$userPhone'";
                        if ($conn->query($sql_update) !== TRUE) {
                            echo "Gün seçimi kaydedilirken bir hata oluştu.";
                        } else {
                            $message = "Sayaç okutma gününüz: $okumaGünü. $userPhone numaralı telefonunuza sayaç okutma günü yaklaştıkça hatırlatma için sms gönderilecektir.";
                            echo "$message;";
                        }
                    } else {
                        echo "Önceden sayaç okutma günü seçtiğiniz için tekrar gün seçemezsiniz.";
                    }

                    $today = date('Y-m-d');
                    $okumaDate = date('Y-m-d', strtotime($okumaGünü));
                    $reminderDates = array();

                    $reminderDates[] = date('Y-m-d', strtotime($okumaDate . '-3 days'));

                    $reminderDates[] = date('Y-m-d', strtotime($okumaDate . '-2 days'));

                    $reminderDates[] = date('Y-m-d', strtotime($okumaDate . '-1 days'));

                    $reminderDates[] = $okumaDate;

                    foreach ($reminderDates as $date) {
                        if ($date == $today) {
                            $message = "Bugün sayaç okutma gününüz. Lütfen sayacınızı okutun.";
                            echo "$message";

                            break;
                        } elseif ($date > $today) {
                            $daysLeft = date_diff(date_create($today), date_create($date))->days;
                            $message = "Sayaç okutma gününüze $daysLeft gün kaldı.";
                            echo "$message";
							
                            break;
                        }
                    }

                    $twilioAccountSid = 'ACbb04c4f0c60eabd4588f78dbcab4dc0f';
                    $twilioAuthToken = '9be003a5e034dbe7dc45a7f4ecab488a';
                    $twilioFromNumber = '+14243478691';

                    $messageBody = "Sayaç okuma gününüz yaklaşıyor. Lütfen sayacınızı okutun.";

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
