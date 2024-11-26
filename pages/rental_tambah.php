<?php
include '../koneksi.php';

$query_pengguna = "SELECT * FROM pengguna WHERE peran = 'anggota'";
$pengguna = mysqli_query($conn, $query_pengguna);

$query_mobil = "SELECT * FROM mobil";
$mobil = mysqli_query($conn, $query_mobil);

if (isset($_POST['simpan'])) {
    $id_pengguna = $_POST['id_pengguna'];
    $id_mobil = $_POST['id_mobil'];
    $tanggal_rental = $_POST['tanggal_rental'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $query = "INSERT INTO rental (id_pengguna, id_mobil, tanggal_rental, tanggal_kembali) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iiss", $id_pengguna, $id_mobil, $tanggal_rental, $tanggal_kembali);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: rental_list.php');
    } else {
        echo "<script>alert('Gagal tambah data: " . mysqli_error($conn) . "')</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<h2>Tambah Rental</h2>
<form method="POST" action="" autocomplete="off">
    <table>
        <tr>
            <td>Anggota:</td>
            <td>
                <select name="id_pengguna" required>
                    <?php while ($row = mysqli_fetch_assoc($pengguna)) : ?>
                        <option value="<?php echo $row['id_pengguna']; ?>"><?php echo $row['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Mobil:</td>
            <td>
                <select name="id_mobil" required>
                    <?php while ($row = mysqli_fetch_assoc($mobil)) : ?>
                        <option value="<?php echo $row['id_mobil']; ?>"><?php echo $row['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tanggal Pinjam:</td>
            <td><input type="date" name="tanggal_rental" value="<?php echo date('Y-m-d'); ?>" required></td>
        </tr>
        <tr>
            <td>Tanggal Kembali:</td>
            <td><input type="date" name="tanggal_kembali" value="" required></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="simpan">Simpan</button></td>
        </tr>
    </table>
</form>