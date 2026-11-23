<?php

/*
NAMA : Ruby Okti Pratama Ramadhan
KELAS: TI2B
NIM  : 250102059
*/
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$username = "root";
$password = "";
$database = "db_perpustakaan";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . htmlspecialchars(mysqli_connect_error()));
} else {
    echo "Koneksi berhasil ke database: " . htmlspecialchars($database);
}

mysqli_set_charset($koneksi, "utf8mb4");
?>
