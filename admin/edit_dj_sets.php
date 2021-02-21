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

    <title>Edit DJ Set</title>
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

                    <a href="#">DJ Sets</a>
                </li>
                <li class="active">

                    <strong>Edit DJ Set</strong>
                </li>
            </ol>

            <h2>Edit DJ Set</h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Edit DJ Set Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">



                            <?php

                            $user_id = $_SESSION["user_id"];
                            $dj_set_id = $_GET["dj_set_id"];


                            $query = $conn->prepare(
                                "SELECT dj_sets.*, genres.name as genre_name, users.name Creator, a.name Modifier
                                FROM dj_sets
                                JOIN genres
                                On dj_sets.genre=genres.id
                                JOIN users
                                ON dj_sets.created_by=users.id
                                JOIN users a
                                ON dj_sets.updated_by=a.id
        
                                WHERE dj_sets.id='$dj_set_id' AND dj_sets.created_by='$user_id'
                               
                            "
                            );

                            $query->execute();

                            if ($query->rowCount() == 0) {
                                header("location: all_your_dj_sets.php");
                            }

                            $result = $query->fetch(PDO::FETCH_ASSOC);

                            ?>




                            <form role="form" method="post" class="form-horizontal form-groups-bordered">






                                <div class="form-group">
                                    <label class="col-sm-3 control-label">songs</label>

                                    <div class="col-sm-5">
                                        <select class="form-control " multiple name="songs[]" required="">

                                            <?php

                                            $query_song_name = $conn->prepare(
                                                "SELECT songs.id,songs.song_name 
                                                FROM songs
                                                JOIN dj_set_songs
                                                ON dj_set_songs.song_id=songs.id
                                                Where dj_set_songs.dj_set_id='$dj_set_id'"
                                            );

                                            $query_song_name->execute();

                                            $ind = 0;


                                            while ($result_song_name = $query_song_name->fetch(PDO::FETCH_ASSOC)) {

                                                $songs_selected_arr[$ind++] = $result_song_name["id"];
                                            ?>
                                                <option selected value="<?php echo $result_song_name["id"] ?>"><?php echo ucwords($result_song_name["song_name"]) ?></option>
                                                <?php
                                            }

                                            $query_songs = $conn->prepare("SELECT id,song_name FROM songs");

                                            $query_songs->execute();



                                            while ($result_songs = $query_songs->fetch(PDO::FETCH_ASSOC)) {


                                                if (!in_array($result_songs["id"], $songs_selected_arr)) {

                                                ?>

                                                    <option value="<?php echo $result_songs["id"] ?>"><?php echo ucwords($result_songs["song_name"]) ?></option>
                                            <?php
                                                }
                                            }

                                            ?>



                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Set Name</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="set_name" value="<?php echo $result["set_name"]; ?>" class="form-control" id="field-1" placeholder="Set Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">BPM Start</label>

                                    <div class="col-sm-5">
                                        <input required="" type="number" name="bpm_start" value="<?php echo $result["bpm_start"]; ?>" class="form-control" id="field-1" placeholder="BPM Start">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">BPM End</label>

                                    <div class="col-sm-5">
                                        <input required="" type="number" name="bpm_end" value="<?php echo $result["bpm_end"]; ?>" class="form-control" id="field-1" placeholder="BPM End">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Key Start</label>

                                    <div class="col-sm-5">
                                        <select class="form-control" name="key_start" required="">
                                            <option>1A</option>
                                            <option>2A</option>
                                            <option>3A</option>
                                            <option>4A</option>
                                            <option>5A</option>
                                            <option>6A</option>
                                            <option>7A</option>
                                            <option>8A</option>
                                            <option>9A</option>
                                            <option>10A</option>
                                            <option>11A</option>
                                            <option>12A</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Key End</label>

                                    <div class="col-sm-5">
                                        <select class="form-control" name="key_end" required="">
                                            <option>1B</option>
                                            <option>2B</option>
                                            <option>3B</option>
                                            <option>4B</option>
                                            <option>5B</option>
                                            <option>6B</option>
                                            <option>7B</option>
                                            <option>8B</option>
                                            <option>9B</option>
                                            <option>10B</option>
                                            <option>11B</option>
                                            <option>12B</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Genre</label>

                                    <div class="col-sm-5">
                                        <select class="form-control" name="genre" required="">
                                            <option selected value="<?php echo $result["genre"] ?>"><?php echo ucwords($result["genre_name"]) ?></option>
                                            <?php

                                            $query_genre = $conn->prepare("SELECT id,name FROM genres");

                                            $query_genre->execute();

                                            while ($result_genre = $query_genre->fetch(PDO::FETCH_ASSOC)) {

                                                if ($result["genre"] != $result_genre["id"]) {

                                            ?>
                                                    <option value="<?php echo $result_genre["id"] ?>"><?php echo ucwords($result_genre["name"]) ?></option>
                                            <?php
                                                }
                                            }


                                            ?>

                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Set Duration</label>

                                    <div class="col-sm-5">
                                        <input required="" type="number" name="set_duration" value="<?php echo $result["set_duration"]; ?>" class="form-control" id="field-1" placeholder="Set Duration">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <div class="checkbox">
                                            <label>
                                                <input name="viloence_drugs_guns" <?php echo $result["viloence_drugs_guns"] == "yes" ? "checked" : ""; ?> value="yes" type="checkbox">Viloence, Drugs, Guns
                                            </label>
                                        </div>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <div class="checkbox">
                                            <label>
                                                <input name="explicit_lyrical_content" <?php echo $result["explicit_lyrical_content"] == "yes" ? "checked" : ""; ?> value="yes" type="checkbox">Explicit Lyrical Content
                                            </label>
                                        </div>


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
                                    <label for="field-1" class="col-sm-3 control-label">MixTape #</label>

                                    <div class="col-sm-5">
                                        <input required="" type="number" name="mixtape" value="<?php echo $result["mixtape"] ?>" class="form-control" id="field-1" placeholder="Mix Tape #">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">MixTape Name</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="mixtape_name" value="<?php echo $result["mixtape_name"] ?>" class="form-control" id="field-1" placeholder="MixTape Name">
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
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" name="submit" class="btn btn-default">Edit DJ Set</button>
                                    </div>
                                </div>
                            </form>

                            <?php

                            if (isset($_POST['submit'])) {


                                $songs_arr = $_POST["songs"];

                                $set_name = $_POST["set_name"];
                                $bpm_start = $_POST["bpm_start"];
                                $bpm_end = $_POST["bpm_end"];
                                $key_start = $_POST["key_start"];
                                $key_end = $_POST["key_end"];
                                $genre = $_POST["genre"];
                                $set_duration = $_POST["set_duration"];


                                $viloence_drugs_guns = isset($_POST["viloence_drugs_guns"]) == true ? $_POST["viloence_drugs_guns"] : "no";
                                $explicit_lyrical_content = isset($_POST["explicit_lyrical_content"]) == true ? $_POST["explicit_lyrical_content"] : "no";

                                $notes = $_POST["notes"];
                                $tags = $_POST["tags"];

                                $mixtape = $_POST["mixtape"];
                                $mixtape_name = $_POST["mixtape_name"];

                                $url_yt = $_POST["url_yt"];
                                $url_sc = $_POST["url_sc"];


                                $updated_by = $_SESSION["user_id"];


                                $stmt = $conn->prepare("UPDATE `dj_sets` SET set_name=:set_name,bpm_start=:bpm_start,bpm_end=:bpm_end,key_start=:key_start,key_end=:key_end,genre=:genre,set_duration=:set_duration,viloence_drugs_guns=:viloence_drugs_guns,explicit_lyrical_content=:explicit_lyrical_content,notes=:notes,tags=:tags,mixtape=:mixtape,mixtape_name=:mixtape_name,url_yt=:url_yt,url_sc=:url_sc ,updated_by=:updated_by ,updated=CURRENT_TIMESTAMP WHERE id=:id");

                                $stmt->bindParam(':set_name', $set_name);
                                $stmt->bindParam(':bpm_start', $bpm_start);
                                $stmt->bindParam(':bpm_end', $bpm_end);
                                $stmt->bindParam(':key_start', $key_start);
                                $stmt->bindParam(':key_end', $key_end);
                                $stmt->bindParam(':genre', $genre);
                                $stmt->bindParam(':set_duration', $set_duration);
                                $stmt->bindParam(':viloence_drugs_guns', $viloence_drugs_guns);
                                $stmt->bindParam(':explicit_lyrical_content', $explicit_lyrical_content);
                                $stmt->bindParam(':notes', $notes);
                                $stmt->bindParam(':tags', $tags);
                                $stmt->bindParam(':mixtape', $mixtape);
                                $stmt->bindParam(':mixtape_name', $mixtape_name);
                                $stmt->bindParam(':url_yt', $url_yt);
                                $stmt->bindParam(':url_sc', $url_sc);

                                $stmt->bindParam(':updated_by', $updated_by);

                                $stmt->bindParam(':id', $dj_set_id);

                                $stmt->execute();



                                $del = $conn->prepare("DELETE FROM dj_set_songs WHERE dj_set_id='$dj_set_id'");
                                $del->execute();

                                foreach ($songs_arr as $key => $song) {

                                    $stmt = $conn->prepare("INSERT INTO `dj_set_songs`( `dj_set_id`,`song_id`) VALUES (:dj_set_id,:song_id)");
                                    $stmt->bindParam(':dj_set_id', $dj_set_id);
                                    $stmt->bindParam(':song_id', $song);
                                    $stmt->execute();
                                }


                                header("location: all_your_dj_sets.php?status=edit_succ");
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