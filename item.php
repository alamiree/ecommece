<?php
session_start();
$pageTitle = "Item";
if(isset($_SESSION['admin_username'])){
	include 'init.php';
	$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

	if($do == 'manage'){

		$sql = "SELECT * FROM items";
		$result = $conn->query($sql);

		?>

		<h1 class = "text-center members-title">Manage Items</h1>
	<div class = "custom-table">
		<div class = "table-responsive">
			<table class = "table table-bordered text-center">
				<thead>
					<tr>
						<th>Item ID</th>
						<th>Item Name</th>
						<th>Description</th>
						<th>Item Price</th>
						<th>Country of Made</th>
						<th>Controls</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = $result->fetch_assoc()){ ?>
						
						<tr>
							<td><?php echo $row['item_ID']; ?></td>
							<td><?php echo $row['item_name']; ?></td>
							<td><?php echo $row['item_desc']; ?></td>
							<td><?php echo $row['item_price']; ?></td>
							<td><?php echo $row['country_made']; ?></td>
							<?php
							echo "<td>
								<a href = 'item.php?do=edit&itemID=" . $row['item_ID'] . "' class = 'btn btn-info'>Edit</a>
								<a href = 'item.php?do=delete&userId=" . $row['item_ID'] . "' class = 'btn btn-danger confirm'>Delete</a>
							</td>"; 
							?>
							
						</tr>

					<?php } ?>
				</tbody>
			</table>
		</div>
		<a href="item.php?do=add" class = "btn btn-primary">Add Item</a>
	</div>
<?php
	} elseif($do == 'add'){ ?>

		<h1 class = "text-center members-title">Add Item</h1>
		<form class = "custom-form" action = "?do=insert" method = "POST">
					<div class = "form-group">
						<label for = "name">Item Name:</label>
						<input type="text" name="itemName" placeholder="Enter the item name" class = "form-control">
					</div>
					<div class = "form-group">
						<label for = "description">Item Description:</label>
						<input type="text" name="item_desc" class = "form-control" placeholder="Enter the item description">
					</div>
					<div class = "form-group">
						<label for = "ordering">Item Price:</label>
						<input type="text" name="price" placeholder="Enter The item price" class = "form-control">
					</div>
					<div class = "form-group">
						<label for = "ordering">Made of Country:</label>
						<input type="text" name="countryMade" placeholder="Enter The item country made" class = "form-control">
					</div>
					
					<div class = "form-group">
						<label>Item State: </label>
						<select name = "ItemState" class = "form-control">
							<option value = "0">---</option>
							<option value = "1">New</option>
							<option value = "2">Like New</option>
							<option value = "3">Used</option>
							<option value = "4">Not working</option>
						</select>
					</div>

					<div class = "form-group">
						<label>Members: </label>
						<select name = "members" class = "form-control">
							<option value = "0">---</option>
							<?php
								$sql = "SELECT * FROM users";
								$result = $conn->query($sql);
								while($row = $result->fetch_assoc()){
								echo "<option value = '" . $row['UserID'] . "'>" . $row['Username'] . "</option>";
								}
							?>
						</select>
					</div>

					<div class = "form-group">
						<label>Categories: </label>
						<select name = "categories" class = "form-control">
							<option value = "0">---</option>
							<?php
								$sql = "SELECT * FROM categories";
								$result = $conn->query($sql);
								while($row = $result->fetch_assoc()){
								echo "<option value = '" . $row['ID'] . "'>" . $row['Name'] . "</option>";
								}
							?>
						</select>
					</div>

					<input type="submit" name="insert" value = "Insert" class = "btn btn-info">
				</form>

<?php
	} elseif($do == 'insert'){ 

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$name = $_POST['itemName'];
			$desc = $_POST['item_desc'];
			$price = $_POST['price'];
			$countryMade = $_POST['countryMade'];
			$itemState = $_POST['ItemState'];
			$members = $_POST['members'];
			$categories = $_POST['categories'];

			$sql = "INSERT INTO `Items`(item_name, item_desc, item_price, regDate, country_made, item_state, cat_ID, member_ID) VALUES ('$name', '$desc', '$price' , now(), '$countryMade', '$itemState', '$categories', '$members')";
			$result = $conn->query($sql);
			if($result){
				echo "<div class = 'alert alert-success'>1 record inserted</div>";
				header('refresh: 3; url=item.php?do=manage');
			}

		} else{
			echo "<div class = 'alert alert-danger'>You can not access this page directly</div>";
			header('refresh: 3; url=item.php?do=manage');
		}


	}	elseif($do == 'edit'){

		echo 'edit page';

	}	elseif($do == 'update'){

		echo 'update page';

	} elseif($do == 'delete'){

		echo 'delete page';

	} elseif($do == 'approve'){

		echo 'approve page';

	}

	include $tpl . 'footer.php';
} else{
	header('location: login.php');
}

?>