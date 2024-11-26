<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM mobil WHERE id_mobil = $id";
    $result = mysqli_query($conn, $query);
    $mobil = mysqli_fetch_assoc($result);
}
?>

<head>
    <style>
        .car-img {
            width: 300px;
            height: auto;
        }
    </style>
</head>

<h2>View Mobil</h2>
<form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="id" value="<?php echo $mobil['id_mobil']; ?>">
    <table>
        <tr>
            <td colspan="2">
                <img src="<?php echo "../uploads/" . $mobil['gambar']; ?>" class="car-img">
            </td>
        </tr>
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
    </table>
</form>