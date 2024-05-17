<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzaorder";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST Data from Form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $total_price = $delivery_fee; // Initialize total price with delivery fee
        $order_summary = "";
    
        foreach ($pizzas as $type => $price) {
            if (isset($_POST["quantity_$type"]) && $_POST["quantity_$type"] > 0) {
                $quantity = (int)$_POST["quantity_$type"]; // Convert to integer for security
                $pizza_price = $price * $quantity;
                $total_price += $pizza_price;
    
                // Update order summary format to store quantity and pizza type separately
                $order_summary .= "$type:$quantity,"; 
            }
        }
        
        $order_summary = rtrim($order_summary, ",");

    // Sanitize User Input (Important for Security)
    $order_summary = $conn->real_escape_string($order_summary);

    // Insert Order into Database
    $sql = "INSERT INTO orders (order_details, total_price) VALUES ('$order_summary', $total_price)";

    if ($conn->query($sql) === TRUE) {
        $order_message = "Order placed successfully!";
    } else {
        $order_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close(); // Close the database connection
?>
