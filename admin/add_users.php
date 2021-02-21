<?php
ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

	if (empty($_SESSION['user_id'])) {

		header('location:login.php');
	}
}

if(!in_array(4,$_SESSION["user_access_arr"])){
	header('location:index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include_once("includes/head.php"); ?>

	<title>Add Users</title>
</head>

<body class="page-body">

	<div class="page-container">
		<!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

		<!-- leftbar starts -->

		<?php include_once("includes/left-bar.php"); ?>

		<!-- leftbar ends -->

		<div class="main-content">

			<div class="row">

				<!-- header starts-->
				<?php include_once("includes/header.php"); ?>
				<!-- header ends -->

			</div>

			<hr />

			<ol class="breadcrumb bc-3">
				<li>
					<a href="index.php"><i class="fa-home"></i>Home</a>
				</li>
				<li>

					<a href="#">Users</a>
				</li>
				<li class="active">

					<strong>Add User</strong>
				</li>
			</ol>

			<h2>Add User</h2>
			<br />


			<div class="row">
				<div class="col-md-12">

					<div class="panel panel-primary" data-collapsed="0">

						<div class="panel-heading">
							<div class="panel-title">
								Add User Info
							</div>

							<div class="panel-options">
								<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
								<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

							</div>
						</div>

						<div class="panel-body">

							<?php

							if (isset($_POST['submit'])) {



								$email = $_POST["email"];
								$password = $_POST["password"];
								$name = $_POST["name"];
								$prefix = $_POST["prefix"];
								$status = $_POST["status"];


								$stmt = $conn->prepare("INSERT INTO `users`( `email`,`password`,`name`,`prefix`,`status`,`created`) VALUES (:email,:password,:name,:prefix,:status, CURRENT_TIMESTAMP)");


								$stmt->bindParam(':email', $email);
								$stmt->bindParam(':password', $password);
								$stmt->bindParam(':name', $name);
								$stmt->bindParam(':prefix', $prefix);
								$stmt->bindParam(':status', $status);

								$stmt->execute();

								$user_id = $conn->lastInsertId();


								if (isset($_POST["dj"])) {
									$stmt = $conn->prepare("INSERT INTO `user_access`( `user_id`,`access_id`) VALUES (:user_id,:access_id)");

									$stmt->bindParam(':user_id', $user_id);
									$stmt->bindParam(':access_id', $_POST["dj"]);
									$stmt->execute();
								}


								if (isset($_POST["mix_tapes"])) {
									$stmt = $conn->prepare("INSERT INTO `user_access`( `user_id`,`access_id`) VALUES (:user_id,:access_id)");

									$stmt->bindParam(':user_id', $user_id);
									$stmt->bindParam(':access_id', $_POST["mix_tapes"]);
									$stmt->execute();
								}


								if (isset($_POST["episodes"])) {
									$stmt = $conn->prepare("INSERT INTO `user_access`( `user_id`,`access_id`) VALUES (:user_id,:access_id)");

									$stmt->bindParam(':user_id', $user_id);
									$stmt->bindParam(':access_id', $_POST["episodes"]);
									$stmt->execute();
								}


								if (isset($_POST["admin"])) {
									$stmt = $conn->prepare("INSERT INTO `user_access`( `user_id`,`access_id`) VALUES (:user_id,:access_id)");

									$stmt->bindParam(':user_id', $user_id);
									$stmt->bindParam(':access_id', $_POST["admin"]);
									$stmt->execute();
								}



							?>

								<br>
								<div class="alert alert-success alert-dismissible" role="alert">
									<strong>Congrats!</strong> Successfully Submit
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<br>

							<?php





							}

							?>


							<form role="form" method="post" class="form-horizontal form-groups-bordered">

								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label">User Email</label>

									<div class="col-sm-5">
										<input required="" type="email" name="email" class="form-control" id="field-1" placeholder="Email">
									</div>
								</div>


								<div class="form-group">
									<label for="field-3" class="col-sm-3 control-label">User Password</label>

									<div class="col-sm-5">
										<input required="" type="password" name="password" class="form-control" id="field-3" placeholder="Password">
									</div>
								</div>

								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label">User Display Name</label>

									<div class="col-sm-5">
										<input required="" type="text" name="name" class="form-control" id="field-1" placeholder="Display Name">
									</div>
								</div>

								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label">User Prefix</label>

									<div class="col-sm-5">
										<input required="" type="text" name="prefix" class="form-control" id="field-1" placeholder="Prefix">
									</div>
								</div>


								<div class="form-group">
									<label class="col-sm-3 control-label">Status ID</label>

									<div class="col-sm-5">
										<select class="form-control" name="status" required="">
											<option value="active">Active</option>
											<option value="inactive">Inactive</option>

										</select>
									</div>
								</div>


								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-5">
										<div class="checkbox">
											<label>
												<input name="dj" value="1" type="checkbox">Manage DJ Sets
											</label>
										</div>

										<div class="checkbox">
											<label>
												<input name="mix_tapes" value="2" type="checkbox">Manage Mix Tapes
											</label>
										</div>

										<div class="checkbox">
											<label>
												<input name="episodes" value="3" type="checkbox">Manage Show Episodes
											</label>
										</div>

										<div class="checkbox">
											<label>
												<input name="admin" value="4" type="checkbox">Admin Access
											</label>
										</div>
									</div>
								</div>



								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-5">
										<button type="submit" name="submit" class="btn btn-default">Add User</button>
									</div>
								</div>
							</form>

						</div>

					</div>

				</div>
			</div>





			<!-- Footer starts -->
			<?php include_once("includes/footer.php"); ?>
			<!-- Footer end -->

		</div>




	</div>




	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/bootstrap-switch.min.js"></script>
	<script src="assets/js/neon-chat.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="assets/js/neon-demo.js"></script>

</body>

</html>