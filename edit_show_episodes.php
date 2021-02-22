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

    <title>Edit Show Episodes</title>
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

                    <a href="#">Show Episodess</a>
                </li>
                <li class="active">

                    <strong>Edit Show Episodes</strong>
                </li>
            </ol>

            <h2>Edit Show Episode</h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Edit Show Episode Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">



                            <?php

                            $user_id = $_SESSION["user_id"];
                            $show_episode_id = $_GET["show_episode_id"];

                            $query = $conn->prepare(
                                "SELECT show_episodes.*, show_names.show_name as show_name, users.name Creator, a.name Modifier
                                FROM show_episodes
                                JOIN show_names
                                On show_episodes.show_name=show_names.id
                                JOIN users
                                ON show_episodes.created_by=users.id
                                JOIN users a
                                ON show_episodes.updated_by=a.id
        
                                WHERE show_episodes.id='$show_episode_id'
                                
                               
                            "
                            );

                            $query->execute();

                            if ($query->rowCount() == 0) {
                                header("location: all_show_episodes.php");
                            }

                            $result = $query->fetch(PDO::FETCH_ASSOC);

                            ?>




                            <form role="form" method="post" class="form-horizontal form-groups-bordered">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Show Name</label>

                                    <div class="col-sm-5">
                                        <select class="form-control " name="show_name" required="">


                                            <?php

                                            $query_show_name = $conn->prepare("SELECT id,show_name FROM show_names");

                                            $query_show_name->execute();

                                            while ($result_show_name = $query_show_name->fetch(PDO::FETCH_ASSOC)) {

                                                $show_selected_arr[$ind++] = $result_show_name["id"];
                                            ?>
                                                <option selected value="<?php echo $result_show_name["id"] ?>"><?php echo ucwords($result_show_name["show_name"]) ?></option>
                                                <?php
                                            }

                                            $query_show_name = $conn->prepare("SELECT id,show_name FROM show_names");

                                            $query_show_name->execute();



                                            while ($result_show_name = $query_show_name->fetch(PDO::FETCH_ASSOC)) {


                                                if (!in_array($result_show_name["id"], $show_selected_arr)) {

                                                ?>

                                                    <option value="<?php echo $result_show_name["id"] ?>"><?php echo ucwords($result_show_name["show_name"]) ?></option>
                                            <?php
                                                }
                                            }

                                            ?>




                                        </select>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-sm-3 control-label">DJ Sets</label>

                                    <div class="col-sm-5">
                                        <select class="form-control " multiple name="dj_sets[]" required="">

                                            <?php

                                            $query_dj_sets = $conn->prepare(
                                                "SELECT dj_sets.id,dj_sets.set_name 
                                                 FROM dj_sets
                                                 JOIN show_episode_djs
                                                 ON show_episode_djs.dj_set_id=dj_sets.id
                                                 Where show_episode_djs.show_episode_id='$show_episode_id'"
                                            );
                                            $query_dj_sets->execute();

                                            $ind = 0;


                                            while ($result_dj_sets = $query_dj_sets->fetch(PDO::FETCH_ASSOC)) {

                                                $djs_selected_arr[$ind++] = $result_dj_sets["id"];
                                            ?>
                                                <option selected value="<?php echo $result_dj_sets["id"] ?>"><?php echo ucwords($result_dj_sets["set_name"]) ?></option>
                                                <?php
                                            }

                                            $query_dj_set_names = $conn->prepare("SELECT id,set_name FROM dj_sets");

                                            $query_dj_set_names->execute();



                                            while ($result_dj_set_names = $query_dj_set_names->fetch(PDO::FETCH_ASSOC)) {


                                                if (!in_array($result_dj_set_names["id"], $djs_selected_arr)) {

                                                ?>

                                                    <option value="<?php echo $result_dj_set_names["id"] ?>"><?php echo ucwords($result_dj_set_names["set_name"]) ?></option>
                                            <?php
                                                }
                                            }

                                            ?>



                                        </select>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Episode Name</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="episode_name" value="<?php echo $result["episode_name"]; ?>" class="form-control" id="field-1" placeholder="Episode Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Main Host</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="main_host" value="<?php echo $result["main_host"]; ?>" class="form-control" id="field-1" placeholder="Main Host">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Co-Host</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="co_host" value="<?php echo $result["co_host"]; ?>" class="form-control" id="field-1" placeholder="Co-Host">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Guests</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="guests" value="<?php echo $result["guests"]; ?>" class="form-control" id="field-1" placeholder="Guests">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Produced By</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="produced_by" value="<?php echo $result["produced_by"]; ?>" class="form-control" id="field-1" placeholder="Produced By">
                                    </div>
                                </div>




                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Status</label>

                                    <div class="col-sm-5">

                                        <?php

                                        $status_arr = ["Planning", "In Production", "Completed"];

                                        ?>

                                        <select name="status" class="form-control" required="">

                                            <option selected><?php echo $result["status"] ?></option>
                                            <?php
                                            foreach ($status_arr as $key => $status) {
                                                # code...
                                                if ($result["status"] != $status) {

                                            ?>
                                                    <option><?php echo $status ?></option>

                                            <?php
                                                }
                                            }
                                            ?>

                                        </select>

                                    </div>
                                </div>








                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Notes/Comments</label>

                                    <div class="col-sm-5">
                                        <textarea required="" name="notes" class="form-control" id="field-1" placeholder="Notes/Comments"><?php echo $result["notes"] ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tags</label>

                                    <div class="col-sm-5">

                                        <input type="text" required="" name="tags" value="<?php echo $result["tags"] ?>" placeholder="Add Tags" class="form-control tagsinput" />

                                    </div>
                                </div>






                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">URL YT</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="url_yt" value="<?php echo $result["url_yt"] ?>" class="form-control" id="field-1" placeholder="URL YT">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">URL SC</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="url_sc" value="<?php echo $result["url_sc"] ?>" class="form-control" id="field-1" placeholder="URL SC">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Plateform</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="plateform" value="<?php echo $result["plateform"] ?>" class="form-control" id="field-1" placeholder="Plateform">
                                    </div>
                                </div>








                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" name="submit" class="btn btn-default">Edit Show episodes</button>
                                    </div>
                                </div>
                            </form>

                            <?php

                            if (isset($_POST['submit'])) {


                                $dj_sets_arr = $_POST["dj_sets"];

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



                                $updated_by = $_SESSION["user_id"];


                                $stmt = $conn->prepare("UPDATE `show_episodes` SET show_name=:show_name,episode_name=:episode_name,main_host=:main_host,co_host=:co_host,guests=:guests,produced_by=:produced_by,status=:status,notes=:notes,tags=:tags,url_yt=:url_yt,url_sc=:url_sc,plateform=:plateform ,updated_by=:updated_by ,updated=CURRENT_TIMESTAMP WHERE id=:id");

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

                                $stmt->bindParam(':updated_by', $updated_by);

                                $stmt->bindParam(':id', $show_episode_id);

                                $stmt->execute();



                                $del = $conn->prepare("DELETE FROM show_episode_djs WHERE show_episode_id='$show_episode_id'");
                                $del->execute();

                                foreach ($dj_sets_arr as $key => $dj_set) {

                                    $stmt = $conn->prepare("INSERT INTO `show_episode_djs`( `show_episode_id`,`dj_set_id`) VALUES (:show_episode_id,:dj_set_id)");
                                    $stmt->bindParam(':show_episode_id', $show_episode_id);
                                    $stmt->bindParam(':dj_set_id', $dj_set);
                                    $stmt->execute();
                                }


                                header("location: all_show_episodes.php?status=edit_succ");
                            }
                            ?>


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
        function episode_validation() {
            $('#taken').text('');

            var value = document.getElementById("episode_number").value;


            if (value.length > this.maxLength) {
                value = value.slice(0, this.maxLength);
            }

            var taken_arr = <?php echo json_encode($dj_set_episode_arr) ?>;

            console.log(taken_arr);

            if (taken_arr != null) {

                if (taken_arr.includes(value)) {
                    document.getElementById("episode_number").value = "";
                    $('#taken').text('*Episode #000' + value + ' is Already Taken')
                }
            }
        }
    </script>

</body>

</html>