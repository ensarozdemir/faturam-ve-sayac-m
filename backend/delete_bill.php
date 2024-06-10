<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bill_id = $_POST['bill_id'];
    $bill_type = $_POST['bill_type'];

    $table_name = $bill_type . '_bill';

    $sql = "DELETE FROM $table_name WHERE id = $bill_id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Fatura başarıyla silindi"]);
    } else {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
    }

    $conn->close();
}
?>
