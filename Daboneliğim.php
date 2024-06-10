<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proje";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    header("Location: bitirmeProjesi/giriş.html");
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM kayıtOl WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $kayit_tc = isset($row['tc']) ? $row['tc'] : ''; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tc = $_POST['tc'];

    if ($tc != $kayit_tc) {
        echo "<div id='sonuc-panel' onclick='hidePanel()' style='display: block; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-image: linear-gradient(to right top, #ffffff 0%, #add8e6 25%, #ffe4b5 50%, #ff3300 100%); border: 1px solid #ced4da; border-radius: 5px; padding: 20px; max-width: 600px;'>";
        echo "<p style='color: white;'>Girdiğiniz TC Kimlik Numarası Size Ait Değil.</p>";
        echo "</div>";
    } else {
        $sql = "SELECT * FROM doğalgaz_abonelik WHERE tc = '$tc'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
           echo "<div id='sonuc-panel' onclick='hidePanel()' style='display: block; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-image: linear-gradient(to right top, #ffffff 0%, #add8e6 25%, #ffe4b5 50%, #ff3300 100%); border: 1px solid #ced4da; border-radius: 5px; padding: 20px; max-width: 600px;'>";
           echo "<h2 style='text-align: center; font-weight: bold; font-style: italic;'>Abonelik Bilgileri</h2>";
           echo "<p>Ad Soyad: " . $row['ad_soyad'] . "</p>";
           echo "<p>TC Kimlik: " . $row['tc'] . "</p>";
           echo "<p>Telefon: " . $row['telefon'] . "</p>";
           echo "<p>Email: " . $row['email'] . "</p>";
           echo "<p>Mülk: " . $row['mulk'] . "</p>";
           echo "<p>Adres: " . $row['adres'] . "</p>";
           echo "<p>Resim Adresi: <img src='" . $row['resim_yol'] . "' alt='Resim'></p>";
           echo "<p>Ön Resim Adresi: <img src='" . $row['resim_on_yol'] . "' alt='Ön Resim'></p>";
           echo "<p>Arka Resim Adresi: <img src='" . $row['resim_arka_yol'] . "' alt='Arka Resim'></p>";
           echo "</div>";
        } else {
            echo "<div id='sonuc-panel' onclick='hidePanel()' style='display: block; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-image: linear-gradient(to right top, #ffffff 0%, #add8e6 25%, #ffe4b5 50%, #ff3300 100%); border: 1px solid #ced4da; border-radius: 5px; padding: 20px; max-width: 600px;'>";
            echo "<p style='color: white;'>Girdiğiniz TC Kimlik Numarasına Göre Abonelik Bulunamadı.</p>";
            echo "</div>";
        }
    }
}
?>

<script>
function sorgula() {
    var panel = document.getElementById("sonuc-panel");
    panel.style.display = "block"; 
    return false;
}

</script>
