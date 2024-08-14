<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "Firlansyah100%");
define("DB_NAME", "perpustakaan_digital");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($conn->connect_error){
    echo "koneksi error " . $conn->connect_error;
}

?>