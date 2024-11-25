<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM mobil WHERE id_mobil = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul_mobil = $_POST['judul_mobil'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $jumlah_mobil = $_POST['jumlah_mobil'];

    $query = "UPDATE mobil SET judul_mobil=?, pengarang=?, penerbit=?, tahun_terbit=?, jumlah_mobil=? WHERE id_mobil=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssssii', $judul_mobil, $pengarang, $penerbit, $tahun_terbit, $jumlah_mobil, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: mobil_list.php');
    } else {
        echo "<script>alert('Gagal update data: " . mysqli_error($conn) . "')</script>";
    }
    mysqli_stmt_close($stmt);
}
?>

<h2>Edit Mobil</h2>
<form method="POST" action="" autocomplete="off">
    <input type="hidden" name="id" value="<?php echo $user['id_mobil']; ?>">
    <table>
        <tr>
            <td>Judul Mobil:</td>
            <td><input type="text" name="judul_mobil" value="<?php echo $user['judul_mobil']; ?>" required></td>
        </tr>
        <tr>
            <td>Pengarang:</td>
            <td><input type="text" name="pengarang" value="<?php echo $user['pengarang']; ?>" required></td>
        </tr>
        <tr>
            <td>Penerbit:</td>
            <td><input type="text" name="penerbit" value="<?php echo $user['penerbit']; ?>" required></td>
        </tr>
        <tr>
            <td>Tahun Terbit</td>
            <td><input type="number" name="tahun_terbit" value="<?php echo $user['tahun_terbit']; ?>" required></td>
        </tr>
        <tr>
            <td>Jumlah Mobil:</td>
            <td><input type="number" name="jumlah_mobil" value="<?php echo $user['jumlah_mobil']; ?>" required></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="update">Update</button></td>
        </tr>
    </table>
</form>