<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM rental WHERE id_rental = $id";
    $result = mysqli_query($conn, $query);
    $rental = mysqli_fetch_assoc($result);

    $query_pengguna = "SELECT * FROM pengguna WHERE peran = 'anggota'";
    $pengguna = mysqli_query($conn, $query_pengguna);

    $query_mobil = "SELECT * FROM mobil";
    $mobil = mysqli_query($conn, $query_mobil);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $id_pengguna = $_POST['id_pengguna'];
    $id_mobil = $_POST['id_mobil'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $query_pinjam = "SELECT * FROM rental WHERE id_rental = $id";
    $pinjam_query = mysqli_query($conn, $query_pinjam);
    $pinjam = mysqli_fetch_assoc($pinjam_query);

    $query = "UPDATE rental SET id_pengguna=?, id_mobil=?, tanggal_pinjam=?, tanggal_kembali=? WHERE id_rental=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iissi', $id_pengguna, $id_mobil, $tanggal_pinjam, $tanggal_kembali, $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: rental_list.php');
    } else {
        echo "<script>alert('Gagal update data: " . mysqli_error($conn) . "')</script>";
    }
    mysqli_stmt_close($stmt);
}
?>

<h2>Edit Rental</h2>
<form method="POST" action="" autocomplete="off">
    <input type="hidden" name="id" value="<?php echo $rental['id_rental']; ?>">
    <table>
        <tr>
            <td>Anggota:</td>
            <td>
                <select name="id_pengguna" required>
                    <?php while ($row = mysqli_fetch_assoc($pengguna)) : ?>
                        <option value="<?php echo $row['id_pengguna']; ?>" <?= $rental['id_pengguna'] == $row['id_pengguna'] ? 'selected' : '' ?>><?php echo $row['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Mobil:</td>
            <td>
                <select name="id_mobil" required>
                    <?php while ($row = mysqli_fetch_assoc($mobil)) : ?>
                        <option value="<?php echo $row['id_mobil']; ?>" <?= $rental['id_mobil'] == $row['id_mobil'] ? 'selected' : '' ?>><?php echo $row['judul_mobil']; ?></option>
                    <?php endwhile; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tanggal Pinjam:</td>
            <td><input type="date" name="tanggal_pinjam" value="<?php echo $rental['tanggal_pinjam']; ?>" required></td>
        </tr>
        <tr>
            <td>Tanggal Kembali:</td>
            <td><input type="date" name="tanggal_kembali" value="<?php echo $rental['tanggal_kembali']; ?>" required></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="update">Update</button></td>
        </tr>
    </table>
</form>