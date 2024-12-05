<?php
include '../koneksi.php';

$query_pengguna = "SELECT * FROM pengguna WHERE peran = 'anggota'";
$pengguna = mysqli_query($conn, $query_pengguna);

$query_mobil = "SELECT * FROM mobil";
$mobil = mysqli_query($conn, $query_mobil);

$data_mobil = [];
while ($row = mysqli_fetch_assoc($mobil)) {
    $row['no_plat'] = explode(',', $row['no_plat']);
    $data_mobil[] = $row;
}

$data_mobil_js = json_encode($data_mobil);
echo "<script>
    var dataMobil = $data_mobil_js;
</script>";

if (isset($_POST['simpan'])) {
    $id_pengguna = $_POST['id_pengguna'];
    $id_mobil = $_POST['id_mobil'];
    $tanggal_rental = $_POST['tanggal_rental'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $no_plat = $_POST['no_plat'];

    $query_mobil_pinjam = "SELECT * FROM mobil WHERE id_mobil = $id_mobil";
    $mobil_pinjam_query = mysqli_query($conn, $query_mobil_pinjam);
    $mobil_pinjam = mysqli_fetch_assoc($mobil_pinjam_query);

    if ($mobil_pinjam['unit'] == 0) {
        echo "<script>alert('Unit mobil habis.'); window.location.href='rental_list.php'</script>";
        exit;
    } else {
        // pisahkan no plat yang dipinjam
        $list_no_plat = explode(',', $mobil_pinjam['no_plat']);
        // hapus no plat yang dipilih
        $arr_no_plat = array_diff($list_no_plat, [$no_plat]);
        // gabungkan kembali no plat yang tersisa
        $no_plat_mobil = implode(',', $arr_no_plat);

        $query_update_mobil = "UPDATE mobil SET unit=unit-1, no_plat='$no_plat_mobil' WHERE id_mobil = $id_mobil";
        mysqli_query($conn, $query_update_mobil);
    }


    $query = "INSERT INTO rental (id_pengguna, id_mobil, no_plat, tanggal_rental, tanggal_kembali) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iisss", $id_pengguna, $id_mobil, $no_plat, $tanggal_rental, $tanggal_kembali);

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
                    <?php foreach ($data_mobil as $row) : ?>
                        <option value="<?php echo $row['id_mobil']; ?>"><?php echo $row['nama']; ?> - <?php echo $row['merk']; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>No Plat:</td>
            <td>
                <select name="no_plat" required>
                    <?php foreach ($data_mobil[0]['no_plat'] as $row) : ?>
                        <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
                    <?php endforeach; ?>
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

<script>
    document.querySelector('select[name="id_mobil"]').addEventListener('change', function() {
        var idMobil = this.value;
        var noPlatSelect = document.querySelector('select[name="no_plat"]');
        noPlatSelect.innerHTML = '';

        var selectedMobil = dataMobil.find(mobil => mobil.id_mobil == idMobil);
        if (selectedMobil) {
            selectedMobil.no_plat.forEach(function(noPlat) {
                var option = document.createElement('option');
                option.value = noPlat;
                option.textContent = noPlat;
                noPlatSelect.appendChild(option);
            });
        }
    });
</script>