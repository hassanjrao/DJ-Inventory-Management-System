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

    <title>All DJ Sets</title>
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
                        <th>DJ Set Episode</th>
                        <!-- <th>Songs</th> -->
                        <th>DJ Set Name</th>
                        <!-- <th>BPM Start</th> -->
                        <!-- <th>BPM End</th>
                        <th>Key Start</th>
                        <th>Key End</th>
                        <th>Genre</th>
                        <th>Set Duration</th>
                        <th>Viloence, Drugs, Guns</th>
                        <th>Explicit Lyrical Content</th>
                        <th>Notes</th>
                        <th>Tags</th> -->
                        <th>Mixtape #</th>
                        <th>Mixtape Name</th>
                        <th>URL YT</th>
                        <th>URL SC</th>


                        <th>Created at</th>
                        <th>Updated By</th>
                        <th>Updated at</th>
                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>
                    <?php


                    $i = 1;




                    // $query = $conn->prepare(
                    //     "SELECT dj_sets.*, genres.name as genre_name, users.name Creator, a.name Modifier
                    //     FROM dj_sets
                    //     JOIN genres
                    //     On dj_sets.genre=genres.id
                    //     JOIN users
                    //     ON dj_sets.created_by=users.id
                    //     JOIN users a
                    //     ON dj_sets.updated_by=a.id

                    //     WHERE dj_sets.mixtape=NULL


                    // "
                    // );

                    $query = $conn->prepare(
                        "SELECT dj_sets.*, users.name Creator, a.name Modifier
                        FROM dj_sets
                        JOIN users
                        ON dj_sets.created_by=users.id
                        JOIN users a
                        ON dj_sets.updated_by=a.id

                       
                    "
                    );


                    $query->execute();


                    if ($query->rowCount()) {


                        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                            if ($result["mixtape"] == NULL) {



                                $dj_set_id = $result["id"];


                                $query_s_art = $conn->prepare("SELECT * FROM dj_set_songs where dj_set_id='$dj_set_id'");
                                $query_s_art->execute();

                                $ind = 0;

                                while ($result_s_art = $query_s_art->fetch(PDO::FETCH_ASSOC)) {



                                    $song_id = $result_s_art["song_id"];



                                    $query_song_name = $conn->prepare("SELECT * FROM songs where id='$song_id'");
                                    $query_song_name->execute();

                                    while ($result_song_name = $query_song_name->fetch(PDO::FETCH_ASSOC)) {

                                        $song_name_arr[$ind++] = $result_song_name["song_name"];
                                    }
                                }


                    ?>

                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo ucwords($result["Creator"]); ?></td>
                                    <td><?php echo "000" . $result["mixtape"]; ?></td>
                                    <!-- <td><?php


                                                // var_dump($song_name_arr);
                                                foreach ($song_name_arr as $key => $song) {
                                                    # code...
                                                    echo ucwords($song) . "<br><hr>";
                                                }

                                                ?></td> -->



                                    <td><?php echo ucwords($result["set_name"]); ?></td>

                                    <form action="edit_mixtapes.php" method="POST">

                                        <?php



                                        $user_id = $_SESSION["user_id"];

                                        $query = $conn->prepare("SELECT  mixtape from dj_sets where created_by='$user_id'");

                                        $query->execute();


                                        $mixtape_arr = null;
                                        $ind = 0;
                                        if ($query->rowCount() > 0) {

                                            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                                                $mixtape_arr[$ind++] = $result["mixtape"];
                                            }

                                            // construct a new array
                                            $sorted_episode_arr = range(min($mixtape_arr), max($mixtape_arr));
                                            // use array_diff to find the missing elements 
                                            $missing_seq_arr = array_diff($sorted_episode_arr, $mixtape_arr);


                                            if (count($missing_seq_arr) > 0) {
                                                $least_value = min($missing_seq_arr);
                                            } else {
                                                if (count($mixtape_arr) == 1 && $mixtape_arr[0] != 1) {
                                                    $least_value = 1;
                                                } else {
                                                    $least_value = max($mixtape_arr) + 1;
                                                }
                                            }




                                            $mixtape_value = $least_value;
                                        } else {
                                            $mixtape_value = 1;
                                        }





                                        ?>

                                        <td><input class="form-control" oninput="episode_validation()" type="number" name="mixtape" maxlength="4" min="<?php echo "000" . $mixtape_value ?>" required="" type="number" value="<?php echo "000" . $mixtape_value ?>"></td>
                                        <td><input class="form-control" type="text" name="mixtape_name" value="<?php echo ucwords($result["mixtape_name"]); ?>"></td>
                                        <td><input class="form-control" type="text" name="url_yt" value="<?php echo $result["url_yt"]; ?>"></td>
                                        <td><input class="form-control" type="text" name="url_sc" value="<?php echo $result["url_sc"]; ?>"></td>

                                        <input type="hidden" name="dj_set_id" value="<?php echo $dj_set_id; ?>">


                                        <td><?php echo $result["created"]; ?></td>
                                        <td><?php echo ucwords($result["Modifier"]); ?></td>
                                        <td><?php echo $result["updated"]; ?></td>





                                        <?php

                                        // if (isset($_GET["access"])) {
                                        ?>

                                        <td>
                                            <button type="submit" name="mixtape_edit_btn" class="btn btn-default btn-sm btn-icon icon-left">
                                                <i class="entypo-pencil"></i>
                                                Update
                                            </button>


                                            <!-- <a href="delete_dj sets.php?id=<?php //echo $result["id"] 
                                                                                ?>" class="btn btn-danger btn-sm btn-icon icon-left">
                                    <i class="entypo-cancel"></i>
                                    Delete
                                </a> -->

                                        </td>
                                    </form>
                                    <?php
                                    // } else {

                                    ?>
                                    <!-- <td>
                                <a href="edit_users.php?user_id=<?php //echo $result["id"] 
                                                                ?>" class="btn btn-default btn-sm btn-icon icon-left">
                                    <i class="entypo-pencil"></i>
                                    Edit
                                </a>

                                <a href="delete_users.php?id=<?php //echo $result["id"] 
                                                                ?>" class="btn btn-danger btn-sm btn-icon icon-left">
                                    <i class="entypo-cancel"></i>
                                    Delete
                                </a>

                            </td> -->
                                    <?php
                                    // }
                                    ?>


                                </tr>





                                </tr>





                    <?php
                            }
                        }
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