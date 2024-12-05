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

    $data_mobil = [];
    while ($row = mysqli_fetch_assoc($mobil)) {
        if ($row['id_mobil'] == $rental['id_mobil']) {
            $row['no_plat'] = array_merge(explode(',', $row['no_plat']), [$rental['no_plat']]);
        } else {
            $row['no_plat'] = explode(',', $row['no_plat']);
        }
        $data_mobil[] = $row;
    }

    $index_selected_mobil = array_search($rental['id_mobil'], array_column($data_mobil, 'id_mobil'));

    $data_mobil_js = json_encode($data_mobil);
    echo "<script>
        var dataMobil = $data_mobil_js;
    </script>";
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $id_pengguna = $_POST['id_pengguna'];
    $id_mobil = $_POST['id_mobil'];
    $no_plat = $_POST['no_plat'];
    $tanggal_rental = $_POST['tanggal_rental'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $query_pinjam = "SELECT * FROM rental WHERE id_rental = $id";
    $pinjam_query = mysqli_query($conn, $query_pinjam);
    $pinjam = mysqli_fetch_assoc($pinjam_query);

    $id_mobil_lama = $pinjam['id_mobil'];
    $id_mobil_baru = $id_mobil;

    $query_mobil_lama = "SELECT * FROM mobil WHERE id_mobil = $id_mobil_lama";
    $mobil_lama_query = mysqli_query($conn, $query_mobil_lama);
    $mobil_lama = mysqli_fetch_assoc($mobil_lama_query);

    $query_mobil_baru = "SELECT * FROM mobil WHERE id_mobil = $id_mobil_baru";
    $mobil_baru_query = mysqli_query($conn, $query_mobil_baru);
    $mobil_baru = mysqli_fetch_assoc($mobil_baru_query);

    // Jika pinjam beda mobil
    if ($id_mobil_lama != $id_mobil_baru) {
        $list_no_plat_lama = explode(',', $mobil_lama['no_plat']);
        $arr_no_plat_lama = array_merge($list_no_plat_lama, [$pinjam['no_plat']]);
        $no_plat_mobil_lama = implode(',', $arr_no_plat_lama);

        $query_update_mobil_lama = "UPDATE mobil SET unit=unit+1, no_plat='$no_plat_mobil_lama' WHERE id_mobil = $id_mobil_lama";
        mysqli_query($conn, $query_update_mobil_lama);

        $list_no_plat_baru = explode(',', $mobil_baru['no_plat']);
        $arr_no_plat_baru = array_diff($list_no_plat_baru, [$no_plat]);
        $no_plat_mobil_baru = implode(',', $arr_no_plat_baru);

        $query_update_mobil_baru = "UPDATE mobil SET unit=unit-1, no_plat='$no_plat_mobil_baru' WHERE id_mobil = $id_mobil_baru";
        mysqli_query($conn, $query_update_mobil_baru);
    }

    $query = "UPDATE rental SET id_pengguna=?, id_mobil=?, no_plat=?, tanggal_rental=?, tanggal_kembali=? WHERE id_rental=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iisssi', $id_pengguna, $id_mobil, $no_plat, $tanggal_rental, $tanggal_kembali, $id);

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
                    <?php foreach ($data_mobil as $row) : ?>
                        <option value="<?php echo $row['id_mobil']; ?>" <?= $rental['id_mobil'] == $row['id_mobil'] ? 'selected' : '' ?>><?php echo $row['nama']; ?> - <?php echo $row['merk']; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>No Plat:</td>
            <td>
                <select name="no_plat" required>
                    <?php foreach ($data_mobil[$index_selected_mobil]['no_plat'] as $row) : ?>
                        <option value="<?php echo $row; ?>" <?= $rental['no_plat'] == $row ? 'selected' : '' ?>><?php echo $row; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tanggal Pinjam:</td>
            <td><input type="date" name="tanggal_rental" value="<?php echo $rental['tanggal_rental']; ?>" required></td>
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

<script>
    document.querySelector('select[name="id_mobil"]').addEventListener('change', function() {
        var idMobil = this.value;
        var noPlatSelect = document.querySelector('select[name="no_plat"]');
        noPlatSelect.innerHTML = '';

        var selectedMobil = dataMobil.find(mobil => mobil.id_mobil == idMobil);
        if (selectedMobil) {
            console.log(selectedMobil);
            selectedMobil.no_plat.forEach(function(noPlat) {
                var option = document.createElement('option');
                option.value = noPlat;
                option.textContent = noPlat;
                noPlatSelect.appendChild(option);
            });
        }
    });
</script>