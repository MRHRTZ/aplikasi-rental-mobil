<?php
include '../koneksi.php';

if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
    $id = $_GET['id'];
    $id_mobil = $_GET['id_mobil'];

    $query_rental = "SELECT * FROM rental WHERE id_rental = $id";
    $rental_query = mysqli_query($conn, $query_rental);
    $rental = mysqli_fetch_assoc($rental_query);

    $query_mobil_pinjam = "SELECT * FROM mobil WHERE id_mobil = $id_mobil";
    $mobil_pinjam_query = mysqli_query($conn, $query_mobil_pinjam);
    $mobil_pinjam = mysqli_fetch_assoc($mobil_pinjam_query);

    $list_no_plat = explode(',', $mobil_pinjam['no_plat']);
    $arr_no_plat = array_merge($list_no_plat, [$rental['no_plat']]);
    $no_plat_mobil = implode(',', $arr_no_plat);

    $query_update_mobil = "UPDATE mobil SET unit=unit+1, no_plat='$no_plat_mobil' WHERE id_mobil = $id_mobil";
    mysqli_query($conn, $query_update_mobil);

    $query = "DELETE FROM rental WHERE id_rental = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus.');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.');</script>";
    }

    $stmt->close();
    $conn->close();

    header('Location: rental_list.php');
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $id_mobil = $_GET['id_mobil'];
    
        echo "<script>
        var result = confirm('Apakah Anda yakin ingin menghapus rental ini?');
        if (result) {
            window.open('rental_hapus.php?confirm=true&id=$id&id_mobil=$id_mobil', '_self');
        } else {
            window.open('rental_list.php', '_self');
        }
        </script>";
    }
}
?>