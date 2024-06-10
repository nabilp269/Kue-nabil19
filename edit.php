<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>

<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "aayo"; 

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user data based on ID
    $sql = "SELECT * FROM users WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row["username"];
        $email = $row["email"];
        $password = $row["password"];
        // Add more fields as needed
    } else {
        echo "User not found";
        exit;
    }
} else {
    echo "Invalid request";
    exit;
}

// Update user data
if(isset($_POST['update'])) {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];
    // Get other fields similarly

    $sql = "UPDATE users SET username=?, email=?, password=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $newUsername, $newEmail, $newPassword, $id);
    if ($stmt->execute()) {
        echo "Record updated successfully";
        // Redirect back to main page after update
        header("Location: tabel.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<h2>Edit User</h2>

<div id="editUserForm" style="display: none;">
    <h3>Edit User</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" id="user_id" name="user_id">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br>
        <label for="level">Level:</label>
        <select id="level" name="level">
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select><br>
        <input type="hidden" name="action" value="update">
        <button type="submit">Update</button>
    </form>
</div>



<a href="tabelproduk.php" class="button">Tabel produk</a>
<a href="halaman.php" class="button">Kembali</a>

</body>
</html>
