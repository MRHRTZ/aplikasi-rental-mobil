<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM pengguna WHERE id_pengguna = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $peran = $_POST['peran'];
    $no_telp = $_POST['no_telp'];

    if (empty($password)) {
        $query = "UPDATE pengguna SET nama=?, username=?, alamat=?, peran=?, no_telp=? WHERE id_pengguna=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $nama, $username, $alamat, $peran, $no_telp, $id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: pengguna_list.php');
        } else {
            echo "<script>alert('Gagal update data: " . mysqli_error($conn) . "')</script>";
        }
        mysqli_stmt_close($stmt);
        exit;
    } else {
        $password = md5($password);
        $query = "UPDATE pengguna SET nama=?, username=?, password=?, alamat=?, peran=?, no_telp=? WHERE id_pengguna=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssssi", $nama, $username, $password, $alamat, $peran, $no_telp, $id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: pengguna_list.php');
        } else {
            echo "<script>alert('Gagal update data: " . mysqli_error($conn) . "')</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<h2>Edit Pengguna</h2>
<form method="POST" action="" autocomplete="off">
    <input type="hidden" name="id" value="<?php echo $user['id_pengguna']; ?>">
    <table>
        <tr>
            <td>Nama:</td>
            <td><input type="text" name="nama" value="<?php echo $user['nama']; ?>" required></td>
        </tr>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="username" value="<?php echo $user['username']; ?>" required></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" placeholder="Masukan untuk mengubah password" value="" autocomplete="new-password"></td>
        </tr>
        <tr>
            <td>Alamat:</td>
            <td><input type="text" name="alamat" value="<?php echo $user['alamat']; ?>" required></td>
        </tr>
        <tr>
            <td>Peran:</td>
            <td>
                <select name="peran" required>
                    <option value="petugas" <?php echo ($user['peran'] == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                    <option value="anggota" <?php echo ($user['peran'] == 'anggota') ? 'selected' : ''; ?>>Anggota</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Telepon:</td>
            <td><input type="number" name="no_telp" value="<?php echo $user['no_telp']; ?>" required></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="update">Update</button></td>
        </tr>
    </table>
</form>