<?php 
session_start();
$noNavbar = '';
$pageTitle = 'Login';
if(isset($_SESSION['admin_username'])){
	header('location: dashboard.php');
}
include 'init.php';

//$inputErrors = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$username = $_POST['user'];
	$password = $_POST['pass'];
	$hashedPass = sha1($password);
	if(empty($username)){
		$inputErrors[] = "Enter your username";
	}
	if(empty($password)){
		$inputErrors[] = "Enter your password";
	} 
	if(!empty($inputErrors)){

	}
	else {
		$sql = "SELECT * FROM `users` WHERE Username = '$username' AND Password = '$hashedPass' AND GroupID = 1 LIMIT 1";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		if(mysqli_num_rows($result) > 0){
			$_SESSION['admin_username'] = $username;
			$_SESSION['admin_ID'] = $row['UserID'];
			header('location: dashboard.php');
			exit();
		} else{
			header('location: login.php');
		}
	}
}

?>

<h1 class = "text-center login-title">Admin Login Page</h1>
<form action = "<?php $_SERVER['PHP_SELF'] ?>" method = "POST" class = "custom-form">

<?php if(isset($inputErrors)){ ?>
<div class = "alert alert-danger">
	<ul> 
		<?php
			foreach ($inputErrors as $inputError) {
				echo "<li>" . $inputError . "</li>";
			}
		?>
	</ul>
</div>
<?php
} ?>
	
	<!-- username input -->
	<div class = "form-group">
		<label for = "username">Username: </label>
		<input type="text" name="user" placeholder="Enter your username" class = "form-control" id = "username" autocomplete="off">
	</div>

	<!-- password input -->
	<div class = "form-group">
		<label for = "password">Password: </label>
		<input type="password" name="pass" placeholder="Enter your password" class = "form-control" id = "password" autocomplete="new-password">
	</div>

	<!-- login button -->
	<input type="submit" name="login" value = "login" class = "btn btn-info">
</form>

<?php
include $tpl . 'footer.php';
?>