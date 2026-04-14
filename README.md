# pengaduan_kehilangan

## 🚀 hostingan saya
[Klik di sini untuk lihat website](https://pengaduan-kehilangan-ghani.gt.tc/)

## Login Default

*Admin:*
- Username: ARIP
- Password: 123

*Siswa:*
- Nis: 2222
- Password: 123













<?php
$conn = mysqli_connect("localhost", "root", "", "nama_database");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>


<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa</title>
</head>
<body>

<h2>Form Tambah Siswa</h2>

<form method="POST">
    Nama: <br>
    <input type="text" name="nama" required><br><br>

    NIS: <br>
    <input type="text" name="nis" required><br><br>

    Kelas: <br>
    <input type="text" name="kelas" required><br><br>

    Alamat: <br>
    <textarea name="alamat" required></textarea><br><br>

    <button type="submit" name="simpan">Simpan</button>
</form>

<hr>

<?php
// PROSES SIMPAN
if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $nis    = $_POST['nis'];
    $kelas  = $_POST['kelas'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "INSERT INTO siswa VALUES ('', '$nama', '$nis', '$kelas', '$alamat')");
    echo "Data berhasil ditambahkan!<br><br>";
}
?>

<h2>Data Siswa</h2>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>NIS</th>
    <th>Kelas</th>
    <th>Alamat</th>
</tr>

<?php
$data = mysqli_query($conn, "SELECT * FROM siswa");
while ($d = mysqli_fetch_array($data)) {
?>
<tr>
    <td><?= $d['id']; ?></td>
    <td><?= $d['nama']; ?></td>
    <td><?= $d['nis']; ?></td>
    <td><?= $d['kelas']; ?></td>
    <td><?= $d['alamat']; ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>
