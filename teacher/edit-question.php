<?php
ob_start();
$page_title = 'Patron - Edit Question';
include '../dashboard-header.php';

$topic_id = htmlspecialchars($_GET['topic_id']);
$question_id = htmlspecialchars($_GET['question_id']);
$teach_id = $_SESSION['id'];

$sql = "SELECT * FROM questions WHERE id = '$question_id' AND teacher_id = '$teach_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $sql2 = "SELECT * FROM topics WHERE id = '$topic_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $topic_title = $row2['topic_title'];

    $sql3 = "SELECT * FROM questions WHERE id= $question_id";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($result3);
    $question = $row3['question'];
    $answer1 = $row3['answer1'];
    $answer2 = $row3['answer2'];
    $answer3 = $row3['answer3'];
    $answer4 = $row3['answer4'];
    $correct_answer = $row3['correct_answer'];

    if (isset($_POST['edit_question'])) {
        $question = htmlspecialchars($_POST['question']);
        $answer1 = htmlspecialchars($_POST['answer1']);
        $answer2 = htmlspecialchars($_POST['answer2']);
        $answer3 = htmlspecialchars($_POST['answer3']);
        $answer4 = htmlspecialchars($_POST['answer4']);
        $correct_answer = htmlspecialchars($_POST['correct-answer']);

        $sql4 = "UPDATE questions SET question='$question', answer1='$answer1', answer2='$answer2', answer3='$answer3', answer4='$answer4', correct_answer='$correct_answer' WHERE id='$question_id'";
        if (mysqli_query($conn, $sql4)) {
            $success = "Question edited successfully.";
        } else {
            $error = 'Sorry something wrong happened, Question not edited !';
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
                        <h3>Topic: <span><?php echo $topic_title; ?></span><br>Edit Question</h3>
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
                        <label for="Question" class="col-sm-2 col-form-label">Question</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="question" value="<?php echo $question; ?>" id="Question" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Answer-one" class="col-sm-2 col-form-label">Answer one</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control answer" name="answer1" value="<?php echo $answer1; ?>" id="Answer-one" required>
                            <div class="custom-control custom-radio">
                                <?php
                                if ($answer1 == $correct_answer) {
                                    $attr = "checked";
                                } else {
                                    $attr = "";
                                }
                                ?>
                                <input type="radio" id="answer1" name="correct-answer" value="<?php echo $answer1; ?>" class="custom-control-input" required <?php echo $attr; ?>>
                                <label class="custom-control-label" for="answer1">Correct Answer</label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="Answer-two" class="col-sm-2 col-form-label">Answer two</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control answer" name="answer2" value="<?php echo $answer2; ?>" id="Answer-two" required>
                            <div class="custom-control custom-radio">
                                <?php
                                if ($answer2 == $correct_answer) {
                                    $attr = "checked";
                                } else {
                                    $attr = "";
                                }
                                ?>
                                <input type="radio" id="answer2" name="correct-answer" value="<?php echo $answer2; ?>" class="custom-control-input" required <?php echo $attr; ?>>
                                <label class="custom-control-label" for="answer2">Correct Answer</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Answer-three" class="col-sm-2 col-form-label">Answer three</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control answer" name="answer3" value="<?php echo $answer3; ?>" id="Answer-three" required>
                            <div class="custom-control custom-radio">
                                <?php
                                if ($answer3 == $correct_answer) {
                                    $attr = "checked";
                                } else {
                                    $attr = "";
                                }
                                ?>
                                <input type="radio" id="answer3" name="correct-answer" value="<?php echo $answer3; ?>" class="custom-control-input" required <?php echo $attr; ?>>
                                <label class="custom-control-label" for="answer3">Correct Answer</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Answer-four" class="col-sm-2 col-form-label">Answer four</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control answer" name="answer4" value="<?php echo $answer4; ?>" id="Answer-four" required>
                            <div class="custom-control custom-radio">
                                <?php
                                if ($answer4 == $correct_answer) {
                                    $attr = "checked";
                                } else {
                                    $attr = "";
                                }
                                ?>
                                <input type="radio" id="answer4" name="correct-answer" value="<?php echo $answer4; ?>" class="custom-control-input" required <?php echo $attr; ?>>
                                <label class="custom-control-label" for="answer4">Correct Answer</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <div class="col-sm-12 text-right">
                            <button type="submit" name="edit_question" class="btn btn-primary">Edit Question</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->



<?php include '../dashboard-footer.php'; ?>

<script>
    $('.answer').blur(function() {
        $answer = $(this).val();
        $(this).parent().find('.custom-control-input').val($answer);
    })
</script>