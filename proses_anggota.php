<?php
/*
NAMA : Ruby Okti Pratama Ramadhan
KELAS: TI2B
NIM  : 250102059
*/
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: form_anggota.php");
    exit;
}

$no_anggota    = isset($_POST["no_anggota"])    ? trim($_POST["no_anggota"])    : "";
$nama_lengkap  = isset($_POST["nama_lengkap"])  ? trim($_POST["nama_lengkap"])  : "";
$email         = isset($_POST["email"])         ? trim($_POST["email"])         : "";
$no_hp         = isset($_POST["no_hp"])         ? trim($_POST["no_hp"])         : "";
$jenis_anggota = isset($_POST["jenis_anggota"]) ? trim($_POST["jenis_anggota"]) : "";
$alamat        = isset($_POST["alamat"])        ? trim($_POST["alamat"])        : "";

$daftar_jenis = array("Mahasiswa", "Dosen", "Tenaga Kependidikan");
$error = array();

if (empty($no_anggota)) {
    $error[] = "Nomor Anggota tidak boleh kosong.";
} else if (strlen($no_anggota) > 15) {
    $error[] = "Nomor Anggota maksimal 15 digit.";
}

if (empty($nama_lengkap)) {
    $error[] = "Nama Lengkap tidak boleh kosong.";
} else if (strlen($nama_lengkap) > 100) {
    $error[] = "Nama Lengkap maksimal 100 karakter.";
}

if (empty($email)) {
    $error[] = "Email tidak boleh kosong.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = "Format email tidak valid.";
}

if (empty($no_hp)) {
    $error[] = "Nomor HP tidak boleh kosong.";
} else if (!ctype_digit($no_hp)) {
    $error[] = "Nomor HP hanya boleh berisi angka.";
}

if (empty($jenis_anggota)) {
    $error[] = "Jenis Anggota wajib dipilih.";
} else if (!in_array($jenis_anggota, $daftar_jenis, true)) {
    $error[] = "Jenis Anggota tidak valid.";
}

if (empty($alamat)) {
    $error[] = "Alamat tidak boleh kosong.";
}  else if (strlen($alamat) > 100) {
    $error[] = "Alamat tidak boleh lebih dari 100 karakter.";
}

$berhasil = false;
$pesan_db = "";

if (empty($error)) {
    require_once "koneksi.php";
    
    $sql = "INSERT INTO anggota (no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $no_anggota, $nama_lengkap, $email, $no_hp, $jenis_anggota, $alamat);

        if (mysqli_stmt_execute($stmt)) {
            $berhasil = true;
        } else {
            $pesan_db = mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $pesan_db = mysqli_error($koneksi);
    }
    mysqli_close($koneksi);

    if ($berhasil) {
        header("Location: form_anggota.php?status=sukses");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pendaftaran Anggota</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #1f3864; }
        .gagal { background: #fdecea; border-left: 5px solid #c0392b; padding: 10px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <?php if (!empty($error)) { ?>
        <h1>Data Tidak Valid</h1>
        <div class="gagal">Data belum dapat disimpan. Perbaiki kesalahan berikut:</div>
        <ul>
            <?php foreach ($error as $pesan) { ?>
                <li><?php echo htmlspecialchars($pesan); ?></li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <h1>Data Gagal Disimpan</h1>
        <div class="gagal">Terjadi kesalahan saat menyimpan data ke database.</div>
        <p>Pesan dari MySQL: <?php echo htmlspecialchars($pesan_db); ?></p>
    <?php } ?>
    
    <p><a href="form_anggota.php">Kembali Ke Form</a></p>
</body>
</html>
