<?php
/*
===================================
		[Manage Members page]
		[Add/delete/edit]
===================================
*/

session_start();
$pageTitle = 'Memebers';
if(isset($_SESSION['admin_username'])){
	include 'init.php';
	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	if($do == 'Manage'){ 
		global $conn;
		$query = '';
		if(isset($_GET['page']) && $_GET['page'] == 'pending'){
			$query = 'AND RegStatus = 0';
		}

		$sql = "SELECT * FROM users WHERE GroupID != 1 $query";
		$result = $conn->query($sql);

		?>

		<h1 class = "text-center members-title">Manage Members</h1>
	<div class = "custom-table">
		<div class = "table-responsive">
			<table class = "table table-bordered text-center">
				<thead>
					<tr>
						<th>#ID</th>
						<th>Username</th>
						<th>Email</th>
						<th>Full Name</th>
						<th>Group ID</th>
						<th>Trusted user?</th>
						<th>Registration status</th>
						<th>controls</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = $result->fetch_assoc()){ ?>
						
						<tr>
							<td><?php echo $row['UserID']; ?></td>
							<td><?php echo $row['Username']; ?></td>
							<td><?php echo $row['Email']; ?></td>
							<td><?php echo $row['FullName']; ?></td>
							<td><?php echo $row['GroupID']; ?></td>
							<td><?php echo $row['TrustStatus']; ?></td>
							<td><?php echo $row['RegStatus']; ?></td>
							

							<?php
							if($row['RegStatus'] == 1){
							echo "<td>
								<a href = 'members.php?do=edit&userId=" . $row['UserID'] . "' class = 'btn btn-info'>Edit</a>
								<a href = 'members.php?do=delete&userId=" . $row['UserID'] . "' class = 'btn btn-danger confirm'>Delete</a>
							</td>"; 
								} else{
									echo "<td>
								<a href = 'members.php?do=edit&userId=" . $row['UserID'] . "' class = 'btn btn-info'>Edit</a>
								<a href = 'members.php?do=delete&userId=" . $row['UserID'] . "' class = 'btn btn-danger confirm'>Delete</a>
								<a href = 'members.php?do=activate&userId=" . $row['UserID'] . "' class = 'btn btn-primary'>Activate</a>
							</td>";
								}
							?>
							
						</tr>

					<?php } ?>
				</tbody>
			</table>
		</div>
		<a href="members.php?do=add" class = "btn btn-primary">Add Member</a>
	</div>
	<?php
	} elseif($do == 'add'){	?>

		<h1 class = "text-center members-title">Add Members</h1>
		<form class = "custom-form" action = "?do=insert" method = "POST">
					
					<div class = "form-group">
						<label for = "username">Username</label>
						<input type="text" name="username" placeholder="Enter your username" class = "form-control">
					</div>
					<div class = "form-group">
						<label for = "password">Password</label>
						<input type="password" name="password" placeholder="Enter your password" class = "form-control">
					</div>
					<div class = "form-group">
						<label for = "email">Email</label>
						<input type="email" name="email" placeholder="Enter your email" class = "form-control">
					</div>
					<div class = "form-group">
						<label for = "fullName">Full Name</label>
						<input type="text" name="fullName" placeholder="Enter your Full name" class = "form-control">
					</div>
					<div class = "form-group userType">
						<input type="radio" name="user_type" value = 1 id = "admin"><label for = "admin">Admin</label>
						<input type="radio" name="user_type" value = 0 id = "user" checked><label for = "user">Regualer user</label>
					</div>
					<input type="submit" name="insert" value = "Insert" class = "btn btn-info">
				</form>

	<?php
	} elseif($do == 'insert'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			global $conn;
			$username = strtolower($_POST['username']);
			$password = $_POST['password'];
			$email = $_POST['email'];
			$fullName = $_POST['fullName'];
			$userType = $_POST['user_type'];
			$hashedPassword = sha1($password);
			/*$sql = "INSERT INTO users(GroupID) VALUES('$userType')";
			$conn->query($sql);*/
			$stmt = "SELECT Username FROM users WHERE Username = '$username'";
			$result = $conn->query($stmt);
			$rowNums = mysqli_num_rows($result);
			if($rowNums == 1){
				echo "<div class = 'alert alert-danger'>This user already exist</div>";
				header('refresh: 3; url=members.php?do=add');

			} else{
				$sql = "INSERT INTO `users`(Username, Password, Email, FullName, GroupID) VALUES ('$username', '$hashedPassword', '$email', '$fullName', '$userType')";
				$result = $conn->query($sql);
				if($result){
					echo "<div class = 'alert alert-success text-center'>1 record inserted</div>";
					header('refresh: 3; url=members.php');
				}
			}
		}

	}	elseif($do == 'edit'){ 

		if(isset($_GET['userId'])){ 
			global $conn;
			$userID = $_GET['userId'];
			$sql = "SELECT * FROM `users` WHERE UserID = $userID";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			if(mysqli_num_rows($result) > 0){ ?>

				<h1 class = "text-center members-title">Edit Memebers</h1>
				<form class = "custom-form" action = "?do=Update" method = "POST">
					<input type="hidden" name="userID" value = "<?php echo $userID ?>">
					<div class = "form-group">
						<label for = "username">Username</label>
						<input type="text" name="username" placeholder="Enter your username" class = "form-control" value = "<?php echo $row['Username'] ?>">
					</div>
					<div class = "form-group">
						<label for = "username">Password</label>
						<input type="password" name="password" placeholder="Enter your password" class = "form-control" value = "<?php echo $row['Password'] ?>">
					</div>
					<div class = "form-group">
						<label for = "email">Email</label>
						<input type="email" name="email" placeholder="Enter your email" class = "form-control" value = "<?php echo $row['Email'] ?>">
					</div>
					<div class = "form-group">
						<label for = "fullName">Full Name</label>
						<input type="text" name="fullName" placeholder="Enter your Full name" class = "form-control" value = "<?php echo $row['FullName'] ?>">
					</div>
					<input type="submit" name="update" value = "Update" class = "btn btn-info">
				</form>
		<?php
			} else{
				echo "There is no such ID";
			}
		}
		
	} elseif($do == 'Update'){

		echo "<h1 class = 'text-center members-title'>Update Members</h1>";
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			global $conn;
			$id = $_POST['userID'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			$fullName = $_POST['fullName'];
			//hash password for security
			$updatedHashedPassed = sha1($password);

			$sql = "UPDATE `users` SET Username = '$username', Password = '$updatedHashedPassed', Email = '$email', FullName = '$fullName' WHERE UserID = $id";
			 $conn->query($sql);
			 header('refresh: 3; url=members.php');
		}


	} elseif($do == 'delete'){

		if(isset($_GET['userId'])){
			global $conn;
			$userId = $_GET['userId'];
			$sql = "DELETE FROM `users` WHERE UserID = $userId";
			$result = $conn->query($sql);
			if($result){
				echo "<div class = 'alert alert-danger'>1 Record Deleted</div>";
				header('refresh: 3; url=members.php');
			}
		}

	} elseif($do == 'activate'){

		if(isset($_GET['userId'])){
			global $conn;
			$userId = $_GET['userId'];
			$sql = "UPDATE users SET RegStatus = 1 WHERE UserID = $userId";
			$result = $conn->query($sql);
			if($result){
				echo "<div class = 'alert alert-success'>1 Record update</div>";
				header('refresh: 3; url=members.php');
			}
		}
	} else{

		echo "Can not find page";

	}

	include $tpl . 'footer.php';
} else{
	header('location: login.php');
}

?>