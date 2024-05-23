<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="container">
        <div id="branding">
            <h1>Rental Mobil</h1>
        </div>  
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>
<div class="container">
<h1>Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
    <p>Selamat Datang di RentalKuy, mobil pilihan untuk kebutuhan liburan</p>
</div>
</body>
</html>
