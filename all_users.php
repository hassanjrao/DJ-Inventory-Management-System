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

    <title>All Users</title>
</head>

<body class="page-body" data-url="http://neon.dev">

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
                    <a href="index.html"><i class="fa-home"></i>Home</a>
                </li>
                <li>

                    <a href="#">Users</a>
                </li>
                <li class="active">

                    <strong>All Users</strong>
                </li>
            </ol>

            <h2>All Users</h2>

            <?php

            if (isset($_GET["status"])) {

                if ($_GET["status"] == "edit_succ") {

            ?>
                    <br>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong>Congrats!</strong> Successfully Updated
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php

                } else if ($_GET["status"] == "edit_fail") {

                ?>
                    <br>
                    <div class="alert alert-success alert-danger" role="alert">
                        <strong>Congrats!</strong> Something Went Wrong, Update Failed
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                }
                if ($_GET["status"] == "del_succ") {

                ?>
                    <br>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong>Congrats!</strong> Successfully Deleted
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                }
                if ($_GET["status"] == "del_fail") {

                ?>
                    <br>
                    <div class="alert alert-success alert-danger" role="alert">
                        <strong>Congrats!</strong> Something Went Wrong, Deltetion Failed
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            <?php
                }
            }

            ?>


            <br />

         
            <script type="text/javascript">
				jQuery(document).ready(function ($) {
					var $table1 = jQuery('#table-2');

					// Initialize DataTable
					$table1.DataTable({
						"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
						"bStateSave": true
					});

					// Initalize Select Dropdown after DataTables is created
					$table1.closest('.dataTables_wrapper').find('select').select2({
						minimumResultsForSearch: -1
					});
				});
			</script>



            <!-- <h3>Table without DataTable Header</h3> -->


            <table class="table table-bordered datatable" id="table-2">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Name</th>
                        <th>Prefix</th>
                        <th>Status</th>
                        <th>Access</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>
                    <?php


                    $i = 1;

                    if (isset($_GET["access"])) {
                        $access = $_GET["access"];

                        $query = $conn->prepare(
                            "SELECT
                               users.*,
                               access.access,
                               user_access.user_id,
                               user_access.access_id
    
                             FROM users
                             JOIN user_access
                               ON users.id = user_access.user_id
                             JOIN access
                               ON access.id = user_access.access_id

                            Where access.id='$access'

                            
                            ORDER BY users.id desc
                            
                                   "
                        );
                    } else {
                        $query = $conn->prepare(
                            "SELECT
                               users.*,
                               access.access,
                               user_access.user_id,
                               user_access.access_id
    
                             FROM users
                             JOIN user_access
                               ON users.id = user_access.user_id
                             JOIN access
                               ON access.id = user_access.access_id

                            ORDER BY users.id desc
    
                            
                                   "
                        );
                    }

                    $query->execute();



                    while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                    ?>

                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $result["email"]; ?></td>
                            <td><?php echo $result["password"]; ?></td>

                            <td><?php echo $result["name"]; ?></td>
                            <td><?php echo $result["prefix"]; ?></td>
                            <td><?php echo $result["status"]; ?></td>
                            <td><?php echo $result["access"]; ?></td>
                            <td><?php echo $result["created"]; ?></td>
                            <td><?php echo $result["updated"]; ?></td>


                            <?php

                            if (isset($_GET["access"])) {
                            ?>

                                <td>
                                    <a href="edit_users.php?user_id=<?php echo $result["id"] . "&access=$access" ?>" class="btn btn-default btn-sm btn-icon icon-left">
                                        <i class="entypo-pencil"></i>
                                        Edit
                                    </a>

                                    <!-- <a href="delete_users.php?id=<?php //echo $result["id"] ?>" class="btn btn-danger btn-sm btn-icon icon-left">
                                        <i class="entypo-cancel"></i>
                                        Delete
                                    </a> -->

                                </td>
                            <?php
                            } else {

                            ?>
                                <td>
                                    <a href="edit_users.php?user_id=<?php echo $result["id"] ?>" class="btn btn-default btn-sm btn-icon icon-left">
                                        <i class="entypo-pencil"></i>
                                        Edit
                                    </a>

                                    <!-- <a href="delete_users.php?id=<?php //echo $result["id"] ?>" class="btn btn-danger btn-sm btn-icon icon-left">
                                        <i class="entypo-cancel"></i>
                                        Delete
                                    </a> -->

                                </td>
                            <?php
                            }
                            ?>


                        </tr>




                    <?php
                    }

                    ?>




                </tbody>
            </table>

            <br />


            <br />
            <!-- Footer starts -->
            <?php include_once("includes/footer.php"); ?>
            <!-- Footer end -->
        </div>




    </div>





    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="assets/js/datatables/datatables.css">
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="assets/js/select2/select2.css">

    <!-- Bottom scripts (common) -->
    <script src="assets/js/gsap/TweenMax.min.js"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/joinable.js"></script>
    <script src="assets/js/resizeable.js"></script>
    <script src="assets/js/neon-api.js"></script>


    <!-- Imported scripts on this page -->
    <script src="assets/js/datatables/datatables.js"></script>
    <script src="assets/js/select2/select2.min.js"></script>
    <script src="assets/js/neon-chat.js"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js"></script>



</body>

</html>