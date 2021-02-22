<?php
ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

	if (empty($_SESSION['user_id'])) {

		header('location:login.php');
	}
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include_once("includes/head.php"); ?>

	<title>Dashboard</title>

</head>

<body class="page-body  page-fade" data-url="http://neon.dev">

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

			<?php

			$query = $conn->prepare("SELECT id from artists");
			$query->execute();
			$total_artists=$query->rowCount();


			$query = $conn->prepare("SELECT id from songs");
			$query->execute();
			$total_songs=$query->rowCount();


			$query = $conn->prepare("SELECT id from dj_sets");
			$query->execute();
			$total_dj_sets=$query->rowCount();


			$query = $conn->prepare("SELECT id from show_episodes");
			$query->execute();

			$total_show_episodes=$query->rowCount();



			
			?>





			<div class="row">
				<div class="col-sm-3 col-xs-6">

					<div class="tile-stats tile-red">
						<div class="icon"><i class="entypo-users"></i></div>
						<div class="num" data-start="0" data-end="<?php echo $total_artists ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>

						<h3>Total Artists</h3>
						
					</div>

				</div>

				<div class="col-sm-3 col-xs-6">

					<div class="tile-stats tile-green">
						<div class="icon"><i class="entypo-music"></i></div>
						<div class="num" data-start="0" data-end="<?php echo $total_songs ?>" data-postfix="" data-duration="1500" data-delay="600">0</div>

						<h3>Total Songs</h3>
						
					</div>

				</div>

				<div class="clear visible-xs"></div>

				<div class="col-sm-3 col-xs-6">

					<div class="tile-stats tile-blue">
						<div class="icon"><i class="entypo-note"></i></div>
						<div class="num" data-start="0" data-end="<?php echo $total_dj_sets ?>" data-postfix="" data-duration="1500" data-delay="1200">0</div>

						<h3>Total DJ Sets</h3>
					
					</div>

				</div>

				<div class="col-sm-3 col-xs-6">

					<div class="tile-stats tile-black">
						<div class="icon"><i class="entypo-floppy"></i></div>
						<div class="num" data-start="0" data-end="<?php echo $total_show_episodes ?>" data-postfix="" data-duration="1500" data-delay="1800">0</div>

						<h3>Total Show Episodes</h3>
					
					</div>

				</div>
			</div>



			<br />






			<!-- Footer starts -->
			<?php include_once("includes/footer.php"); ?>
			<!-- Footer end -->
		</div>



	</div>





	<!-- scripts starts -->

	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">

	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
	<script src="assets/js/jquery.sparkline.min.js"></script>
	<script src="assets/js/rickshaw/vendor/d3.v3.js"></script>
	<script src="assets/js/rickshaw/rickshaw.min.js"></script>
	<script src="assets/js/raphael-min.js"></script>
	<script src="assets/js/morris.min.js"></script>
	<script src="assets/js/toastr.js"></script>
	<script src="assets/js/neon-chat.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="assets/js/neon-demo.js"></script>
	<!-- scripts ends -->

</body>

</html>