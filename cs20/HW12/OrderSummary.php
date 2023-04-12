<!DOCTYPE html>
<html>

<head>
	<title>Order Summary</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<header>
		<h1>Two Owls Cafe</h1>
		<h2>Open Daily From 8PM To 3AM!</h2>
	</header>
	<main>
		<h2>Order Summary</h2>
		<table>
			<tr>
				<th>Item</th>
				<th>Quantity</th>
				<th>Cost</th>
			</tr>
			<?php
				$servername = "localhost";
				$username = "uugpyptbxiozr";
			$password = "WebDesign";
				$dbname = "dbug6u8mhhwyyz";

				$conn = mysqli_connect($servername, $username, $password, $dbname);

				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$subTotal = 0;
				$taxRate = 0.07;

				foreach ($_POST['quantity'] as $itemId => $quantity) {
					$sql = "SELECT * FROM menu_items WHERE id = $itemId";
					$result = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($result);
					$itemName = $row['name'];
					$itemPrice = $row['price'];
				  $itemCost = $itemPrice * $quantity;
					$subTotal += $itemCost;

					echo "<tr>";
					echo "<td>$itemName</td>";
					echo "<td>$quantity</td>";
					echo "<td>$" . number_format($itemCost, 2) . "</td>";
					echo "</tr>";
				}

				$tax = $subTotal * $taxRate;
				$total = $subTotal + $tax;

				mysqli_close($conn);
			?>
			<tr>
				<td colspan="2">Subtotal:</td>
				<td>$<?= number_format($subTotal, 2) ?></td>
			</tr>
			<tr>
				<td colspan="2">Tax:</td>
				<td>$<?= number_format($tax, 2) ?></td>
			</tr>
			<tr>
				<td colspan="2">Total:</td>
				<td>$<?= number_format($total, 2) ?></td>
			</tr>
		</table>
		<p>Your order will be ready for pickup in approximately 15 minutes.</p>
	</main>
</body>
</html>
