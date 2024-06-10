<?php
// Include database connection
include "database.php";

// Check if product_id is set in the URL
if(isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];

    // Begin transaction
    mysqli_begin_transaction($conn);

    try {
        // Delete orders associated with the product
        $delete_orders_query = "DELETE FROM orders WHERE product_id = $product_id";
        mysqli_query($conn, $delete_orders_query);

        // Delete the product
        $delete_product_query = "DELETE FROM products WHERE product_id = $product_id";
        mysqli_query($conn, $delete_product_query);

        // Commit transaction
        mysqli_commit($conn);

        // Product and orders deleted successfully
        echo "<script>alert('Product and associated orders deleted successfully');</script>";
        // Redirect to product page after deletion
        echo "<script>window.location.href = 'product_page.php';</script>";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        mysqli_rollback($conn);
        // Failed to delete product and/or orders
        echo "<script>alert('Failed to delete product and/or associated orders');</script>";
        // Redirect back to the product page
        echo "<script>window.location.href = 'product_page.php';</script>";
    }
} else {
    // If product_id is not set in the URL, redirect back to the product page
    echo "<script>window.location.href = 'product_page.php';</script>";
}

// Close database connection
mysqli_close($conn);
?>
