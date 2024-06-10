<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['result']) && isset($data['tc']) && isset($data['bill_type']) && isset($data['status']) && isset($data['date'])) {
        $result = $data['result'];
        $tc = $data['tc'];
        $billType = $data['bill_type'];
        $status = $data['status'];
        $date = $data['date'];

        $sql = "INSERT INTO bill_table (result, tc, bill_type, status, date) VALUES ('$result', '$tc', '$billType', '$status', '$date')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => "Fatura başarıyla oluşturuldu"]);
        } else {
            echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Geçersiz Giriş"]);
    }

    $conn->close();
}
?>
