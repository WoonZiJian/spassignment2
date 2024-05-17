<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spassignment1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pizzas = [
    'Margherita' => 15.00,
    'Pepperoni' => 17.00,
    'BBQ Chicken' => 19.00,
    'Vegetarian' => 10.00,
];

$delivery_fee = 5.00;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total_price = $delivery_fee;
    $order_summary = "";

    foreach ($pizzas as $type => $price) {
        if (isset($_POST["quantity_$type"]) && $_POST["quantity_$type"] > 0) {
            $quantity = htmlspecialchars($_POST["quantity_$type"]);
            $pizza_price = $price * $quantity;
            $total_price += $pizza_price;
            $order_summary .= "$quantity " . str_replace('_', ' ', $type) . " pizza(s), ";
        }
    }

    $order_summary = rtrim($order_summary, ", ");
    $address = htmlspecialchars($_POST['address']);
    $order_message = "You have ordered: $order_summary. Total price including delivery fee: RM$total_price. Delivering to: $address.";

    // Insert order into database
    $sql = "INSERT INTO orders (order_summary, total_price, address) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sds", $order_summary, $total_price, $address);
        $stmt->execute();
        $stmt->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Order To Your Doorstep!!</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function calculateTotal() {
            const pizzas = <?php echo json_encode($pizzas); ?>;
            let totalPrice = <?php echo $delivery_fee; ?>;
            for (const type in pizzas) {
                const quantity = document.getElementById('quantity_' + type).value;
                totalPrice += pizzas[type] * quantity;
            }
            document.getElementById('total_price').innerText = "RM" + totalPrice.toFixed(2);
        }
    </script>
</head>
<body>
    <form action="pizza_order.php" method="post">
        <h2>Choose Your Pizza !!!</h2>
        <div class="container">
            <?php foreach ($pizzas as $type => $price): ?>
                <label for="quantity_<?php echo $type; ?>"><b><?php echo str_replace('_', ' ', $type) . " - RM" . number_format($price, 2); ?></b></label>
                <input type="number" name="quantity_<?php echo $type; ?>" id="quantity_<?php echo $type; ?>" value="0" min="0" onchange="calculateTotal()">
            <?php endforeach; ?>
            
            <label for="address"><b>Delivery Address:</b></label>
            <input type="text" name="address" id="address" placeholder="Enter your address" required>

            <p><b>Delivery Fee:</b> RM<?php echo number_format($delivery_fee, 2); ?></p>
            <p><b>Total Price:</b> <span id="total_price">RM<?php echo number_format($delivery_fee, 2); ?></span></p>
            
            <button type="submit">Place Order</button>
        </div>
        <?php if (isset($order_message)): ?>
            <div class="success_message"><?php echo $order_message; ?></div>
        <?php endif; ?>
    </form>
</body>
</html>
