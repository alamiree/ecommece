<?php
session_start();
$pageTitle = 'Catagories';
if(isset($_SESSION['admin_username'])){
	include 'init.php';
	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
	
	if($do == 'manage'){
		
		$stmt2 = "SELECT * FROM `categories";
		$result = $conn->query($stmt2);
	?>
	
		<h1 class = "text-center members-title">Manage Catagory</h1>
		<div class = "container categoies">
			<div class = "panel panel-default">
				<div class =  "panel-heading">Manage Categoies</div>
				<div class = "panel-body">
					<?php
					while($row = $result->fetch_assoc()){
						echo "<div class = 'cat'>";
						
						echo "<div class = 'hidden-buttons'>";
						echo "<a href = 'catagory.php?do=edit&catID=" . $row['ID'] .  "' class = 'btn btn-xs btn-primary'>Edit</a>";
						echo "<a href = 'catagory.php?do=delete&catID=" . $row['ID'] . "' class = 'btn btn-xs btn-danger confirm'>Delete</a>";
						echo "</div>";

						echo "<h3>" . $row['Name'] . "</h3>";
						echo "<p>";  
						if($row['descrption'] == ''){ 
							echo 'no comment';
						} else{
							echo $row['descrption']; 
						} 
						echo "</p>";
						if($row['visiblity'] == 1){
							echo '<span class = "visiblity">Hidden</span>';
						}
						if($row['allow_comment'] == 1){
							echo '<span class = "commenting">comment disabled</span>';
						}
						if($row['allow_ads'] == 1){
							echo '<span class = "ads">ads disabled</span>';
						}
						//echo '<span class = "visiblity">visibilty allow is: ' . $row['visiblity'] . '</span>';
						//echo '<span class = "commenting">comment allow is: ' . $row['allow_comment'] . '<br></span>';
						//echo '<span class = "ads">ads allow is: ' . $row['allow_ads'] . '</span>';
						echo "</div>";
						echo "<hr>";
					}
					?>

				</div>
			</div>
			<a href="catagory.php?do=add" class = "btn btn-info">Add Category</a>
		</div>
		
	<?php

	} elseif($do == 'add') { 

		?>

		<h1 class = "text-center members-title">Add Categoriy</h1>
		<form class = "custom-form" action = "?do=insert" method = "POST">
					<div class = "form-group">
						<label for = "name">Name</label>
						<input type="text" name="catName" placeholder="Enter the Categoriy name" class = "form-control">
					</div>
					<div class = "form-group">
						<label for = "description">Description</label>
						<input type="text" name="description" class = "form-control" placeholder="Enter the description">
					</div>
					<div class = "form-group">
						<label for = "ordering">Ordering</label>
						<input type="text" name="ordering" placeholder="Enter The Ordering Number" class = "form-control">
					</div>
					<div class = "form-group">
						<label for = "fullName">Visible?</label>
						<div>
							<input id = "vis-yes" type="radio" name="visiblity" value = "0">
							<label for="vis-yes">Yes</label>
						</div>
						<div>
							<input type="radio" name="visiblity" value = "1" id = "vis-no" checked>
							<label for="vis-no">No</label>
						</div>
					</div>

					<div class = "form-group">
						<label for = "fullName">Allow Comment?</label>
						<div>
							<input id = "com-yes" type="radio" name="allowComment" value = "0">
							<label for="com-yes">Yes</label>
						</div>
						<div>
							<input type="radio" name="allowComment" value = "1" id = "com-no" checked>
							<label for="com-no">No</label>
						</div>
					</div>

					<div class = "form-group">
						<label>Allow Ads?</label>
						<div>
							<input id = "ads-yes" type="radio" name="allowAds" value = "0">
							<label for="ads-yes">Yes</label>
						</div>
						<div>
							<input type="radio" name="allowAds" value = "1" id = "ads-no" checked>
							<label for="ads-no">No</label>
						</div>
					</div>
					
					<input type="submit" name="insert" value = "Insert" class = "btn btn-info">
				</form>

<?php
	} elseif($do == 'insert'){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$name = $_POST['catName'];
			$desc = $_POST['description'];
			$ordering = $_POST['ordering'];
			$visiblity = $_POST['visiblity'];
			$comment = $_POST['allowComment'];
			$allowAds = $_POST['allowAds'];

			$stmt = "INSERT INTO `categories`(Name, descrption, ordering, visiblity, allow_comment, allow_ads) VALUES ('$name', '$desc', '$ordering', '$visiblity', '$comment', '$allowAds')";
			$result = $conn->query($stmt);
			if($result){
				echo "<div class = 'alert alert-success'>1 Record inserted</div>";
				header('refresh: 3; url=catagory.php?do=add');
			}
		}

	} elseif($do == 'edit'){ 

			if(isset($_GET['catID'])){
				$catID = $_GET['catID'];
				$sql = "SELECT * FROM `categories` WHERE ID = $catID";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
			}
		?>

		<h1 class = "text-center members-title">Edit Categoriy</h1>
		<form class = "custom-form" action = "?do=update" method = "POST">
					<input type="hidden" name="catId" value = "<?php echo $row['ID']; ?>">
					<div class = "form-group">
						<label for = "name">Name</label>
						<input type="text" name="catName" placeholder="Enter the Categoriy name" class = "form-control" value = "<?php echo $row['Name']; ?>">
					</div>
					<div class = "form-group">
						<label for = "description">Description</label>
						<input type="text" name="description" class = "form-control" placeholder="Enter the description" value = "<?php echo $row['descrption']; ?>">
					</div>
					<div class = "form-group">
						<label for = "ordering">Ordering</label>
						<input type="text" name="ordering" placeholder="Enter The Ordering Number" class = "form-control" value = "<?php echo $row['ordering']; ?>">
					</div>
					<div class = "form-group">
						<label for = "fullName">Visible?</label>
						<div>
							<input id = "vis-yes" type="radio" name="visiblity" value = "0" <?php if($row['visiblity'] == 0){ echo 'checked'; } ?> >
							<label for="vis-yes">Yes</label>
						</div>
						<div>
							<input type="radio" name="visiblity" value = "1" id = "vis-no" <?php if($row['visiblity'] == 1){ echo 'checked'; } ?> >
							<label for="vis-no">No</label>
						</div>
					</div>

					<div class = "form-group">
						<label for = "fullName">Allow Comment?</label>
						<div>
							<input id = "com-yes" type="radio" name="allowComment" value = "0" <?php if($row['allow_comment'] == 0){ echo 'checked'; } ?> >
							<label for="com-yes">Yes</label>
						</div>
						<div>
							<input type="radio" name="allowComment" value = "1" id = "com-no" <?php if($row['allow_comment'] == 1){ echo 'checked'; } ?>>
							<label for="com-no">No</label>
						</div>
					</div>

					<div class = "form-group">
						<label>Allow Ads?</label>
						<div>
							<input id = "ads-yes" type="radio" name="allowAds" value = "0" <?php if($row['allow_ads'] == 0){ echo 'checked'; } ?>>
							<label for="ads-yes">Yes</label>
						</div>
						<div>
							<input type="radio" name="allowAds" value = "1" id = "ads-no" <?php if($row['allow_ads'] == 1){ echo 'checked'; } ?>>
							<label for="ads-no">No</label>
						</div>
					</div>
					
					<input type="submit" name="insert" value = "Insert" class = "btn btn-info">
				</form>

<?php
	} elseif($do == 'update'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$catID 		= $_POST['catId'];
			$catName 	= $_POST['catName'];
			$catDesc 	= $_POST['description'];
			$catOrder 	= $_POST['ordering'];
			$catVis 	= $_POST['visiblity'];
			$catCom 	= $_POST['allowComment'];
			$catAds 	= $_POST['allowAds'];

			$stmt1 = "UPDATE `categories` SET Name = '$catName', descrption = '$catDesc', ordering = '$catOrder', visiblity = '$catVis', allow_comment = '$catCom', allow_ads = '$catAds' WHERE ID = $catID";
			$conn->query($stmt1);
			echo "<div class = 'alert alert-success'>1 record updated</div>";
			header('refresh: 3; url=catagory.php?do=manage');
		}
		

	} elseif($do == 'delete'){

		if(isset($_GET['catID'])){
			$catID = $_GET['catID'];
			$query = "DELETE FROM `categories` WHERE ID = $catID";
			$conn->query($query);
			echo "<div class = 'alert alert-success'>1 record deleted</div>";
			header('refresh: 3; url=catagory.php?do=manage');
		}

	} elseif($do == 'activate'){

		echo "Add Page";

	}
	include $tpl . 'footer.php';

}else {
	echo "<div class = 'alert alert-danger'>You can not access this page directly, you need to login first</div>";
	header('refresh: 3; url=login.php');
}

?>