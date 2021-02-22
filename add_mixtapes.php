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

    <title>Add Mixtape</title>
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


                        <!-- <th>Created at</th>
                        <th>Updated By</th>
                        <th>Updated at</th> -->
                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>
                    <?php


                    

                    $query = $conn->prepare(
                        "SELECT * from dj_sets 
                    "
                    );


                    $query->execute();


                    if ($query->rowCount()) {



                        $a = 1;

                        $i=1;


                        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                            if ($result["mixtape"] == NULL) {


                                $dj_set_id = $result["id"];




                    ?>

                                <tr>
                                    <td><?php echo $a++; ?></td>

                                    <td><?php echo "000" . $result["dj_set_episode"]; ?></td>



                                    <td><?php echo ucwords($result["set_name"]); ?></td>


                                    <?php



                                    $user_id = $_SESSION["user_id"];

                                    $query_mixtape = $conn->prepare("SELECT  mixtape from dj_sets");

                                    $query_mixtape->execute();


                                    $mixtape_arr = null;
                                    $ind = 0;

                                    $id = 1;
                                    if ($query_mixtape->rowCount() > 0) {

                                        while ($result_mixtape = $query_mixtape->fetch(PDO::FETCH_ASSOC)) {
                                            if ($result_mixtape["mixtape"] != NULL) {
                                                $mixtape_arr[$ind++] = $result_mixtape["mixtape"];
                                            }
                                        }

                                        // print_r($mixtape_arr[0]);

                                        if ($mixtape_arr != null) {

                                            // construct a new array
                                            $sorted_mixtape_arr = range(min($mixtape_arr), max($mixtape_arr));
                                            // use array_diff to find the missing elements 

                                            if (in_array(1, $sorted_mixtape_arr)) {
                                                $missing_seq_arr = array_diff($sorted_mixtape_arr, $mixtape_arr);


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
                                        } else {
                                            $mixtape_value = 1;
                                        }
                                    }

                                    // var_dump($mixtape_value);





                                    ?>

                                    <td><label class="text-danger" id="<?php  echo "taken-$dj_set_id"?>"></label><input class="form-control" oninput="mixtape_validation(<?php echo $dj_set_id ?>)" id="<?php echo "mixtape-$dj_set_id" ?>" type="number" name="mixtape" maxlength="4" min="<?php echo "$mixtape_value" ?>" required="" type="number" value="<?php echo "000" . $mixtape_value ?>"></td>
                                    <td><input class="form-control" id="<?php echo "mixtape_name-$dj_set_id" ?>" type="text" name="mixtape_name" value="<?php echo ucwords($result["mixtape_name"]); ?>"></td>
                                    <td><input class="form-control" id="<?php echo "url_yt-$dj_set_id" ?>" type="text" name="url_yt" value="<?php echo $result["url_yt"]; ?>"></td>
                                    <td><input class="form-control" id="<?php echo "url_sc-$dj_set_id" ?>" type="text" name="url_sc" value="<?php echo $result["url_sc"]; ?>"></td>

                                    <input type="hidden" name="dj_set_id" value="<?php echo $dj_set_id; ?>">


                                    <td>
                                        <a onclick="updateMixtape(<?php echo $dj_set_id ?>)" id="btn-update" name="mixtape_edit_btn" class="btn btn-default btn-sm btn-icon icon-left">
                                            <i class="entypo-pencil"></i>
                                            Update
                                        </a>


                                    </td>
                                    <?php


                                    ?>




                                </tr>






                    <?php

                                $i++;
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



    <script>
        function mixtape_validation(i) {
            $('#taken-' + i).text('');

            var value = document.getElementById("mixtape-" + i).value;


            if (value.length > this.maxLength) {
                value = value.slice(0, this.maxLength);
            }

            var taken_arr = <?php echo json_encode($mixtape_arr) ?>;

            taken_arr.sort(function(a, b){return a - b});

            console.log(taken_arr);

            var msg="*Mixtape ";
            var taken_val="";
            taken_arr.forEach(elem => {
                taken_val+= "#000"+elem+", ";
            });

            

            if (taken_arr != null) {

                if (taken_arr.includes(value)) {
                    document.getElementById("mixtape-" + i).value = "";
                    $('#taken-'+i).text(msg+taken_val+" Already Taken")
                }
            }
        }


        function updateMixtape(id) {

            var dj_set_id = id;

            var mixtape = $("#mixtape-" + id).val();
            var mixtape_name = $("#mixtape_name-" + id).val();
            var url_yt = $("#url_yt-" + id).val();
            var url_sc = $("#url_sc-" + id).val();

            console.log(mixtape);
            console.log(mixtape_name);
            console.log(url_yt);
            console.log(url_sc);
            $.ajax({
                type: "POST",
                url: "edit_mixtapes.php",
                data: {
                    dj_set_id: dj_set_id,
                    mixtape: mixtape,
                    mixtape_name: mixtape_name,
                    url_yt: url_yt,
                    url_sc: url_sc
                },

                success: function(data) {
                    console.log(data);

                    if(data=="success"){
                        window.location.href = "add_mixtapes.php?status=edit_succ";
                    }
                    else{
                        window.location.href = "add_mixtapes.php?status=edit_fail";
                    }
                }
            });

        }
    </script>

</body>

</html>