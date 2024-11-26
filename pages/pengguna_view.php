<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM pengguna WHERE id_pengguna = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
}
?>

<h2>Edit Pengguna</h2>
<form method="POST" action="" autocomplete="off">
    <input type="hidden" name="id" value="<?php echo $user['id_pengguna']; ?>">
    <table>
        <tr>
            <td>Nama:</td>
            <td><input type="text" name="nama" value="<?php echo $user['nama']; ?>" disabled></td>
        </tr>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="username" value="<?php echo $user['username']; ?>" disabled></td>
        </tr>
        <tr>
            <td>Alamat:</td>
            <td><input type="text" name="alamat" value="<?php echo $user['alamat']; ?>" disabled></td>
        </tr>
        <tr>
            <td>Peran:</td>
            <td>
                <select name="peran" disabled>
                    <option value="petugas" <?php echo ($user['peran'] == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                    <option value="anggota" <?php echo ($user['peran'] == 'anggota') ? 'selected' : ''; ?>>Anggota</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Telepon:</td>
            <td><input type="number" name="no_telp" value="<?php echo $user['no_telp']; ?>" disabled></td>
        </tr>
    </table>
</form>