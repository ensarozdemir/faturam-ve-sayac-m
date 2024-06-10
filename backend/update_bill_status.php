<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bill_id = $_POST['bill_id'];
    $bill_type = $_POST['bill_type'];
    $status = $_POST['status'];

    $table_name = $bill_type . '_bill';

    $sql = "UPDATE $table_name SET status = '$status' WHERE id = $bill_id";

    if ($conn->query($sql) === TRUE) {
        echo "Kayıt başarıyla güncellendi";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
