<?php
include '../koneksi.php';

if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
    $id = $_GET['id'];

    $query = "DELETE FROM mobil WHERE id_mobil = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus.');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.');</script>";
    }

    $stmt->close();
    $conn->close();

    header('Location: mobil_list.php');
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        echo "<script>
        var result = confirm('Apakah Anda yakin ingin menghapus mobil ini?');
        if (result) {
            window.open('mobil_hapus.php?confirm=true&id=$id', '_self');
        } else {
            window.open('mobil_list.php', '_self');
        }
        </script>";
    }
}
?>