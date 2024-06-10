<?php
session_start();
require 'database.php';

// Ambil username dari sesi
$username = mysqli_real_escape_string($conn, $_SESSION["username"]);

// Query untuk mendapatkan user_id berdasarkan username
$query = "SELECT user_id FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

// Inisialisasi variabel user_id
$user_id = null;

// Periksa apakah query berhasil dieksekusi
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];
} else {
    echo "Tidak ada data pengguna yang ditemukan.";
    exit;
}

// Query untuk mendapatkan pesanan berdasarkan user_id
$order_query = "SELECT orders.order_id, products.name AS product_name, orders.quantity, orders.total_price 
                FROM orders 
                JOIN products ON orders.product_id = products.product_id 
                WHERE orders.user_id = $user_id";
$order_result = mysqli_query($conn, $order_query);

if (!$order_result) {
    echo "Error: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Belanja</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .button-container {
            margin-top: 20px;
        }

        .button {
            background-color: #FF5733; /* Warna merah */
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #E64A19;
        }

        .wa-button {
            background-color: #25D366;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            cursor: pointer;
        }

        .wa-button:hover {
            background-color: #128C7E; /* Warna hijau lebih gelap saat hover */
        }
    </style>
</head>
<body>
    <h2>Struk Belanja</h2>
    <p>Nama Pengguna: <?= htmlspecialchars($username) ?></p>
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($order_result) > 0) {
                while ($row = mysqli_fetch_assoc($order_result)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["order_id"]) . "</td>
                            <td>" . htmlspecialchars($row["product_name"]) . "</td>
                            <td>" . htmlspecialchars($row["quantity"]) . "</td>
                            <td>" . htmlspecialchars($row["total_price"]) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada pesanan ditemukan</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="button-container">
        <a href="halaman.php" class="button">Kembali ke Halaman Utama</a>
        <a href="https://wa.me/6281335535596" class="wa-button">Info Lebih Lanjut Hubungi via WhatsApp</a>
    </div>
</body>
</html>

<?php
// Tutup koneksi
mysqli_close($conn);
?>
