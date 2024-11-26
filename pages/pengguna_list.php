<?php
include '../koneksi.php';

$query = "SELECT * FROM pengguna";
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
    </style>
</head>

<h1>Daftar Pengguna</h1>
<div style="margin-bottom: 20px; text-align: right;">
    <a href="pengguna_tambah.php">Tambah Pengguna</a>
</div>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Peran</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id_pengguna']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['peran']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['no_telp']; ?></td>
                <td>
                    <a href="pengguna_view.php?id=<?php echo $row['id_pengguna']; ?>">View</a>
                    <a href="pengguna_edit.php?id=<?php echo $row['id_pengguna']; ?>">Edit</a>
                    <a href="pengguna_hapus.php?id=<?php echo $row['id_pengguna']; ?>">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
mysqli_close($conn);
?>