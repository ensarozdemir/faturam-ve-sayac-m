<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $tc = $data['tc'];
    $bill_type = $data['bill_type'];

    $table_name = "";
    switch ($bill_type) {
        case 'doğalgaz':
            $table_name = "doğalgaz_abonelik";
            break;
        case 'elektrik':
            $table_name = "elektrik_abonelik";
            break;
        case 'su':
            $table_name = "su_abonelik";
            break;
        case 'kay_tol':
            $table_name = "kay_tol";
            break;
        default:
            echo json_encode(["error" => "Geçersiz fatura türü"]);
            exit();
    }

    $sql = "SELECT * FROM $table_name WHERE tc = '$tc'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if ($user['abonelik_durumu'] !== 'aktif') {
            echo json_encode(["error" => "Aboneliğinizi etkinleştirin"]);
            exit();
        }

        $today = date('d');
        $okumaGünü = $user['okumaGünü'];
        $ertelem = $user['ertelemeTarihi'] ? intval($user['ertelemeTarihi']) : 0;
        $readDay = intval($okumaGünü) + $ertelem;

        if ($readDay != $today) {
            $daysToWait = $readDay > $today ? $readDay - $today : $readDay + (30 - $today);
            echo json_encode(["error" => "$daysToWait gün beklemeniz gerekiyor"]);
            exit();
        }else{
            echo json_encode(["error" => "true"]);
            exit();
        }

        // If we can read today, call create_fatura.php to generate the bill
       
        
       

    } else {
        echo json_encode(["error" => "Abonelik bulunamadı. Lütfen aboneliğnizi oluşturun."]);
    }
    $conn->close();
}
?>
