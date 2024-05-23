<?php
include 'autoload.php';
session_start();
include_once 'Classes/Car.php';
include_once 'Classes/Customer.php';
include_once 'Classes/Rental.php';

function isLoggedIn() {
    return isset($_SESSION['username']);
}
// Periksa apakah pengguna sudah login, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

$addCustomerMessage = ''; // Variabel untuk menyimpan pesan konfirmasi

// Autentikasi pengguna
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Simpan pelanggan ke dalam sesi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_customer'])) {
    $customerName = $_POST['customer_name'];
    $customerId = count($_SESSION['customers']) + 1;
    $customer = new Customer($customerId, $customerName);
    $_SESSION['customers'][] = $customer;
    $addCustomerMessage = "Pelanggan bernama <strong>$customerName</strong> berhasil ditambahkan.";
}

if (!isset($_SESSION['returnHistory'])) {
    $_SESSION['returnHistory'] = [];
}
    if (isset($_POST['return'])) {
        if (!empty($_SESSION['rentals'])) {
            $rental = array_pop($_SESSION['rentals']);
            $rental->car->returnCar();
            $_SESSION['returnHistory'][] = $rental; 
        }
    }
            // Menyimpan rental yang dikembalikan ke dalam riwayat

// Inisialisasi sesi untuk mobil dan pelanggan
if (!isset($_SESSION['cars'])) {
    $_SESSION['cars'] = [
        new Car(1, 'Toyota Avanza', 300000, true,'/Classes/ToyotaAvanza.png'),
        new Car(2, 'Honda Jazz', 350000, true, '/Classes/HondaJazz.png'),
        new Car(3, 'Suzuki Ertiga', 320000, true,'/Classes/SuzukiErtiga.png'),
        new Car(4, 'Honda HR-V', 400000, true, '/Classes/HondaHRV.png')
    ];
}

if (!isset($_SESSION['customers'])) {
    $_SESSION['customers'] = [];
}

$cars = $_SESSION['cars'];
$customers = $_SESSION['customers'];

if (!isset($_SESSION['rentals'])) {
    $_SESSION['rentals'] = [];
}

if (!isset($_SESSION['returnQueue'])) {
    $_SESSION['returnQueue'] = [];
}

// Kosongkan antrian pengembalian setiap kali halaman di-refresh
$_SESSION['returnQueue'] = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['rent'])) {
        $carId = $_POST['car'] ?? null;
        $customerId = $_POST['customer'] ?? null;
        $days = $_POST['days'] ?? null;

        if ($carId && $customerId && $days) {
            $carIndex = $carId - 1;
            $car = $cars[$carIndex];
            $customer = $customers[$customerId - 1];

            if ($car->available) {
                $rental = new Rental($car, $customer, $days);
                $car->rent();
                $_SESSION['rentals'][] = $rental;
            }
        }
    }

    if (isset($_POST['return'])) {
        if (!empty($_SESSION['rentals'])) {
            $rental = array_pop($_SESSION['rentals']);
            $rental->car->returnCar();
            $_SESSION['returnQueue'][] = $rental;
        }
    }
}

$rentals = $_SESSION['rentals'];
$returnQueue = $_SESSION['returnQueue'];
$returnHistory = $_SESSION['returnHistory'];
?>

<?php
// Kode PHP tetap sama

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Mobil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="container">
        <div id="branding">
            <img src="RentalKuy.jpg">
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
    <?php if ($addCustomerMessage): ?>
        <div class="alert">
            <?= $addCustomerMessage ?>
        </div>
    <?php endif; ?>

    <h2>Tambah Pelanggan</h2>
    <form method="post" action="index.php">
        <label for="customer_name">Nama Pelanggan:</label>
        <input type="text" name="customer_name" id="customer_name" required><br>
        <button type="submit" name="add_customer">Tambah Pelanggan</button>
    </form>

    <h2>Sewa Mobil</h2>
    <form method="post" action="index.php">
        <label for="car">Pilih Mobil:</label>
        <select name="car" id="car">
            <?php foreach ($cars as $car): ?>
                <?php if ($car->available): ?>
                    <option value="<?= $car->id ?>"><?= $car->model ?> - Rp. <?= number_format($car->pricePerDay) ?>/hari</option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select><br>

        <label for="customer">Pilih Pelanggan:</label>
        <select name="customer" id="customer">
            <?php foreach ($customers as $customer): ?>
                <option value="<?= $customer->id ?>"><?= $customer->name ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="days">Jumlah Hari:</label>
        <input type="number" name="days" id="days" required><br>

        <button type="submit" name="rent">Sewa Mobil</button>
    </form>
    
    <h2>Daftar Mobil</h2>
    <div class="car-list">
        <?php foreach ($cars as $car): ?>
            <div class="car-card">
            <img src="<?= ".$car->image " ?>" alt="<?= $car->model ?>">
                <h3><?= $car->model ?></h3>
                <p>Harga per hari: <span class="price">Rp. <?= number_format($car->pricePerDay) ?></span></p>
                <p>Status: <?= $car->available ? 'Tersedia' : 'Disewa' ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    
    
    <h2>Riwayat Pengembalian</h2>
    <ul>
        <?php 
        if (!empty($returnHistory)) {
            foreach ($returnHistory as $rental) {
                echo "<li>{$rental->customer->name} mengembalikan {$rental->car->model} setelah {$rental->days} hari.</li>";
            }
        } else {
            echo "<li>Tidak ada riwayat pengembalian.</li>";
        }
        ?>
    </ul>
    </ul>
    <form method="post" action="index.php">
        <button type="submit" name="return">Kembalikan Mobil</button>
    </form>

    <h2>Rental Aktif</h2>
    <ul>
        <?php 
        // Memeriksa apakah stack rental tidak kosong
        if (!empty($rentals)) {
            // Iterasi setiap rental dalam array dan menampilkan informasi rental
            foreach ($rentals as $rental) {
                echo "<li>{$rental->customer->name} menyewa {$rental->car->model} selama {$rental->days} hari. Total: Rp. " . number_format($rental->calculateTotal()) . "</li>";
            }
        } else {
            echo "<li>Tidak ada rental aktif.</li>";
        }
