<!DOCTYPE html>
<html>

<head>
    <title>Two Owls Cafe | Order Summary</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>Two Owls Cafe</h1>
    <h2>Open Daily From 8PM To 3AM!</h2>
    <div>Order Summary</div>
    <?php
        $servername = "localhost";
        $username = "uugpyptbxiozr";
        $password = "WebDesign";
        $dbname = "dbug6u8mhhwyyz";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
        $sql = "SELECT * FROM past_orders ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
    
            $ordered_items = json_decode($row["ordered_items"], true);
    
            echo "<h4>Customer Name: " . $row["firstname"] . " " . $row["lastname"] . "</h4>";
            echo "<h4>Special Instructions: " . $row["instructions"] . "</h4>";
            echo "<table>";
            echo "<tr><th>Item</th><th>Quantity</th><th>Individual Cost</th><th>Total Cost</th></tr>";
            $subtotal = 0;
            foreach ($ordered_items as $item) {
                $sql = "SELECT * FROM menu_items WHERE id=" . $item["id"];
                $result = mysqli_query($conn, $sql);
                $menu_item = mysqli_fetch_assoc($result);
                $individual_cost = $menu_item["price"];
                $total_cost = $individual_cost * $item["quantity"];
                echo "<tr>";
                echo "<td>" . $menu_item["name"] . "</td>";
                echo "<td>" . $item["quantity"] . "</td>";
                echo "<td>$" . number_format($individual_cost, 2) . "</td>";
                echo "<td>$" . number_format($total_cost, 2) . "</td>";
                echo "</tr>";
                $subtotal += $total_cost;
            }
            $tax_rate = 0.0625;
            $tax = $subtotal * $tax_rate;
            $total = $subtotal + $tax;
            echo "<tr><td colspan='3'>Subtotal:</td><td>$" . number_format($subtotal, 2) . "</td></tr>";
            echo "<tr><td colspan='3'>Tax (" . ($tax_rate * 100) . "%):</td><td>$" . number_format($tax, 2) . "</td></tr>";
            echo "<tr><td colspan='3'>Total:</td><td>$" . number_format($total, 2) . "</td></tr>";
            echo "</table>";
        }
    
        date_default_timezone_set('America/New_York');
        $pickup_time = strtotime('+15 minutes');
        $pickup_time_str = date('g:i A', $pickup_time);
        echo "<p>Your order will be ready for pickup at " . $pickup_time_str . ".</p>";
    
        mysqli_close($conn);
    ?>

</body>

</html>
