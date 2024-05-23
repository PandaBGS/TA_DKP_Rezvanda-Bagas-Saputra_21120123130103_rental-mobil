<?php
session_start();

$loginMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gantilah 'admin' dan 'password' dengan username dan password yang diinginkan
    if ($username == 'Vanda' && $password == 'admin123') {
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
        header('Location: dashboard.php');
    } else {
        $loginMessage = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental Mobil</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .imagecontainer {
            display: block;
            justify-content: center;
        }
        
        .imagecontainer img {
            width: 100%;
            height: auto;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url(foto);
            color: #f9f9f7;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 30%;
            margin: auto;
            overflow: hidden;
            padding: 30px;
            background: #f9f9f7;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            border-bottom: #e8491d 3px solid;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #35424a;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            color: #35424a;
        }

        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #dddddd;
            border-radius: 5px;
            background: #f9f9f9;
        }

        form button {
            display: inline-block;
            background: #35424a;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s ease;
        }

        form button:hover {
            background: #e8491d;
        }

        .alert {
            background: #e8491d;
            color: #ffffff;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert strong {
            font-weight: bold;
        }

    </style>
</head>
<body>
<div class="container">
    <?php if ($loginMessage): ?>
        <div class="alert">
            <?= $loginMessage ?>
        </div>
    <?php endif; ?>
    <div class="imagecontainer">
        <img src="RentalKuy.jpg">
    </div>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
