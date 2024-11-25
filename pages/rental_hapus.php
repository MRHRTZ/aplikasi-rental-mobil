<?php
include '../koneksi.php';

if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
    $id = $_GET['id'];

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