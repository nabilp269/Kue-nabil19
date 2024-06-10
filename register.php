<?php
session_start();
include "database.php";

// sudah login, ke login
if(isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

// Notifikasi pendaftaran
$notif = "";

// Jika formulir pendaftaran disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Adjust your query to insert only if username and email are unique
$query = "INSERT INTO users (username, email, password, level) VALUES ('$username', '$email', '$password', 'user') ON DUPLICATE KEY UPDATE username = username";

    // Check if the query executed successfully
    if(mysqli_query($conn, $query)) {
    $notif = "Register berhasil, silahkan login.";
} else {
    $error_message = mysqli_error($conn);
    if(strpos($error_message, "Duplicate entry") !== false) {
        $notif = "Username or email already exists. Please choose a different one.";
    } else {
        $notif = "Error: " . $error_message;
    }
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<center>
<div class="register-container">
    <h2>Register</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="input-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="input-group">
            <button type="submit">Register</button>
        </div>
    </form>
    <div class="notification">
        <?php echo $notif; ?>
    </div>
    <a href="login.php">Login</a>
    <br><br>
    <a href="index.php">kembali</a>
    
</div>
</center>
</body>
</html>