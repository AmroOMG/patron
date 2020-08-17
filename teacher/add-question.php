<?php
ob_start();
$page_title = 'Patron - Create Question';
include '../dashboard-header.php';

$id = htmlspecialchars($_GET['subject_id']);
$topic_id = htmlspecialchars($_GET['topic_id']);
$teach_id = $_SESSION['id'];

$sql = "SELECT * FROM topics WHERE id = '$topic_id' AND teacher_id = '$teach_id' AND subject_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $topic_title = $row['topic_title'];

    if (isset($_POST['add_question'])) {
        $question = htmlspecialchars($_POST['question']);
        $answer1 = htmlspecialchars($_POST['answer1']);
        $answer2 = htmlspecialchars($_POST['answer2']);
        $answer3 = htmlspecialchars($_POST['answer3']);
        $answer4 = htmlspecialchars($_POST['answer4']);
        $correct_answer = htmlspecialchars($_POST['correct-answer']);


        $sql2 = "INSERT INTO questions (teacher_id,subject_id,topic_id,question,answer1,answer2,answer3,answer4,correct_answer) VALUES ('$teach_id','$id','$topic_id','$question','$answer1','$answer2','$answer3','$answer4','$correct_answer')";
        if (mysqli_query($conn, $sql2)) {
            $success = "New Question added successfully.";
        } else {
            $error = 'Sorry something wrong happened, Question not added !';
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
                        <h3>Topic: <span><?php echo $topic_title; ?></span><br>Add Question</h3>
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
                            <input type="text" class="form-control" name="question" id="Question" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Answer-one" class="col-sm-2 col-form-label">Answer one</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control answer" name="answer1" id="Answer-one" required>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="answer1" name="correct-answer" value class="custom-control-input" required>
                                <label class="custom-control-label" for="answer1">Correct Answer</label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="Answer-two" class="col-sm-2 col-form-label">Answer two</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control answer" name="answer2" id="Answer-two" required>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="answer2" name="correct-answer" value class="custom-control-input" required>
                                <label class="custom-control-label" for="answer2">Correct Answer</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Answer-three" class="col-sm-2 col-form-label">Answer three</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control answer" name="answer3" id="Answer-three" required>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="answer3" name="correct-answer" value class="custom-control-input" required>
                                <label class="custom-control-label" for="answer3">Correct Answer</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Answer-four" class="col-sm-2 col-form-label">Answer four</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control answer" name="answer4" id="Answer-four" required>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="answer4" name="correct-answer" value class="custom-control-input" required>
                                <label class="custom-control-label" for="answer4">Correct Answer</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <div class="col-sm-12 text-right">
                            <button type="submit" name="add_question" class="btn btn-primary">Add Question</button>
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