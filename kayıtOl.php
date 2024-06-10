<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proje";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $tc = $_POST['tc'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        echo "<script>alert('Parolalar eşleşmiyor.');</script>"; 
        echo "<script>window.location = 'bitirmeProjesi/html/kayıtOl.html';</script>"; 
        exit;
    }


    if (strlen($password) < 8 || !preg_match("/[a-zA-Z]/", $password) || !preg_match("/\d/", $password) || !preg_match("/\W/", $password)) {
        echo "<script>alert('Parola en az 8 karakterden oluşmalı, bir harf, bir sayı ve bir özel karakter içermelidir.');</script>"; 
        echo "<script>window.location = 'bitirmeProjesi/html/kayıtOl.html';</script>"; 
        exit;
    }

 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO kayıtOl (fullname, tc, email, phone, username, password) VALUES ('$fullname', '$tc', '$email', '$phone', '$username', '$hashed_password')";
    $result = $conn->query($sql);


    header("Location: bitirmeProjesi/html/giriş.html");
    exit;
}

$conn->close();
?>
