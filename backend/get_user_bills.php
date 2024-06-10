<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['tc'])) {
        $tc = $data['tc'];

        $sql = "SELECT * FROM bill_table WHERE tc = '$tc'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $bills = array();
            while($row = $result->fetch_assoc()) {
                $bills[] = $row;
            }
            echo json_encode($bills);
        } else {
            echo json_encode([]);
        }
    } else {
        echo json_encode(["error" => "Invalid input"]);
    }

    $conn->close();
}
?>
