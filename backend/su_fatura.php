<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data) {
        $tc = $data['tc'];

        $sql = "SELECT * FROM su_bill WHERE tc = '$tc'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $bill = $result->fetch_assoc();
            echo json_encode(["message" => "Bill found", "bill" => $bill]);
        } else {
            echo json_encode(["error" => "Kullanıcı bulunamadı"]);
        }
    } else {
        echo json_encode(["error" => "Geçersiz Giriş"]);
    }

    $conn->close();
}
?>
