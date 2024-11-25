<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM pengguna WHERE username = ? AND password = MD5(?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $user;
        header("Location:index.php");
    } else {
        echo "<script>alert('Username atau password tidak valid.')</script>";
    }

    $stmt->close();
    $conn->close();
}

if (isset($_GET['logout'])) {
    echo "<script>alert('Anda telah logout.'); window.location.href='login.php'</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | Aplikasi Perpustakaan</title>
    <style>
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h3 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 300px;
        }

        td {
            padding: 10px;
        }
    </style>
</head>

<body>
    <form method="post">
        <table>
            <tr>
                <td colspan="2">
                    <h3>Login Untuk Masuk Aplikasi</h3>
                </td>
            </tr>
            <tr>
                <td><label for="username">Username:</label></td>
                <td><input type="text" id="username" name="username" required></td>
            </tr>
            <tr>
                <td><label for="password">Password:</label></td>
                <td><input type="password" id="password" name="password" required></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">Login</button>
                </td>
            </tr>
        </table>
    </form>


</body>

</html>