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

    <title>Add Show Episodes</title>
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

                    <a href="#">Show Episodes</a>
                </li>
                <li class="active">

                    <strong>Add Show Episodes</strong>
                </li>
            </ol>

            <h2>Add Show Episode</h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Add Show Episode Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">

                            <?php

                            if (isset($_POST['submit'])) {


                                $dj_sets_arr = $_POST["dj_sets"];

                                $show_episode_number = $_POST["show_episode_number"];
                                $show_name = $_POST["show_name"];
                                $episode_name = $_POST["episode_name"];
                                $main_host = $_POST["main_host"];
                                $co_host = $_POST["co_host"];
                                $guests = $_POST["guests"];
                                $produced_by = $_POST["produced_by"];
                                $status = $_POST["status"];




                                $notes = $_POST["notes"];
                                $tags = $_POST["tags"];


                                $url_yt = $_POST["url_yt"];
                                $url_sc = $_POST["url_sc"];

                                $plateform = $_POST["plateform"];


                                $created_by = $_SESSION["user_id"];
                                $updated_by = $created_by;

                                $stmt = $conn->prepare("INSERT INTO `show_episodes`(`show_episode_number`,`show_name`,`episode_name`,`main_host`,`co_host`,`guests`,`produced_by`,`status`,`notes`,`tags`,`url_yt`,`url_sc`,`plateform`,`created_by`,`updated_by`,`created`,`updated`) 
                                VALUES (:show_episode_number,:show_name,:episode_name,:main_host,:co_host,:guests,:produced_by,:status,:notes,:tags,:url_yt,:url_sc,:plateform,:created_by,:updated_by ,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)");


                                $stmt->bindParam(':show_episode_number', $show_episode_number);
                                $stmt->bindParam(':show_name', $show_name);
                                $stmt->bindParam(':episode_name', $episode_name);
                                $stmt->bindParam(':main_host', $main_host);
                                $stmt->bindParam(':co_host', $co_host);
                                $stmt->bindParam(':guests', $guests);
                                $stmt->bindParam(':produced_by', $produced_by);
                                $stmt->bindParam(':status', $status);


                                $stmt->bindParam(':notes', $notes);
                                $stmt->bindParam(':tags', $tags);

                                $stmt->bindParam(':url_yt', $url_yt);
                                $stmt->bindParam(':url_sc', $url_sc);

                                $stmt->bindParam(':plateform', $plateform);

                                $stmt->bindParam(':created_by', $created_by);
                                $stmt->bindParam(':updated_by', $updated_by);

                                if ($stmt->execute()) {

                                    $show_episode_id = $conn->lastInsertId();

                                    foreach ($dj_sets_arr as $key => $dj_set) {

                                        $stmt = $conn->prepare("INSERT INTO `show_episode_djs`( `show_episode_id`,`dj_set_id`) VALUES (:show_episode_id,:dj_set_id)");
                                        $stmt->bindParam(':show_episode_id', $show_episode_id);
                                        $stmt->bindParam(':dj_set_id', $dj_set);
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

                                } else {
                                ?>
                                    <br>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <strong>Oops!</strong> Some Error Occured
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <br>

                            <?php
                                }
                            }

                            ?>


                            <form role="form" method="post" class="form-horizontal form-groups-bordered">




                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Show Name</label>

                                    <div class="col-sm-5">
                                        <select class="form-control " name="show_name" required="">

                                            <?php

                                            $query = $conn->prepare("SELECT id,show_name FROM show_names");

                                            $query->execute();

                                            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                                            ?>
                                                <option value="<?php echo $result["id"] ?>"><?php echo ucwords($result["show_name"]) ?></option>
                                            <?php
                                            }


                                            ?>



                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Dj Sets</label>

                                    <div class="col-sm-5">
                                        <select class="form-control" multiple name="dj_sets[]" required="">

                                            <?php

                                            $query = $conn->prepare("SELECT id,set_name FROM dj_sets");

                                            $query->execute();

                                            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                                            ?>
                                                <option value="<?php echo $result["id"] ?>"><?php echo ucwords($result["set_name"]) ?></option>
                                            <?php
                                            }


                                            ?>



                                        </select>
                                    </div>
                                </div>





                                <div class="form-group">
                                    <?php

                                    $user_id = $_SESSION["user_id"];

                                    $query = $conn->prepare("SELECT  show_episode_number from show_episodes where created_by='$user_id'");

                                    $query->execute();


                                    $show_episode_arr = null;
                                    $ind = 0;
                                    if ($query->rowCount() > 0) {

                                        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                                            $show_episode_arr[$ind++] = $result["show_episode_number"];
                                        }

                                        // construct a new array
                                        $sorted_episode_arr = range(min($show_episode_arr), max($show_episode_arr));
                                        // use array_diff to find the missing elements 

                                        if (in_array(1, $sorted_episode_arr)) {
                                            $missing_seq_arr = array_diff($sorted_episode_arr, $show_episode_arr);


                                            if (count($missing_seq_arr) > 0) {
                                                $least_value = min($missing_seq_arr);
                                            } else {
                                                if (count($show_episode_arr) == 1 && $show_episode_arr[0] != 1) {
                                                    $least_value = 1;
                                                } else {
                                                    $least_value = max($show_episode_arr) + 1;
                                                }
                                            }


                                            $show_episode_value = $least_value;
                                        } else {
                                            $show_episode_value = 1;
                                        }
                                    } else {
                                        $show_episode_value = 1;
                                    }


                                    ?>

                                    <label for="field-1" class="col-sm-3 control-label">Show Episode Number</label>

                                    <div class="col-sm-5">
                                        <label id="taken" class="text-danger"></label>
                                        <input oninput="show_episode_validation()" type="number" maxlength="4" min="<?php echo "000" . $show_episode_value ?>" required="" type="number" value="<?php echo "000" . $show_episode_value ?>" name="show_episode_number" class="form-control" id="show_episode_number" placeholder="Show Episode Number">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Episode Name</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="episode_name" class="form-control" id="field-1" placeholder="Episode Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Main Host</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="main_host" class="form-control" id="field-1" placeholder="Main Host">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Co-Host</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="co_host" class="form-control" id="field-1" placeholder="Co-Host">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Guests</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="guests" class="form-control" id="field-1" placeholder="Guests">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Produced By</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="produced_by" class="form-control" id="field-1" placeholder="Produced By">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Status</label>

                                    <div class="col-sm-5">

                                        <select name="status" class="form-control" required="">
                                            <option>Planning</option>
                                            <option>In Production</option>
                                            <option>Completed</option>
                                        </select>
                                       
                                    </div>
                                </div>





                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Notes/Comments</label>

                                    <div class="col-sm-5">
                                        <textarea required="" name="notes" class="form-control" id="field-1" placeholder="Notes/Comments"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tags</label>

                                    <div class="col-sm-5">

                                        <input type="text" required="" name="tags" placeholder="Add Tags" class="form-control tagsinput" />

                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">URL YT</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="url_yt" class="form-control" id="field-1" placeholder="URL YT">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">URL SC</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="url_sc" class="form-control" id="field-1" placeholder="URL SC">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Plateform</label>

                                    <div class="col-sm-5">
                                        <select name="plateform" required="" class="form-control">
                                            <option>Scheduled Live Air Date</option>
                                            <option>Date Sent to Platform</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" name="submit" class="btn btn-default">Add show episode</button>
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


    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="assets/js/select2/select2.css">
    <link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">
    <link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="assets/js/icheck/skins/minimal/_all.css">
    <link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css">
    <link rel="stylesheet" href="assets/js/icheck/skins/flat/_all.css">
    <link rel="stylesheet" href="assets/js/icheck/skins/futurico/futurico.css">
    <link rel="stylesheet" href="assets/js/icheck/skins/polaris/polaris.css">

    <!-- Imported scripts on this page -->
    <script src="assets/js/select2/select2.min.js"></script>
    <script src="assets/js/bootstrap-tagsinput.min.js"></script>
    <script src="assets/js/typeahead.min.js"></script>
    <script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/bootstrap-timepicker.min.js"></script>
    <script src="assets/js/bootstrap-colorpicker.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/daterangepicker/daterangepicker.js"></script>
    <script src="assets/js/jquery.multi-select.js"></script>
    <script src="assets/js/icheck/icheck.min.js"></script>
    <script src="assets/js/neon-chat.js"></script>

    <!-- JavaScripts initializations and stuff -->
    <script src="assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js"></script>


    <script>
        function show_episode_validation() {
            $('#taken').text('');

            var value = document.getElementById("show_episode_number").value;


            if (value.length > this.maxLength) {
                value = value.slice(0, this.maxLength);
            }

            var taken_arr = <?php echo json_encode($show_episode_arr) ?>;

            taken_arr.sort(function(a, b) {
                return a - b
            });

            console.log(taken_arr);

            var msg = "*Show Episode ";
            var taken_val = "";
            taken_arr.forEach(elem => {
                taken_val += "#000" + elem + ", ";
            });

            if (taken_arr != null) {

                if (taken_arr.includes(value)) {
                    document.getElementById("show_episode_number").value = "";
                    $('#taken').text(msg + taken_val + " Already Taken");
                }
            }
        }
    </script>

</body>

</html>