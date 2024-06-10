<?php
// Include database connection
include "database.php";

// Check if form is submitted for updating product
if (isset($_POST['update'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Check if a new image is uploaded
    if ($image) {
        // Target directory
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Select file type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Valid file extensions
        $extensions_arr = array("jpg", "jpeg", "png", "gif");

        // Check extension
        if (in_array($imageFileType, $extensions_arr)) {
            // Upload file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Update product with new image
                $update_query = "UPDATE products SET name='$name', price='$price', image='$target_file' WHERE product_id='$product_id'";
                mysqli_query($conn, $update_query);
            }
        }
    } else {
        // Update product without changing image
        $update_query = "UPDATE products SET name='$name', price='$price' WHERE product_id='$product_id'";
        mysqli_query($conn, $update_query);
    }

    // Close database connection
    mysqli_close($conn);

    // Redirect to product page
    header("Location: product_page.php");
}

// Check if product_id is set in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product data
    $product_query = "SELECT * FROM products WHERE product_id='$product_id'";
    $product_result = mysqli_query($conn, $product_query);

    // Check if product data is found
    if ($product_result && mysqli_num_rows($product_result) == 1) {
        $product = mysqli_fetch_assoc($product_result);
    } else {
        // Redirect to product page if no product is found
        header("Location: product_page.php");
    }
} else {
    // Redirect to product page if product_id is not set
    header("Location: tabelproduk.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <style>
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
    <h2>Update Product</h2>
    <div class="form-container">
        <form action="update_product.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <input type="text" name="name" value="<?php echo $product['name']; ?>" placeholder="Product Name" required>
            <input type="file" name="image" accept="image/*">
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" placeholder="Price" required>
            <button type="submit" name="update">Update Product</button>
        </form>
        <a href="tabelproduk.php" class="button">Kembali</a>
    </div>
</body>
</html>
