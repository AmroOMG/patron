<?php
ob_start();
$page_title = 'Patron - Questions Bank';
include '../dashboard-header.php';

$id = htmlspecialchars($_GET['subject_id']);
$teach_id = $_SESSION['id'];

$sql = "SELECT * FROM subjects WHERE id = $id AND teacher_id = $teach_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $subject_title = $row['subject_title'];

    if (isset($_GET['delete_topic'])) {
        $delete_topic_id = htmlspecialchars($_GET['delete_topic']);
        $sql7 = "DELETE FROM topics WHERE id= '$delete_topic_id'";
        $result7 = mysqli_query($conn, $sql7);
        $sql8 = "DELETE FROM questions WHERE topic_id= '$delete_topic_id'";
        $result8 = mysqli_query($conn, $sql8);
        $sql9 = "DELETE FROM quiz_topics WHERE topic_id= '$delete_topic_id'";
        $result9 = mysqli_query($conn, $sql9);
        $sql10 = "DELETE FROM students_answers WHERE topic_id= '$delete_topic_id'";
        $result10 = mysqli_query($conn, $sql10);

        if ($result7) {
            $success_topic = 'Topic deleted successfully.';
        } else {
            $error_topic = 'Something wrong happened, topic not deleted successfully please try again.';
        }
    }

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

    $sql2 = "SELECT * FROM questions WHERE subject_id = $id ";
    $result2 = mysqli_query($conn, $sql2);

    $sql3 = "SELECT * FROM topics WHERE subject_id = $id ";
    $result3 = mysqli_query($conn, $sql3);
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
                        <h3><span><?php echo $subject_title; ?></span><br>Questions Bank</h3>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="add row">
            <!--
            <div class="col">
                <form class="form-inline my-2 my-lg-0">

                    <input class="form-control mr-sm-2" type="search" placeholder="Search for topic or question ..." aria-label="Search">

                </form>
            </div>
-->
            <div class="col text-right">
                <a href="add-topic.php?subject_id=<?php echo $id; ?>">Add new topic</a>
                <a href="create-quiz.php?subject_id=<?php echo $id; ?>">Create new Quiz</a>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h3>All Topics</h3>
                <?php if (isset($error_topic) && !empty($error_topic)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo $error_topic; ?>
                    </div>
                <?php } elseif (isset($success_topic) && !empty($success_topic)) { ?>
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo $success_topic; ?>
                    </div>
                <?php } ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Number of question</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $topic_number = 1;
                        while ($row3 = mysqli_fetch_assoc($result3)) {
                            $topic_title = $row3['topic_title'];
                            $topic_id = $row3['id'];
                            $sql4 = "SELECT * FROM questions WHERE topic_id =$topic_id ";
                            $result4 = mysqli_query($conn, $sql4);
                            $questions_count = mysqli_num_rows($result4);

                        ?>
                            <tr>
                                <th scope="row"><?php echo $topic_number; ?></th>
                                <th scope="col"><a href="view-topic.php?topic_id=<?php echo $topic_id; ?>&subject_id=<?php echo $id; ?>"><?php echo $topic_title; ?></a></th>
                                <th scope="col"><?php echo $questions_count; ?></th>
                                <th scope="col"><a href="edit-topic.php?topic_id=<?php echo $topic_id; ?>&subject_id=<?php echo $id; ?>"><i class="fas fa-pencil-alt"></i></a></th>
                                <th scope="col"><a onclick="return confirm('Are you sure deleting topic ? \nBy deleting the topic everything related to this topic will be deleted such as questions, students answers and analysis for this topic, and you will not be able to recover this data anymore!')" href="question-bank.php?subject_id=<?php echo $id; ?>&delete_topic=<?php echo $topic_id; ?>"><i class="fas fa-trash-alt"></i></a></th>
                            </tr>
                        <?php
                            $topic_number++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h3>All Questions</h3>
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
                            <th scope="col">Topic</th>
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
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            $question_id = $row2['id'];
                            $topic_id = $row2['topic_id'];
                            $sql3 = "SELECT * FROM topics WHERE id =$topic_id ";
                            $result3 = mysqli_query($conn, $sql3);
                            $row3 = mysqli_fetch_assoc($result3);
                            $topic_title = $row3['topic_title'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $question_number; ?></th>
                                <th scope="col"><a href="view-topic.php?topic_id=<?php echo $topic_id; ?>&subject_id=<?php echo $id; ?>"><?php echo $topic_title; ?></a></th>
                                <th scope="col"><?php echo $row2['question']; ?></th>
                                <th scope="col"><?php echo $row2['answer1']; ?></th>
                                <th scope="col"><?php echo $row2['answer2']; ?></th>
                                <th scope="col"><?php echo $row2['answer3']; ?></th>
                                <th scope="col"><?php echo $row2['answer4']; ?></th>
                                <th scope="col"><a href="edit-question.php?question_id=<?php echo $question_id; ?>"><i class="fas fa-pencil-alt"></i></a></th>
                                <th scope="col"><a onclick="return confirm('Are you sure deleting question ? \nBy deleting the question everything related to this question will be deleted such as students answers and analysis for this question, and you will not be able to recover this data anymore!')" href="question-bank.php?subject_id=<?php echo $id; ?>&delete_question=<?php echo $question_id; ?>"><i class="fas fa-trash-alt"></i></a></th>
                            </tr>
                        <?php
                            $question_number++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>