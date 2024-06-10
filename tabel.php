<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            padding: 10px 20px;
            background-color: #f4511e; /* Reddish-orange color */
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
            background-color: #e64512; /* Darker reddish-orange */
            transform: scale(1.05);
        }

        .button:active {
            background-color: #d53d10; /* Even darker reddish-orange */
            transform: scale(0.95);
        }
    </style>
</head>
<body>
<center>
<div class="crud-container">
    <h3>User List</h3>
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Level</th>
            <th>Action</th>
        </tr>
        <?php
        session_start();
        include "database.php";

        $notif = "";

        // Fungsi untuk membersihkan data input
        function clean_input($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

        // Jika formulir disubmit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = isset($_POST['action']) ? $_POST['action'] : '';
            $user_id = isset($_POST['user_id']) ? clean_input($_POST['user_id']) : 0;

            if ($action == "update") {
                $username = isset($_POST['username']) ? clean_input($_POST['username']) : '';
                $email = isset($_POST['email']) ? clean_input($_POST['email']) : '';
                $password = isset($_POST['password']) ? password_hash(clean_input($_POST['password']), PASSWORD_DEFAULT) : '';
                $level = isset($_POST['level']) ? clean_input($_POST['level']) : '';

                // Query untuk memperbarui pengguna
                $query = "UPDATE users SET username='$username', email='$email', password='$password', level='$level' WHERE user_id='$user_id'";
                if (mysqli_query($conn, $query)) {
                    $notif = "Pengguna berhasil diperbarui.";
                } else {
                    $notif = "Error: " . mysqli_error($conn);
                }
            } elseif ($action == "delete") {
                // Query untuk menghapus pengguna
                $query = "DELETE FROM users WHERE user_id='$user_id'";
                if (mysqli_query($conn, $query)) {
                    $notif = "Pengguna berhasil dihapus.";
                } else {
                    $notif = "Error: " . mysqli_error($conn);
                }
            } elseif ($action == "add") {
                $new_username = isset($_POST['new_username']) ? clean_input($_POST['new_username']) : '';
                $new_email = isset($_POST['new_email']) ? clean_input($_POST['new_email']) : '';
                $new_password = isset($_POST['new_password']) ? password_hash(clean_input($_POST['new_password']), PASSWORD_DEFAULT) : '';
                $new_level = isset($_POST['new_level']) ? clean_input($_POST['new_level']) : '';

                // Query untuk menambahkan pengguna baru
                $query = "INSERT INTO users (username, email, password, level) VALUES ('$new_username', '$new_email', '$new_password', '$new_level')";
                if (mysqli_query($conn, $query)) {
                    $notif = "Pengguna baru berhasil ditambahkan.";
                } else {
                    $notif = "Error: " . mysqli_error($conn);
                }
            }
        }

        // Mengambil daftar pengguna
        $user_query = "SELECT * FROM users";
        $user_result = mysqli_query($conn, $user_query);

        if ($user_result && mysqli_num_rows($user_result) > 0) {
            while ($user_row = mysqli_fetch_assoc($user_result)) {
                echo "<tr>";
                echo "<td>" . $user_row['username'] . "</td>";
                echo "<td>" . $user_row['email'] . "</td>";
                echo "<td>" . $user_row['level'] . "</td>";
                echo "<td>
                        <button onclick=\"editUser('" . $user_row['user_id'] . "', '" . $user_row['username'] . "', '" . $user_row['email'] . "', '" . $user_row['level'] . "')\">Edit</button>
                        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' style='display:inline;'>
                            <input type='hidden' name='user_id' value='" . $user_row['user_id'] . "'>
                            <input type='hidden' name='action' value='delete'>
                            <button type='submit'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
    <div class="notification">
        <?php echo $notif; ?>
    </div>
    <div id="editForm" style="display: none;">
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
            <option value="user">User</option>
                <option value="admin">Admin</option>
               
            </select><br>
            <input type="hidden" name="action" value="update">
            <button type="submit">Update</button>
        </form>
    </div>
    
    <div id="addUserForm">
        <h3>Add User</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="new_username">Username:</label>
            <input type="text" id="new_username" name="new_username" required><br>
            <label for="new_email">Email:</label>
            <input type="email" id="new_email" name="new_email" required><br>
            <label for="new_password">Password:</label>
            <input type="password" id="new_password" name="new_password" required><br>
            <label for="new_level">Level:</label>
            <select id="new_level" name="new_level" required>
            <option value="user">User</option>
                <option value="admin">Admin</option>
                
            </select><br>
            <input type="hidden" name="action" value="add">
            <button type="submit">Add User</button>
        </form>
    </div>
    <div class="button-container">
        <a href="tabelproduk.php" class="button">Product</a>
    </div>
    <div class="button-container">
        <a href="orders.php" class="button">Order</a>
    </div>
    <div class="button-container">
        <a href="halaman.php" class="button">Keluar</a>
    </div>
</div>
</center>
<script>
function editUser(user_id, username, email, level) {
    document.getElementById('user_id').value = user_id;
    document.getElementById('username').value = username;
    document.getElementById('email').value = email;
    document.getElementById('level').value = level;
    document.getElementById('password').value = '';
    document.getElementById('editForm').style.display = 'block';
}
</script>
</body>
</html>
