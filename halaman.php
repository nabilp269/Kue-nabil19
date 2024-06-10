<?php
session_start();
require 'database.php';

// Mendapatkan ID pengguna dari sesi
$username = mysqli_real_escape_string($conn, $_SESSION["username"]);
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user_id = null;

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];
    } else {
        echo "Tidak ada data pengguna yang ditemukan.";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Proses pembelian produk jika metode permintaan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($user_id !== null) {
        if (isset($_POST['product_id']) && isset($_POST['quantity']) && !empty($_POST['product_id']) && !empty($_POST['quantity'])) {
            if (is_numeric($_POST['product_id'])) {
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];
                $price_query = "SELECT price FROM products WHERE product_id = $product_id";
                $price_result = mysqli_query($conn, $price_query);

                if ($price_result) {
                    if (mysqli_num_rows($price_result) > 0) {
                        $price_row = mysqli_fetch_assoc($price_result);
                        $price = $price_row['price'];
                        $total_price = $price * $quantity;
                        $order_query = "INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES ($user_id, $product_id, $quantity, $total_price)";
                        if (mysqli_query($conn, $order_query)) {
                            echo "<script>
                                alert('Pesanan berhasil ditambahkan!');
                                window.location.href = 'struk.php';
                            </script>";
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    } else {
                        echo "ID produk tidak valid.";
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "ID produk tidak valid.";
            }
        } else {
            echo "ID produk dan kuantitas diperlukan.";
        }
    } else {
        echo "ID pengguna tidak valid.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="hal.css/hala.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
        section {
            width: 100%;
            height: 100vh;
        }
        section nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
            position: fixed;
            width: 100%;
            background: rgb(255, 0, 0);
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            z-index: 1000;
        }
        section nav .logo {
            width: 13vh;
            height: 12vh;
            border-radius: 17vh;
        }
        section nav ul {
            list-style: none;
        }
        section nav ul li {
            display: inline-block;
            margin: 0 15px;
        }
        section nav ul li a {
            text-decoration: none;
            color: #000;
            font-weight: 500;
            font-size: 17px;
            transition: 0.1s;
        }
        section nav ul li a::after {
            content: '';
            width: 0;
            height: 2px;
            background: red;
            display: block;
            transition: 0.2s linear;
        }
        section nav ul li a:hover::after {
            width: 100%;
        }
        section nav ul li a:hover {
            color: greenyellow;
        }
        section .main {
            display: flex;
            align-items: center;
            justify-content: space-around;
            position: relative;
            top: 130px;
        }
        section .main .men_text h1 {
            font-size: 60px;
            position: relative;
            top: -90px;
            left: 20px;
        }
        section .main .men_text h1 span {
            margin-left: 15px;
            color: #ff2c2c;
            font-family: 'mv boli';
            line-height: 22px;
            font-size: 70px;
        }
        section .main .main_image img { 
            width: 700px;
            border-radius: 5vh;
            position: relative;
            left: 70px;
        }
        section p {
            width: 650px;
            text-align: justify;
            position: relative;
            left: 5vh;
            bottom: 120px;
            line-height: 22px;
        }
        .menu {
            width: 100%;
            padding: 20vh 0;
        }
        .menu h1 {
            font-size: 15vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .menu h1 span {
            color: #f92727;
            margin-left: 15px;
            font-family: 'mv boli';
        }
        .menu h1 span::after {
            content: '';
            width: 100%;
            height: 3px;
            background: #fa4141;
            display: block;
            position: relative;
            bottom: 20px;
        }
        .menu .menu_box {
            width: 95%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 15px;
        }
        .menu .menu_box .menu_card {
            width: 325px;
            border-radius: 5vh;
            background-color: rgb(245, 34, 34);
            height: 480px;
            padding-top: 10px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        .menu .menu_box .menu_card .menu_image {
            width: 300px;
            border-radius: 5vh;
            height: 245px;
            margin: 0 auto;
            overflow: hidden;
        }
        .menu .menu_box .menu_card .menu_image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: 0.3s;
        }
        .menu .menu_box .menu_card .menu_image:hover img {
            transform: scale(1.5);
        }
        .menu .menu_box .menu_card .menu_info h2 {
            width: 60%;
            text-align: center;
            margin: 10px auto 10px auto;
            font-size: 25px;
            color: #000000;
        }
        .menu .menu_box .menu_card .menu_info h3 {
            text-align: center;
            margin-top: 10px;
        }
        .menu .menu_box .menu_card .menu_info input {
            width: 70%;
            margin-top: 20px;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        

    </style>
    <title>Kue kering</title>
</head>
<body>
    <section id="Home">
        <nav>
            <a href=""><img src="images.jpeg" alt="" class="logo"></a>
            <h3>Selamat datang <?= $_SESSION["username"] ?> di...</h3>
            <ul>
                <li><a href="tentang.html">About</a></li>
                <li><a href="#Menu">Menu</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="main">
            <div class="men_text">
                <h1>Home Made by <span> <br> ERiAND COOKIES</span></h1>
            </div>
            <div class="main_image">
                <img src="WhatsApp Image 2024-02-20 at 18.03.13.jpg">
            </div>
        </div>
        <p>
        Eriand cookies berdiri sejak tahun 2001, 🥳ERIAND COOKIES🥳 Hai sobat.... ERIAND COOKIES hadir lagi nich... yuk kepoin cookies yang ada di kami. Kami selalu hadir dengan cookies yang selalu fresh from the oven, karena kami produksi sesuai orderan atau dengan sistem PO , kami menyediakan berbagai macam cookies buat lebaran atau untuk menemani kalian minum teh looo.. Apa lagi bentar lagi puasa dan lebaran...bisa buat takjil, hantaran ataupun suguhan lebaran. Kalian pasti akan ketagihan kalau udah pernah order di ERIAND COOKIES . Yuk, kepoin ....coba dulu ya ....biar gak penasaran.. Ini kue keringnya meskipun murah, tapi kualitasnya nomor satu . apalagi nastar nya.. yang lembut dan lumer di mulut Yuukk...buruan di order😊😊😊😊
        </p>
    </section>
    <section class="menu" id="Menu">
        <h1>Our <span>Product</span></h1>
        <div class="menu_box">
            <?php
            require 'database.php';

            $query = "SELECT * FROM products";
            $result = mysqli_query($conn, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="menu_card">';
                        echo '<div class="menu_image">';
                        echo '<img src="' . $row["image"] . '" alt="' . $row["name"] . '">';
                        echo '</div>';
                        echo '<div class="menu_info">';
                        echo '<h2>' . $row["name"] . '</h2>';
                        echo '<h3>Rp ' . number_format($row["price"], 0, ',', '.') . '</h3>';
                        echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="POST">';
                        echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
                        echo '<input type="number" name="quantity" placeholder="Quantity" required>';
                        echo '<button type="submit">Buy</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No products available.";
                }
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_close($conn);
            ?>
        </div>
    </section>
    
</body>
</html>
