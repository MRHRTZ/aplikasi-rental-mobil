<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $merk = $_POST['merk'];
    $warna = $_POST['warna'];
    $tahun_pembuatan = $_POST['tahun_pembuatan'];
    $biaya_sewa = $_POST['biaya_sewa'];
    $unit = $_POST['unit'];
    $no_plat = $_POST['no_plat'];

    // validasi no plat dengan separated comma harus sesuai dengan jumlah unit
    $no_plat = preg_replace('/\s*,\s*/', ',', $no_plat);
    $arr_no_plat = explode(',', $no_plat);
    if (count($arr_no_plat) != $unit) {
        echo "<script>alert('Jumlah no plat tidak sesuai dengan jumlah unit, harap input menggunakam koma terpisah, Contoh: no plat 1, no plat 2, dst'); window.location.href='mobil_tambah.php'</script>";
        exit;
    }

    $gambar = isset($_FILES['gambar']['name']) ? $_FILES['gambar']['name'] : '';
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    $file_extension = pathinfo($gambar, PATHINFO_EXTENSION);

    if (!in_array($file_extension, $allowed_extensions)) {
        echo "<script>alert('Format gambar tidak valid. Hanya diperbolehkan jpg, jpeg, png, dan gif.')</script>";
        exit;
    }
    $gambar = time() . '.' . $file_extension;
    $tmp = $_FILES['gambar']['tmp_name'];
    $dir = "../uploads/";
    move_uploaded_file($tmp, $dir.$gambar);

    $query = "INSERT INTO mobil (nama, merk, warna, tahun_pembuatan, biaya_sewa, gambar, unit, no_plat) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssiisis", $nama, $merk, $warna, $tahun_pembuatan, $biaya_sewa, $gambar, $unit, $no_plat);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: mobil_list.php');
    } else {
        echo "<script>alert('Gagal tambah data: " . mysqli_error($conn) . "')</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<h2>Tambah Mobil</h2>
<form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
    <table>
        <tr>
            <td>Nama Mobil:</td>
            <td><input type="text" name="nama" value="" required></td>
        </tr>
        <tr>
            <td>Merk:</td>
            <td><input type="text" name="merk" value="" required></td>
        </tr>
        <tr>
            <td>Warna:</td>
            <td><input type="text" name="warna" value="" required></td>
        </tr>
        <tr>
            <td>Tahun Pembuatan:</td>
            <td><input type="number" name="tahun_pembuatan" value="" required></td>
        </tr>
        <tr>
            <td>Biaya Sewa:</td>
            <td><input type="number" name="biaya_sewa" value="" required></td>
        </tr>
        <tr>
            <td>Unit:</td>
            <td><input type="number" name="unit" value="" required></td>
        </tr>
        <tr>
            <td>No Plat:</td>
            <td><input type="text" name="no_plat" value="" placeholder="B 1234 XXX,D 1234 XXX,..." required></td>
        </tr>
        <tr>
            <td>Gambar:</td>
            <td><input type="file" name="gambar" required></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="simpan">Simpan</button></td>
        </tr>
    </table>
</form>