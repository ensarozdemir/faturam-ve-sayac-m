<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data) {
        $fullname = $data['fullname'];
        $tc = $data['tc'];
        $email = $data['email'];
        $phone = $data['phone'];
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the password

        $sql = "INSERT INTO kayıtol (fullname, tc, email, phone, username, password) VALUES ('$fullname', '$tc', '$email', '$phone', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Yeni kayıt başarıyla oluşturuldu"]);
        } else {
            echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Geçersiz Giriş"]);
    }

    $conn->close();
}
?>
