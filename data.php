<?php
/*
NAMA : Ruby Okti Pratama Ramadhan
KELAS: TI2B
NIM  : 250102059
*/
require_once 'koneksi.php';

$sql = "SELECT * FROM anggota ORDER BY id DESC";
$hasil = mysqli_query($koneksi, $sql);
$jumlah_data = mysqli_num_rows($hasil);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f9f9f9; }
        h1 { color: #1f3864; }
        table { width: 100%; background-color: #f9f9f9; }
        th { background-color: #1f3864; color: #ffffff; padding: 8px; text-align: left; border-bottom: 1px solid #f9f9f9; }
        td { padding: 8px; border-bottom: 1px solid #f9f9f9; font-size: 15px; background-color: #f9f9f9; }
        .pesan-koneksi { background-color: #f9f9f9; border-left: 5px solid #1f3864; color: green; padding: 10px; width: 320px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Data Anggota</h1>
    <table border="1">
        <tr>
            <th>Nomor Anggota</th>
            <th>Nama Anggota</th>
            <th>Alamat email</th>
            <th>Nomor telepon seluler</th>
            <th>Jenis Anggota</th>
            <th>Alamat anggota</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($baris = mysqli_fetch_assoc($hasil)) { ?>
            <tr>
                <td>
                    <?php echo $no++; ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($baris['nama_lengkap']); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($baris['email']); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($baris['no_hp']); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($baris['jenis_anggota']); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($baris['alamat']); ?>
                </td>
                <td>
                    <a href="detail.php?id=<?php echo $baris['id']; ?>">Detail</a>
                    <form class="inline" action="hapus.php" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <input type="hidden" name="id" value="<?php echo $baris['id']; ?>">
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
