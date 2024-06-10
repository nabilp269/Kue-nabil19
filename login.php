<?php
session_start();
include "database.php";

// Jika pengguna sudah login, arahkan ke halaman utama
if(isset($_SESSION['username'])) {
    header("location: halaman.php");
    exit();
}

// Notifikasi untuk kesalahan login
$notif = "";

// Jika formulir login disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa keberadaan pengguna dalam database
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    $result = mysqli_query($conn, $query);

    // Jika data pengguna ditemukan, maka set session dan arahkan ke halaman utama
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $username;
        $_SESSION['level'] = $user['level'];
        $_SESSION['user_id'] = $user['user_id'];
        if($user['level'] == 'admin') {
            header("location: tabel.php");
        } else {
            header("location: halaman.php");
        }
    } else {
        // Jika tidak, tampilkan pesan kesalahan
        $notif = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<center>
<div class="login-container">
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="input-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="input-group">
            <button type="submit">Login</button>
        </div>
    </form>
    <div class="notification">
        <?php echo $notif; ?>
    </div>
    <a href="register.php">Register</a>
</div>
</center>
</body>
</html>
