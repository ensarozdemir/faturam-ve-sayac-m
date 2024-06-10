<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['tc'])) {
        $tc = $data['tc'];

        $sql = "SELECT * FROM kayıtol WHERE tc = '$tc'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo json_encode($user);
        } else {
            echo json_encode(["error" => "Kullanıcı bulunamadı"]);
        }
    } else {
        echo json_encode(["error" => "Geçersiz Giriş"]);
    }

    $conn->close();
}
?>
