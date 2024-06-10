<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_GET['user_id'];
    $bill_type = $_GET['bill_type'];

    $table_name = $bill_type . '_bill';

    $sql = "SELECT * FROM $table_name WHERE user_id = $user_id";
    $result = $conn->query($sql);

    $bills = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $bills[] = $row;
        }
    }

    echo json_encode($bills);

    $conn->close();
}
?>
