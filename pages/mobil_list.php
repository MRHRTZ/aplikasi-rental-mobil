<?php
include '../koneksi.php';

$query = "SELECT * FROM mobil";
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

<h1>Daftar Mobil</h1>
<div style="margin-bottom: 20px; text-align: right;">
    <a href="mobil_tambah.php">Tambah Mobil</a>
</div>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Merk</th>
            <th>Warna</th>
            <th>Tahun Pembuatan</th>
            <th>Biaya Sewa (perhari)</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id_mobil']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['merk']; ?></td>
                <td><?php echo $row['warna']; ?></td>
                <td><?php echo $row['tahun_pembuatan']; ?></td>
                <td><?php echo $row['biaya_sewa']; ?></td>
                <td>
                    <img src="../uploads/<?php echo $row['gambar']; ?>" class="car-img" alt="">
                </td>
                <td>
                    <a href="mobil_edit.php?id=<?php echo $row['id_mobil']; ?>" >Edit</a>
                    <a href="mobil_hapus.php?id=<?php echo $row['id_mobil']; ?>">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
mysqli_close($conn);
?>