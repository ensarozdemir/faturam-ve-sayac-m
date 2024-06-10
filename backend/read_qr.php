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
            echo json_encode(["error" => "Activate your subscription"]);
            exit();
        }

        $today = date('d');
        $okumaGünü = $user['okumaGünü'];
        $ertelem = $user['ertelemeTarihi'] ? intval($user['ertelemeTarihi']) : 0;
        $readDay = intval($okumaGünü) + $ertelem;

        if ($readDay != $today) {
            $daysToWait = $readDay > $today ? $readDay - $today : $readDay + (30 - $today);
            echo json_encode(["error" => "You need to wait $daysToWait days"]);
            exit();
        }

        // If we can read today, call create_fatura.php to generate the bill
        $fatura_data = [
            'tc' => $tc,
            'bill_type' => $bill_type,
            'price' => rand(100, 1000),  // Example price calculation, you can customize this
            'time' => date('Y-m-d H:i:s')
        ];
        
        $ch = curl_init('http://localhost/term_project/backend/create_fatura.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fatura_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        echo $response;

    } else {
        echo json_encode(["error" => "User not found. Please register."]);
    }
    $conn->close();
}
?>
