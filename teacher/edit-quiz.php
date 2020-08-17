<?php
ob_start();
$page_title = 'Patron - Edit Quiz';
include '../dashboard-header.php';

$quiz_id = htmlspecialchars($_GET['quiz_id']);
$subject_id = htmlspecialchars($_GET['subject_id']);
$teach_id = $_SESSION['id'];

$sql = "SELECT * FROM quiz WHERE id = '$quiz_id' AND teacher_id = '$teach_id' AND subject_id = '$subject_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $quiz_title = $row['quiz_title'];
    $start_date = $row['start_date'];
    $start_time = $row['start_time'];
    $exp_date = $row['deadline_date'];
    $exp_time = $row['deadline_time'];
    $duration = $row['duration'];

    if (isset($_POST['edit_quiz'])) {
        $quiz_title = htmlspecialchars($_POST['title']);
        $start_date = htmlspecialchars($_POST['start_date']);
        $start_time = htmlspecialchars($_POST['start_time']);
        $exp_date = htmlspecialchars($_POST['exp_date']);
        $exp_time = htmlspecialchars($_POST['exp_time']);
        $duration = htmlspecialchars($_POST['duration']);

        if (!empty($_POST['selected_topic'])) {
            $list = array();
            $selected_topics = $_POST['selected_topic'];
            $mark = 0;
            $number_of_checked_topics = count($selected_topics);

            $sql9 = "DELETE FROM quiz_topics WHERE quiz_id='$quiz_id'";
            $result9 = mysqli_query($conn, $sql9);

            $sql3 = "UPDATE quiz SET quiz_title='$quiz_title',start_date='$start_date',start_time='$start_time',deadline_date='$exp_date',deadline_time='$exp_time',duration='$duration',total_mark= '$mark' WHERE id='$quiz_id'";
            mysqli_query($conn, $sql3);

            foreach ($selected_topics as $topic) {
                list($value, $id) = explode(',', $topic); //اكسبلود بتفصل قيمة الفاليو من عند الفاصلة .. وبتخزن القسمين في متغيرين الفاليو و اي دي
                $questions_count = $_POST['questions_count_' . $id];
                if (is_numeric($questions_count)) {
                    $mark += $questions_count;
                    $sql5 = "SELECT * FROM questions WHERE topic_id= '$topic'";
                    $result5 = mysqli_query($conn, $sql5);
                    $questions_of_topic = mysqli_num_rows($result5);

                    if ($questions_count <= $questions_of_topic) {
                        $sql10 = "UPDATE quiz SET total_mark ='$mark' WHERE id='$quiz_id'";
                        $result10 = mysqli_query($conn, $sql10);

                        $sql6 = "INSERT INTO quiz_topics (quiz_id,topic_id,questions_count) VALUES ('$quiz_id','$topic','$questions_count')";
                        $result6 = mysqli_query($conn, $sql6);
                        $success = "Quiz edited successfully.";
                    } else {
                        $sql7 = "SELECT * FROM topics WHERE id= '$topic'";
                        $result7 = mysqli_query($conn, $sql7);
                        $row7 = mysqli_fetch_assoc($result7);
                        $topic_name = $row7['topic_title'];
                        $error = $topic_name . ' has only ' . $questions_of_topic . ' questions, please select ' . $questions_of_topic . ' or less questions of this topic.';
                        /* $sql8 = "DELETE FROM quiz WHERE id='$quiz_id'";
                        $result8 = mysqli_query($conn, $sql8);
                        $sql9 = "DELETE FROM quiz_topics WHERE quiz_id='$quiz_id'";
                        $result9 = mysqli_query($conn, $sql9);
                        break;*/
                    }
                } else {
                    $error = 'You must identify the number of questions for each topic you select !';
                    /* $sql8 = "DELETE FROM quiz WHERE id='$quiz_id'";
                    $result8 = mysqli_query($conn, $sql8);*/
                }
            }
        } else {
            $error = 'You must select topics for the quiz and identify number of questions for each topic you select !';
        }
    }
} else {
    header("Location: subjects.php");
}
?>

<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">
            <div class="col">
                <div class="hero hero-subject">
                    <div class="layout">
                        <h3>Quiz: <span><?php echo $quiz_title; ?></span><br>Edit Quiz</h3>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="create row">
            <div class="col ">
                <form method="post">

                    <?php if (isset($error) && !empty($error)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $error; ?>
                        </div>
                    <?php } elseif (isset($success) && !empty($success)) { ?>
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $success; ?>
                        </div>
                    <?php } ?>

                    <div class="form-group row">
                        <label for="quiz-title" class="col-sm-2 col-form-label">Quiz title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" value="<?php echo $quiz_title; ?>" class="form-control" id="quiz-title" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Select-topics" class="col-sm-2 col-form-label">Select topics </label>
                        <span class="select-topics">&#40;select which topics are included in the quiz and amount of questions from each topic&#41;</span>
                    </div>
                    <div class="row">
                        <?php

                        $sql2 = "SELECT * FROM topics WHERE subject_id= $subject_id";
                        $result2 = mysqli_query($conn, $sql2);
                        $topics_count = mysqli_num_rows($result2);
                        if ($topics_count > 0) {

                            $sql3 = "SELECT * FROM quiz_topics WHERE quiz_id = '$quiz_id'";
                            $result3 = mysqli_query($conn, $sql3);


                            for ($i = 0; $i < $topics_count; $i++) {
                                $row2 = mysqli_fetch_assoc($result2);
                                $topic_id = $row2['id'];
                                $topic_title = $row2['topic_title'];

                                $sql3 = "SELECT * FROM quiz_topics WHERE quiz_id = '$quiz_id' AND topic_id ='$topic_id' ";
                                $result3 = mysqli_query($conn, $sql3);
                                $row3 = mysqli_fetch_assoc($result3);
                                if ($row3) {
                                    $attr = 'checked';
                                    $topic_questions_count = $row3['questions_count'];
                                } else {
                                    $attr = '';
                                    $topic_questions_count = '';
                                }

                                $sql11 = "SELECT * FROM questions WHERE topic_id = '$topic_id'";
                                $result11 = mysqli_query($conn, $sql11);
                                $count = mysqli_num_rows($result11);

                        ?>
                                <div class="col-lg-4 col-sm-10">
                                    <div class="topic custom-control custom-checkbox">
                                        <input type="checkbox" name="selected_topic[]" class="custom-control-input" value="<?php echo $topic_id . ',' . $i; ?>" id="<?php echo $topic_id; ?>" <?php echo $attr; ?>>
                                        <label class="custom-control-label" for="<?php echo $topic_id; ?>"><?php echo $topic_title; ?></label>
                                        <input type="number" name="questions_count_<?php echo $i; ?>" placeholder="of <?php echo $count; ?>" class="form-control" id="<?php echo $topic_id; ?>" value="<?php echo $topic_questions_count; ?>">

                                    </div>
                                </div>

                            <?php }
                        } else { ?>
                            <div class="alert alert-danger" role="alert" style="margin: 0 auto; margin-bottom: 20px ">
                                <?php echo $subject_title . ' does not have any topics yet, try to add topics and questions first. '; ?>
                                <a href="add-topic.php?subject_id=<?php echo $subject_id; ?>">Add Topic</a>
                            </div>
                        <?php    }

                        ?>
                    </div>
                    <div class="form-group row">
                        <label for="date" class="col-sm-2 col-form-label">Start date</label>
                        <div class="col-sm-10">
                            <input type="date" name="start_date" value="<?php echo $start_date; ?>" class="form-control" id="date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="time" class="col-sm-2 col-form-label">Start time</label>
                        <div class="col-sm-10">
                            <input type="time" name="start_time" value="<?php echo $start_time; ?>" class="form-control" id="time">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exp-date" class="col-sm-2 col-form-label">Deadline date</label>
                        <div class="col-sm-10">
                            <input type="date" name="exp_date" value="<?php echo $exp_date; ?>" class="form-control" id="exp-date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exp-time" class="col-sm-2 col-form-label">Deadline time</label>
                        <div class="col-sm-10">
                            <input type="time" name="exp_time" value="<?php echo $exp_time; ?>" class="form-control" id="exp-time">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="duration" class="col-sm-2 col-form-label">Select duration <span class="minutes">&#40;minutes&#41;</span></label>
                        <div class="col-sm-10">
                            <input type="number" name="duration" value="<?php echo $duration; ?>" class="form-control" id="duration">

                        </div>
                    </div>

                    <div class="form-group row ">
                        <div class="col-sm-12 text-right">
                            <button type="submit" name="edit_quiz" class="btn btn-primary">Edit Quiz</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>