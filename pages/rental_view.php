<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT p.id_rental, u.nama, u.alamat, u.no_telp, b.id_mobil, b.nama as mobil, b.biaya_sewa, b.gambar, p.tanggal_rental, p.tanggal_kembali
    FROM rental p 
    LEFT JOIN mobil b ON p.id_mobil = b.id_mobil 
    LEFT JOIN pengguna u ON p.id_pengguna = u.id_pengguna
    WHERE p.id_rental = $id";
    $result = mysqli_query($conn, $query);
    $rental = mysqli_fetch_assoc($result);
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

<h2>View Rental</h2>
<form method="POST" action="" autocomplete="off">
    <input type="hidden" name="id" value="<?php echo $rental['id_rental']; ?>">
    <table>
        <tr>
            <td colspan="2">
                <img src="<?php echo "../uploads/" . $rental['gambar']; ?>" class="car-img">
            </td>
        </tr>
        <tr>
            <td>Nama:</td>
            <td><?= $rental['nama'] ?></td>
        </tr>
        <tr>
            <td>Alamat:</td>
            <td><?= $rental['alamat'] ?></td>
        </tr>
        <tr>
            <td>No. Telp:</td>
            <td><?= $rental['no_telp'] ?></td>
        </tr>
        <tr>
            <td>Nama Mobil:</td>
            <td><?= $rental['mobil'] ?></td>
        </tr>
        <tr>
            <td>Biaya Sewa:</td>
            <td><?= $rental['biaya_sewa'] ?></td>
        </tr>
        <tr>
            <td>Tanggal Pinjam:</td>
            <td><?= $rental['tanggal_rental'] ?></td>
        </tr>
        <tr>
            <td>Tanggal Kembali:</td>
            <td><?= $rental['tanggal_kembali'] ?></td>
        </tr>
    </table>
</form>