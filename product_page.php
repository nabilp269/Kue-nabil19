<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <style>
        /* CSS untuk mengatur tata letak tabel */
        .table-container {
            display: flex;
            flex-wrap: wrap;
        }
        .table-container table {
            margin-right: 10px; /* Mengurangi margin agar lebih kecil */
            width: 45%; /* Setengah lebar */
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

        .table-container table img {
            max-width: 100%; 
            height: auto; 
            display: block; 
            width: 50px; 
        }

        .button-container {
            margin-top: 20px;
        }

        .button {
            background-color: #FF5733; 
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

        .form-container {
            margin-top: 20px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            width: 300px;
        }

        .form-container form input, .form-container form button {
            margin-bottom: 10px;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Product List</h2>
    <div class="table-container">
   
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
     
                include "database.php";

        
                $product_query = "SELECT * FROM products";
                $product_result = mysqli_query($conn, $product_query);

                if ($product_result) {
             
                    while($row = mysqli_fetch_assoc($product_result)) {
                        echo "<tr>
                                <td>".$row["product_id"]."</td>
                                <td>".$row["name"]."</td>
                                <td><img src='".$row["image"]."' alt='Product Image'></td>
                                <td>".$row["price"]."</td>
                                <td>
                                    <a class='button' href='update_product.php?product_id=".$row["product_id"]."&name=".$row["name"]."&image=".$row["image"]."&price=".$row["price"]."'>Edit</a>
                                    <a class='button' href='delete_product.php?product_id=".$row["product_id"]."' onclick='return confirm(\"Apakah anda yakin ingin menghapus product tersebut?\")'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No products found</td></tr>";
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>

    <div class="form-container">
        <h2>Add New Product</h2>
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="file" name="image" accept="image/*" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <button type="submit">Add Product</button>
        </form>
    </div>

    <div class="button-container">
        <a href="tabel.php" class="button">User</a>
    </div>
    <div class="button-container">
        <a href="orders.php" class="button">Order</a>
    </div>
</body>
</html>
