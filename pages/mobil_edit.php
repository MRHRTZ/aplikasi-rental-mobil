<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM mobil WHERE id_mobil = $id";
    $result = mysqli_query($conn, $query);
    $mobil = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
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
        echo "<script>alert('Jumlah no plat tidak sesuai dengan jumlah unit, harap input menggunakam koma terpisah, Contoh: no plat 1, no plat 2, dst'); window.location.href='mobil_edit.php?id=$id'</script>";
        exit;
    }

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
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

        $old_image = $mobil['gambar'];
        if (file_exists($dir.$old_image)) {
            unlink($dir.$old_image);
        }

        $query = "UPDATE mobil SET nama=?, merk=?, warna=?, tahun_pembuatan=?, biaya_sewa=?, gambar=?, unit=?, no_plat=? WHERE id_mobil=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sssiisisi', $nama, $merk, $warna, $tahun_pembuatan, $biaya_sewa, $gambar, $unit, $no_plat, $id);
    } else {
        $query = "UPDATE mobil SET nama=?, merk=?, warna=?, tahun_pembuatan=?, biaya_sewa=?, unit=?, no_plat=? WHERE id_mobil=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sssiiisi', $nama, $merk, $warna, $tahun_pembuatan, $biaya_sewa, $unit, $no_plat, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        header('Location: mobil_list.php');
    } else {
        echo "<script>alert('Gagal update data: " . mysqli_error($conn) . "')</script>";
    }
    mysqli_stmt_close($stmt);
}
?>

<head>
    <style>
        .car-img {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<h2>Edit Mobil</h2>
<form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="id" value="<?php echo $mobil['id_mobil']; ?>">
    <table>
        <tr>
            <td>Nama:</td>
            <td><input type="text" name="nama" value="<?php echo $mobil['nama']; ?>" required></td>
        </tr>
        <tr>
            <td>Merk:</td>
            <td><input type="text" name="merk" value="<?php echo $mobil['merk']; ?>" required></td>
        </tr>
        <tr>
            <td>Warna:</td>
            <td><input type="text" name="warna" value="<?php echo $mobil['warna']; ?>" required></td>
        </tr>
        <tr>
            <td>Tahun Pembuatan</td>
            <td><input type="number" name="tahun_pembuatan" value="<?php echo $mobil['tahun_pembuatan']; ?>" required></td>
        </tr>
        <tr>
            <td>Biaya Sewa:</td>
            <td><input type="number" name="biaya_sewa" value="<?php echo $mobil['biaya_sewa']; ?>" required></td>
        </tr>
        <tr>
            <td>Unit:</td>
            <td><input type="number" name="unit" value="<?php echo $mobil['unit']; ?>" required></td>
        </tr>
        <tr>
            <td>No Plat:</td>
            <td><input type="text" name="no_plat" value="<?php echo $mobil['no_plat']; ?>" required></td>
        </tr>
        <tr>
            <td>Gambar:</td>
            <td>
                <img src="<?php echo "../uploads/".$mobil['gambar']; ?>" class="car-img">
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="file" name="gambar"></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="update">Update</button></td>
        </tr>
    </table>
</form>