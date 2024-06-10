<?php
session_start();
require 'database.php';

$username = mysqli_real_escape_string($conn, $_SESSION["username"]);

$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

// Inisialisasi variabel $user_id
$user_id = null;

// Periksa apa query berhasil dieksekusi
if ($result) {
    // Periksa apa ada data yang ditemukan
    if (mysqli_num_rows($result) > 0) {
        // Ambil ID pengguna dari baris yang ditemukan
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];
    } else {
        echo "Tidak ada data pengguna yang ditemukan.";
    }
} else {
    // Tampil pesan error jika kueri gagal
    echo "Error: " . mysqli_error($conn);
}

// Query untuk mendapatkan daftar pesanan pengguna
$order_query = "SELECT * FROM orders WHERE user_id = $user_id";
$order_result = mysqli_query($conn, $order_query);

// Style CSS
echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Daftar Pesanan</title>
    <style>
        /* Style for container */
        .crud-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        /* Style for table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        /* Style for buttons */
        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            padding: 10px 20px;
            background-color: #ff6347; /* Warna merah agak oren */
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            display: inline-block;
            margin: 5px;
        }

        .button:hover {
            background-color: #d84315; /* Warna merah tua agak oren saat hover */
            transform: scale(1.05);
        }

        .button:active {
            background-color: #ff5722; /* Warna merah sedikit lebih terang saat tombol ditekan */
            transform: scale(0.95);
        }
    </style>
</head>
<body>
";

// Cek apakah ada pesanan yang ditemukan
if ($order_result && mysqli_num_rows($order_result) > 0) {
    echo "<div class='crud-container'>";
    echo "<h1>Daftar Pesanan</h1>";
    echo "<table border='1'>";
    echo "<tr><th>No</th><th>Product ID</th><th>Quantity</th><th>Total Price</th></tr>";
    $count = 1;
    while ($order_row = mysqli_fetch_assoc($order_result)) {
        echo "<tr>";
        echo "<td>" . $count++ . "</td>";
        echo "<td>" . $order_row['product_id'] . "</td>";
        echo "<td>" . $order_row['quantity'] . "</td>";
        echo "<td>" . $order_row['total_price'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='crud-container'>";
    echo "<p>Tidak ada pesanan.</p>";
    echo "</div>";
}

// Tombol Kembali
echo "<div class='button-container'>";
echo "<a href='tabel.php' class='button'>Users</a>";
echo "<a href='tabelproduk.php' class='button'>Product</a>";
echo "</div>";

// Tutup koneksi
mysqli_close($conn);

// Tutup dokumen HTML
echo "</body>
</html>";
?>
