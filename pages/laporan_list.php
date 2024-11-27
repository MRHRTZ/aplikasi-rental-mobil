<?php
include '../koneksi.php';

$query = "SELECT p.id_rental, u.nama, u.alamat, u.no_telp, b.id_mobil, b.nama as mobil, b.biaya_sewa, b.gambar, p.tanggal_rental, p.tanggal_kembali
    FROM rental p 
    LEFT JOIN mobil b ON p.id_mobil = b.id_mobil 
    LEFT JOIN pengguna u ON p.id_pengguna = u.id_pengguna";
$result = mysqli_query($conn, $query);
?>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .car-img {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<h1>Laporan</h1>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No Telp</th>
            <th>Nama Mobil</th>
            <th>Total Biaya</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Gambar</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            while($row = mysqli_fetch_assoc($result)): 
                $total_biaya = $row['biaya_sewa'] * (strtotime($row['tanggal_kembali']) - strtotime($row['tanggal_rental'])) / (60 * 60 * 24);
        ?>
            <tr>
                <td><?php echo $row['id_rental']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['no_telp']; ?></td>
                <td><?php echo $row['mobil']; ?></td>
                <td><?php echo $total_biaya; ?></td>
                <td><?php echo date('d-m-Y', strtotime($row['tanggal_rental'])); ?></td>
                <td><?php echo date('d-m-Y', strtotime($row['tanggal_kembali'])); ?></td>
                <td>
                    <img src="../uploads/<?php echo $row['gambar']; ?>" class="car-img" alt="">
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
mysqli_close($conn);
?>