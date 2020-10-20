<?php
session_start();
$pageTitle = 'Dashboard';
if(isset($_SESSION['admin_username'])){
	include 'init.php';
	$sql = "SELECT * FROM users ORDER BY UserID DESC LIMIT 4";
	$result = $conn->query($sql);
?>
	<h1 class = "text-center custom-title">Dashboard</h1>
	<div class = "container home-stats">
		<div class = "row text-center">
			<div class = "col-md-3"> 
				<div class = "stat st-members">
					Total Members
					<i class="fas fa-users"></i>
					<span><a href="members.php"><?php echo getCount('UserID', 'users'); ?></a></span>
				</div>
			</div>
			<div class = "col-md-3"> 
				<div class = "stat st-pending">
					Pending Members
					<span><a href="members.php?do=Manage&page=pending"><?php echo getPenddingCount('UserID', 'users', 'RegStatus'); ?></a></span>
				</div>
			</div>
			<div class = "col-md-3"> 
				<div class = "stat st-items">
					Total Items
					<span><a href="item.php"><?php echo getCount('item_ID', 'items'); ?></a></span>
				</div>
			</div>
			<div class = "col-md-3"> 
				<div class = "stat st-comments">
					Total comments
					<span>3500</span>
				</div>
			</div>
		</div>
	</div>
		<div class = "container latest">
			<div class = "row">
				<div class = "col-sm-6">
					<div class = "panel panel-default">
						<div class = "panel-heading">
							<i class = "fa fa-users"></i>Latest Registered Users
						</div>
						<div class = "panel-body">
							<ul class = "list-unstyled latest-users">
							<?php
								while($row = $result->fetch_assoc()) { 
									echo '<li>';
									echo $row['Username'];
										echo '<a href = "members.php?do=edit&userId=' . $row['UserID'] . '" class = "btn btn-info pull-right"><i class = "fa fa-edit"></i>Edit</a>';
										if($row['RegStatus'] == 0){
										echo 	'<a href = "members.php?do=activate&userId= ' . $row['UserID'] . '" class = "btn btn-primary pull-right activate-dash">Activate</a>';
										}
									echo '</li>';
							} ?>
							</ul>
						</div>
					</div>
				</div>
				<div class = "col-sm-6">
					<div class = "panel panel-default">
						<div class = "panel-heading">
							<i class = "fa fa-tag"></i>Latest Items
						</div>
						<div class = "panel-body">
							Test
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	include $tpl . 'footer.php';
} else{
	header('location: login.php');
}
?>