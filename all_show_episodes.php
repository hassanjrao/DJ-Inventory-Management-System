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

    <title>All Show Episodes</title>
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

                    <a href="#">DJ Sets</a>
                </li>
                <li class="active">

                    <strong>All DJ Sets</strong>
                </li>
            </ol>

            <h2>All DJ Sets</h2>

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
                jQuery(document).ready(function($) {
                    var $table1 = jQuery('#table-2');

                    // Initialize DataTable
                    $table1.DataTable({
                        "aLengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        "bStateSave": true,
                        responsive: true
                    });

                    // Initalize Select Dropdown after DataTables is created
                    $table1.closest('.dataTables_wrapper').find('select').select2({
                        minimumResultsForSearch: -1
                    });
                });
            </script>



            <!-- <h3>Table without DataTable Header</h3> -->


            <table class="table table-bordered datatable wrap" id="table-2">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Created By</th>
                        <th>Show Name</th>
                        <th>DJ Sets</th>

                        <th>Show Episode Number</th>
                        <th>Episode Name</th>
                        <th>Main Host</th>
                        <th>Co-Host</th>
                        <th>Guests</th>
                        <th>Produced By</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Tags</th>

                        <th>URL YT</th>
                        <th>URL SC</th>
                        <th>Plateform</th>


                        <th>Created at</th>
                        <th>Updated By</th>
                        <th>Updated at</th>
                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>
                    <?php


                    $i = 1;




                    $query = $conn->prepare(
                        "SELECT show_episodes.*, show_names.show_name as show_name, users.name Creator, a.name Modifier
                        FROM show_episodes
                        JOIN show_names
                        On show_episodes.show_name=show_names.id
                        JOIN users
                        ON show_episodes.created_by=users.id
                        JOIN users a
                        ON show_episodes.updated_by=a.id

                        ORDER BY show_episodes.created_by asc
                        
                       
                    "
                    );
                    $query->execute();




                    while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                        $show_episode_id = $result["id"];


                        $query_show_djs = $conn->prepare("SELECT * FROM show_episode_djs where show_episode_id='$show_episode_id'");
                        $query_show_djs->execute();

                        $ind = 0;

                        while ($result_show_djs = $query_show_djs->fetch(PDO::FETCH_ASSOC)) {



                            $dj_set_id = $result_show_djs["dj_set_id"];



                            $query_dj_set_names = $conn->prepare("SELECT * FROM dj_sets where id='$dj_set_id'");
                            $query_dj_set_names->execute();

                            while ($result_dj_set_names = $query_dj_set_names->fetch(PDO::FETCH_ASSOC)) {

                                $dj_set_names_arr[$ind++] = $result_dj_set_names["set_name"];
                            }
                        }


                    ?>

                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo ucwords($result["Creator"]); ?></td>
                            <td><?php echo ucwords($result["show_name"]); ?></td>

                            <td><?php


                                // var_dump($song_name_arr);
                                foreach ($dj_set_names_arr as $key => $set_name) {
                                    # code...
                                    echo ucwords($set_name) . "<br><hr>";
                                }

                                ?></td>

                            <td><?php echo "000" . $result["show_episode_number"]; ?></td>




                            <td><?php echo ucwords($result["episode_name"]); ?></td>
                            <td><?php echo $result["main_host"]; ?></td>
                            <td><?php echo $result["co_host"]; ?></td>
                            <td><?php echo $result["guests"]; ?></td>
                            <td><?php echo $result["produced_by"]; ?></td>
                            <td><?php echo ucwords($result["status"]); ?></td>

                            <td><?php echo ucfirst($result["notes"]); ?></td>
                            <td><?php echo ucwords($result["tags"]); ?></td>
                            <td><?php echo $result["url_yt"]; ?></td>
                            <td><?php echo $result["url_sc"]; ?></td>

                            <td><?php echo $result["plateform"]; ?></td>

                            <td><?php echo $result["created"]; ?></td>
                            <td><?php echo ucwords($result["Modifier"]); ?></td>
                            <td><?php echo $result["updated"]; ?></td>





                            <?php

                            // if (isset($_GET["access"])) {
                            ?>

                            <!-- <td> -->


                            <!-- <a href="delete_dj sets.php?id=<?php //echo $result["id"] 
                                                                ?>" class="btn btn-danger btn-sm btn-icon icon-left">
                                    <i class="entypo-cancel"></i>
                                    Delete
                                </a> -->

                            <!-- </td> -->
                            <?php
                            // } else {

                            ?>
                            <td>
                                <a href="edit_show_episodes.php?show_episode_id=<?php echo $result["id"]?>" class="btn btn-default btn-sm btn-icon icon-left">
                                    <i class="entypo-pencil"></i>
                                    Edit
                                </a>

                                <a href="delete_show_episodes.php?id=<?php //echo $result["id"] 
                                                                        ?>" class="btn btn-danger btn-sm btn-icon icon-left">
                                    <i class="entypo-cancel"></i>
                                    Delete
                                </a>

                            </td>
                            <?php
                            // }
                            ?>


                        </tr>





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