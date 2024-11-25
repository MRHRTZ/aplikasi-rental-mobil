<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {
    $judul_mobil = $_POST['judul_mobil'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $jumlah_mobil = $_POST['jumlah_mobil'];


    $query = "INSERT INTO mobil (judul_mobil, pengarang, penerbit, tahun_terbit, jumlah_mobil) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssii", $judul_mobil, $pengarang, $penerbit, $tahun_terbit, $jumlah_mobil);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: mobil_list.php');
    } else {
        echo "<script>alert('Gagal tambah data: " . mysqli_error($conn) . "')</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<h2>Tambah Mobil</h2>
<form method="POST" action="" autocomplete="off">
    <table>
        <tr>
            <td>Judul Mobil:</td>
            <td><input type="text" name="judul_mobil" value="" required></td>
        </tr>
        <tr>
            <td>Pengarang:</td>
            <td><input type="text" name="pengarang" value="" required></td>
        </tr>
        <tr>
            <td>Penerbit:</td>
            <td><input type="text" name="penerbit" value="" required></td>
        </tr>
        <tr>
            <td>Tahun Terbit:</td>
            <td><input type="number" name="tahun_terbit" value="" required></td>
        </tr>
        <tr>
            <td>Jumlah Mobil:</td>
            <td><input type="number" name="jumlah_mobil" value="" required></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="simpan">Simpan</button></td>
        </tr>
    </table>
</form>