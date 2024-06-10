<?php
session_start();
include "database.php";

// Notifikasi pesanan
$notif = "";

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Jika formulir pemesanan disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Mengambil harga produk
    $price_query = "SELECT price FROM product WHERE product_id = '$product_id'";
    $price_result = mysqli_query($conn, $price_query);
    if ($price_result && mysqli_num_rows($price_result) > 0) {
        $price_row = mysqli_fetch_assoc($price_result);
        $price = $price_row['price'];
        $total_price = $price * $quantity;

        // Menambahkan pesanan ke database
        $order_query = "INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES ('$user_id', '$product_id', '$quantity', '$total_price')";
        if (mysqli_query($conn, $order_query)) {
            $notif = "Pesanan berhasil.";
        } else {
            $notif = "Error: " . mysqli_error($conn);
        }
    } else {
        $notif = "Produk tidak ditemukan.";
    }
}

// Mengambil daftar produk untuk formulir pemesanan
$product_query = "SELECT * FROM product";
$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<center>
<div class="order-container">
    <h2>Place an Order</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="input-group">
            <label for="product_id">Product:</label>
            <select id="product_id" name="product_id" required>
                <?php
                if ($product_result && mysqli_num_rows($product_result) > 0) {
                    while ($product_row = mysqli_fetch_assoc($product_result)) {
                        echo "<option value='" . $product_row['product_id'] . "'>" . $product_row['product_name'] . " - " . $product_row['price'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="input-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required min="1">
        </div>
        <div class="input-group">
            <button type="submit">Order</button>
        </div>
    </form>
    <div class="notification">
        <?php echo $notif; ?>
    </div>
    <a href="index.php">Kembali</a>
</div>
</center>
</body>
</html>
