<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $tc = $data['tc'];
    $bill_type = $data['bill_type'];
    $price = $data['price'];
    $time = $data['time'];

    $table_name = $bill_type . '_fatura';

    $sql = "INSERT INTO $table_name (tc, price, time, bill_type) VALUES ('$tc', '$price', '$time', '$bill_type')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Fatura başarıyla oluşturuldu"]);
    } else {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
    }

    $conn->close();
}
?>
