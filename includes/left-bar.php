<?php

$user_type_arr = $_SESSION["user_access_arr"];


?>


<div class="sidebar-menu">

	<div class="sidebar-menu-inner">

		<header class="logo-env">

			<!-- logo -->
			<div class="logo">
				<a href="index.php">
					<img src="assets/images/logo@2x.png" width="120" alt="" />
				</a>
			</div>

			<!-- logo collapse icon -->
			<div class="sidebar-collapse">
				<a href="#" class="sidebar-collapse-icon">
					<!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
					<i class="entypo-menu"></i>
				</a>
			</div>


			<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
			<div class="sidebar-mobile-menu visible-xs">
				<a href="#" class="with-animation">
					<!-- add class "with-animation" to support animation -->
					<i class="entypo-menu"></i>
				</a>
			</div>

		</header>



		<ul id="main-menu" class="main-menu">
			<!-- add class "multiple-expanded" to allow multiple submenus to open -->
			<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
			<li class="active active">
				<a href="index.php">
					<i class="entypo-gauge"></i>
					<span class="title">Dashboard</span>
				</a>

			</li>

			<li class="has-sub">

				<a href="#">
					<i class="entypo-user"></i>
					<span class="title">Admin Zone</span>
				</a>

				<ul>
					<?php

					if (in_array(4, $user_type_arr)) {

					?>



						<li class="has-sub">
							<a href="#">
								<i class="entypo-user-add"></i>
								<span class="title">Users</span>
							</a>
							<ul>
								<li>
									<a href="add_users.php">
										<span class="title">Add Users</span>
									</a>
								</li>

								<li class="has-sub">
									<a href="#">
										<span class="title">All Users</span>
									</a>
									<ul>
										<li>
											<a href="all_users.php">
												<span class="title">All Users</span>
											</a>
										</li>
										<li>
											<a href="all_users.php?access=1">
												<span class="title">Dj Access</span>
											</a>
										</li>
										<li>
											<a href="all_users.php?access=2">
												<span class="title">Mix Tape Access</span>
											</a>
										</li>
										<li>
											<a href="all_users.php?access=3">
												<span class="title">Episode Access</span>
											</a>
										</li>
										<li>
											<a href="all_users.php?access=4">
												<span class="title">Admins</span>
											</a>
										</li>
									</ul>
								</li>


							</ul>
						</li>
					<?php

					}

					?>

					<li class="has-sub">

						<a href="#">
							<i class="entypo-layout"></i>
							<span class="title">Look Up Tables</span>
						</a>

						<ul>
							<?php

							if (in_array(4, $user_type_arr)) {

							?>
								<li class="has-sub">
									<a href="#">
										<i class="entypo-book"></i>
										<span class="title">Genres</span>
									</a>
									<ul>
										<li>
											<a href="add_genres.php">
												<span class="title">Add Genres</span>
											</a>
										</li>

										<li>
											<a href="all_genres.php">
												<span class="title">All Genres</span>
											</a>
										</li>

									</ul>
								</li>
							<?php
							}

							?>



							<?php

							if (in_array(4, $user_type_arr)) {

							?>
								<li class="has-sub">
									<a href="#">
										<i class="entypo-star"></i>
										<span class="title">Show Names</span>
									</a>
									<ul>
										<li>
											<a href="add_show_names.php">
												<span class="title">Add Show Names</span>
											</a>
										</li>

										<li>
											<a href="all_show_names.php">
												<span class="title">All Show Names</span>
											</a>
										</li>

									</ul>
								</li>


							<?php
							}
							?>
						</ul>

					</li>
				</ul>
			</li>



			<li class="has-sub">

				<a href="#">
					<i class="entypo-layout"></i>
					<span class="title">DJ SETS ZONE</span>
				</a>

				<ul>

					<li class="has-sub">
						<a href="#">
							<i class="entypo-layout"></i>
							<span class="title">Artists</span>
						</a>
						<ul>
							<li>
								<a href="add_artists.php">
									<span class="title">Add Artists</span>
								</a>
							</li>

							<li>
								<a href="all_artists.php">
									<span class="title">All Artists</span>
								</a>
							</li>

						</ul>
					</li>



					<li class="has-sub">
						<a href="#">
							<i class="entypo-layout"></i>
							<span class="title">Songs</span>
						</a>
						<ul>
							<li>
								<a href="add_songs.php">
									<span class="title">Add Songs</span>
								</a>
							</li>

							<li>
								<a href="all_songs.php">
									<span class="title">All Songs</span>
								</a>
							</li>

						</ul>
					</li>


					<li class="has-sub">
						<a href="#">
							<i class="entypo-layout"></i>
							<span class="title">DJ Sets</span>
						</a>
						<ul>
							<li>
								<a href="add_dj_sets.php">
									<span class="title">Add DJ Sets</span>
								</a>
							</li>

							<li>
								<a href="all_dj_sets.php">
									<span class="title">All DJ Sets</span>
								</a>
							</li>

							<li>
								<a href="all_your_dj_sets.php">
									<span class="title">Your DJ Sets</span>
								</a>
							</li>

						</ul>
					</li>


					<li class="has-sub">
						<a href="#">
							<i class="entypo-layout"></i>
							<span class="title">Mix Tapes</span>
						</a>
						<ul>
							<li>
								<a href="add_mixtapes.php">
									<span class="title">Add Mixtapes</span>
								</a>
							</li>

							<!-- <li>
						<a href="edit_mixtapes.php">
							<span class="title">Edit Mixtapes</span>
						</a>
					</li> -->




						</ul>
					</li>


					<li class="has-sub">
						<a href="#">
							<i class="entypo-layout"></i>
							<span class="title">Show Episodes</span>
						</a>
						<ul>
							<li>
								<a href="add_show_episodes.php">
									<span class="title">Add Show Episodes</span>
								</a>
							</li>

							<li>
								<a href="all_show_episodes.php">
									<span class="title">All Show Episodes</span>
								</a>
							</li>

						</ul>
					</li>



				</ul>

			</li>







		</ul>

	</div>

</div>