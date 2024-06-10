<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proje";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $security_code = $_POST["security_code"];
	$hidden_security_code = $_POST["hidden_security_code"];

   $_SESSION['security_code'] = $hidden_security_code;
   
    if (!isset($_SESSION['security_code']) || $_SESSION['security_code'] !== $security_code) {
        echo "<script>alert('Güvenlik kodu yanlış.');</script>";
        echo "<script>window.location.href = 'bitirmeProjesi/html/giriş.html';</script>";
        exit;
    }

    $sql = "SELECT * FROM kayıtOl WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            header("Location: bitirmeProjesi/html/anaSayfa.html");
            exit;
        } else {
            echo "<script>alert('Kullanıcı adı veya parola yanlış');</script>";
            echo "<script>window.location.href = 'bitirmeProjesi/html/giriş.html';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Kullanıcı bulunamadı');</script>";
        echo "<script>window.location.href = 'bitirmeProjesi/html/giriş.html';</script>";
        exit;
    }
}

$conn->close();
?>
