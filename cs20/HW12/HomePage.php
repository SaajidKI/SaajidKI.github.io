<!DOCTYPE html>
<html>

<head>
    <title>Two Owls Cafe | Home Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>Two Owls Cafe</h1>
    <h2>Open Daily From 8PM To 3AM!</h2>
    <div>Order Form</div>
    <?php
        $servername = "localhost";
        $username = "uugpyptbxiozr";
        $password = "WebDesign";
        $dbname = "dbug6u8mhhwyyz";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM menu_items";
        $result = mysqli_query($conn, $sql);

        echo "<form method='post' action=''>";
        echo "<table>";
        echo "<tr><th>Item</th><th>Price</th><th>Quantity</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td><img src='" . $row['image_url'] . "' alt='" . $row['name'] . "' width='125' height=125'>" . $row['name'] . "</td>";
            echo "<td>$" . $row['price'] . "</td>";
            echo "<td><select name='quantity[" . $row['id'] . "]' onchange='updateQuantity(this)'>";
            for ($i = 0; $i <= 10; $i++) {
                echo "<option value='" . $i . "'>" . $i . "</option>";
            }
            echo "</select></td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<label for='firstname'>First Name:</label>";
        echo "<input type='text' id='firstname' name='firstname'><br><br>";
        echo "<label for='lastname'>Last Name:</label>";
        echo "<input type='text' id='lastname' name='lastname'><br><br>";
        echo "<label for='instructions'>Special Instructions:</label>";
        echo "<textarea id='instructions' name='instructions'></textarea><br><br>";

        echo "<input type='submit' name='submit' value='Order' onclick='return validateForm()'>";
        echo "</form>";
        
        echo "<form method='post' action='OrderSummary.php' style='width: 140px'>";
        echo "<input type='submit' value='View Order' id='button'>";
        echo "</form>";

        if (isset($_POST['submit'])) {
            $ordered_items = array();
            foreach ($_POST['quantity'] as $item_id => $item_quantity) {
                if ($item_quantity > 0) {
                    $ordered_items[] = array(
                    'id' => $item_id,
                    'quantity' => $item_quantity
                    );
                }
            }

            $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
            $instructions = mysqli_real_escape_string($conn, $_POST['instructions']);

            $sql = "INSERT INTO past_orders (ordered_items, firstname, lastname, instructions) VALUES (";
            $sql .= "'" . mysqli_real_escape_string($conn, json_encode($ordered_items)) . "', ";
            $sql .= "'" . $firstname . "', ";
            $sql .= "'" . $lastname . "', ";
            $sql .= "'" . $instructions . "'";
            $sql .= ")";

            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
    ?>

    <script>
        let quantity = {};

        function updateQuantity(select) {
            let itemId = select.name.match(/\d+/)[0];
            let itemQuantity = select.value;
            quantity[itemId] = itemQuantity;
        }

        function validateForm() {
            let totalQuantity = Object.values(quantity).reduce((a, b) => a + parseInt(b), 0);
            let items = document.querySelectorAll("select[name='quantity']");
            for (let i = 0; i < items.length; i++) {
                totalQuantity += parseInt(items[i].value);
            }
            
            if (totalQuantity <= 0) {
                alert("Please select at least one item to order.");
                return false;
            }

            let firstname = document.getElementById("firstname").value.trim();
            let lastname = document.getElementById("lastname").value.trim();
            if (firstname == "" || lastname == "") {
                alert("Please provide your first and last name.");
                return false;
            }

            openTime = new Date();
            openTime.setHours(20, 0, 0);
            closeTime = new Date();
            closeTime.setDate(closeTime.getDate() + 1);
            closeTime.setHours(3, 0, 0);
            now = new Date();
            if (now < openTime || ((closeTime - now) / 1000 / 60) < 30) {
                alert("The cafe is currently closed. Please place your order at least 30 minutes prior to closing!");
                return false;
            }

            alert("Thank you for ordering! Your food will be ready soon!")
            return true;
        }
    </script>
  
</body>
</html>
