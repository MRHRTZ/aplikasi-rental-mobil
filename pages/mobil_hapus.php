<?php
include '../koneksi.php';

if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
    $id = $_GET['id'];

    // Cek jika sedang di rental
    $check_rental = "SELECT COUNT(*) as count FROM rental WHERE id_mobil = ?";
    $check_stmt = $conn->prepare($check_rental);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo "<script>alert('Mobil tidak dapat dihapus karena sedang dirental.');</script>";
        echo "<script>window.location.href='mobil_list.php';</script>";
        exit();
    }
    $check_stmt->close();

    /// Eksekusi hapus data
    $query_mobil = "SELECT * FROM mobil WHERE id_mobil = $id";
    $mobil_query = mysqli_query($conn, $query_mobil);
    $mobil = mysqli_fetch_assoc($mobil_query);

    if ($mobil && isset($mobil['gambar'])) {
        $gambar_path = '../uploads/' . $mobil['gambar'];
        if (file_exists($gambar_path)) {
            unlink($gambar_path);
        }
    }

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