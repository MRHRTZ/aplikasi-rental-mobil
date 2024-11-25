<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location:login.php');
    }
?>
<head>
    <title>Aplikasi Rental Mobil</title>
</head>
<frameset rows="15%,*">
    <frame src="master/navbar.php">
    <frameset cols="13%,*">
        <frame src="master/sidebar.php">
        <frame src="pages/dashboard.php" name="content">
    </frameset>
</frameset>