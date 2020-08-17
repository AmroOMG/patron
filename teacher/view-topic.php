<?php
ob_start();
$page_title = 'Patron - Topic';
include '../dashboard-header.php';

$subject_id = htmlspecialchars($_GET['subject_id']);
$topic_id = htmlspecialchars($_GET['topic_id']);
$teach_id = $_SESSION['id'];
$sql = "SELECT * FROM topics WHERE id = $topic_id AND teacher_id = $teach_id AND subject_id = $subject_id ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {

    $sql2 = "SELECT * FROM subjects WHERE id= $subject_id";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $subject_title = $row2['subject_title'];

    $topic_title = $row['topic_title'];

    if (isset($_GET['delete_question'])) {
        $delete_question_id = htmlspecialchars($_GET['delete_question']);
        $sql5 = "DELETE FROM questions WHERE id= '$delete_question_id'";
        $result5 = mysqli_query($conn, $sql5);
        $sql6 = "DELETE FROM students_answers WHERE question_id= '$delete_question_id'";
        $result6 = mysqli_query($conn, $sql6);

        if ($result5) {
            $success_question = 'Question deleted successfully.';
        } else {
            $error_question = 'Something wrong happened, question not deleted successfully please try again.';
        }
    }

    $sql3 = "SELECT * FROM questions WHERE topic_id =$topic_id ";
    $result3 = mysqli_query($conn, $sql3);
    $questions_count = mysqli_num_rows($result3);
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
                        <h3><span><?php echo $subject_title; ?></span></h3>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="create row">
            <div class="col ">
                <div class="subject-details">
                    <table class="table table-bordered">

                        <tbody>
                            <tr>
                                <td>Subject title</td>
                                <td><?php echo $topic_title; ?></td>
                            </tr>
                            <tr>
                                <td>Subject</td>
                                <td><?php echo $subject_title; ?></td>
                            </tr>

                            <tr>
                                <td class="last">Number of questions</td>
                                <td class="last"><?php echo $questions_count; ?></td>
                            </tr>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="add row">
            <div class="col text-right">
                <a href="edit-topic.php?topic_id=<?php echo $topic_id; ?>&subject_id=<?php echo $subject_id; ?>">Edit topic</a>
                <a onclick="return confirm('Are you sure deleting topic ? \nBy deleting the topic everything related to this topic will be deleted such as questions, students answers and analysis for this topic, and you will not be able to recover this data anymore!')" href="question-bank.php?subject_id=<?php echo $subject_id; ?>&delete_topic=<?php echo $topic_id; ?>">Delete Topic</a>
                <a href="add-question.php?subject_id=<?php echo $subject_id; ?>&topic_id=<?php echo $topic_id; ?>">Add new question</a>
            </div>
        </div>
        <?php
        if ($questions_count > 0) { ?>
            <div class="row">
                <div class="col">
                    <h3><?php echo $topic_title; ?> Questions</h3>
                    <?php if (isset($error_question) && !empty($error_question)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $error_question; ?>
                        </div>
                    <?php } elseif (isset($success_question) && !empty($success_question)) { ?>
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $success_question; ?>
                        </div>
                    <?php } ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Question</th>
                                <th scope="col">Answer 1</th>
                                <th scope="col">Answer 2</th>
                                <th scope="col">Answer 3</th>
                                <th scope="col">Answer 4</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $question_number = 1;
                            while ($row3 = mysqli_fetch_assoc($result3)) {
                                $question_id = $row3['id'];

                            ?>
                                <tr>
                                    <th scope="row"><?php echo $question_number; ?></th>
                                    <th scope="col"><?php echo $row3['question']; ?></th>
                                    <th scope="col"><?php echo $row3['answer1']; ?></th>
                                    <th scope="col"><?php echo $row3['answer2']; ?></th>
                                    <th scope="col"><?php echo $row3['answer3']; ?></th>
                                    <th scope="col"><?php echo $row3['answer4']; ?></th>
                                    <th scope="col"><a href="edit-question.php?question_id=<?php echo $question_id; ?>&topic_id=<?php echo $topic_id; ?>"><i class="fas fa-pencil-alt"></i></a></th>
                                    <th scope="col"><a onclick="return confirm('Are you sure deleting question ? \nBy deleting the question everything related to this question will be deleted such as students answers and analysis for this question, and you will not be able to recover this data anymore!')" href="view-topic.php?subject_id=<?php echo $subject_id; ?>&topic_id=<?php echo $topic_id; ?>&delete_question=<?php echo $question_id; ?>"><i class="fas fa-trash-alt"></i></a></th>
                                </tr>
                            <?php
                                $question_number++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php }
        ?>
        </tbody>
        </table>
    </div>
</div>

</div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>