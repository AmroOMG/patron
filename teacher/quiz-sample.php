<?php
session_start();
ob_start();
include '../inc/db.php';

if (!isset($_SESSION['email']) || ($_SESSION['rule'] != 'teacher')) {
    header("Location: ../login.php");
}

$subject_id = htmlspecialchars($_GET['subject_id']);
$quiz_id = htmlspecialchars($_GET['quiz_id']);
$teacher_id = $_SESSION['id'];

$sql = "SELECT * FROM subjects WHERE id = '$subject_id' AND teacher_id = '$teacher_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $sql2 = "SELECT * FROM quiz WHERE id='$quiz_id' AND teacher_id = '$teacher_id' AND subject_id = '$subject_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    if ($row2) {
        $sql_subject_title = "SELECT * FROM subjects WHERE id = '$subject_id'";
        $result_subject_title = mysqli_query($conn, $sql_subject_title);
        $row_subject_title = mysqli_fetch_assoc($result_subject_title);
        $subject_title = $row_subject_title['subject_title'];

        $quiz_title = $row2['quiz_title'];

        $duration = $row2['duration'];
        $deadline_date = $row2['deadline_date'];
        $deadline_time = $row2['deadline_time'];
        $expire = $deadline_date . '' . $deadline_time;
        if ((time() + (60 * 60 * 1)) > strtotime($expire)) {
            header("Location: view-subject.php?subject_id=$subject_id");
        } else {
            //هنا الامور كلها زين
            $sql6 = "SELECT * FROM quiz_topics WHERE quiz_id='$quiz_id'";
            $result6 = mysqli_query($conn, $sql6);
            while ($row6 = mysqli_fetch_assoc($result6)) {
                $topic_id = $row6['topic_id'];
                $questions_count = $row6['questions_count'];

                $sql_check_questions = "SELECT * FROM questions WHERE topic_id= '$topic_id'";
                $result_check_questions  = mysqli_query($conn, $sql_check_questions);
                $topic_questions_count_now = mysqli_num_rows($result_check_questions);

                if ($topic_questions_count_now < $questions_count) {
                    $sql_update_questions_count = "UPDATE quiz_topics SET questions_count = '$topic_questions_count_now' WHERE topic_id = '$topic_id' AND quiz_id = '$quiz_id'";
                    $result_update_questions_count = mysqli_query($conn, $sql_update_questions_count);

                    $sql_select_marks = "SELECT * FROM quiz_topics WHERE quiz_id = '$quiz_id'";
                    $result_select_marks = mysqli_query($conn, $sql_select_marks);
                    $new_mark = 0;
                    while ($row_select_marks = mysqli_fetch_assoc($result_select_marks)) {
                        $old_mark = $row_select_marks['questions_count'];
                        $new_mark += $old_mark;
                    }

                    $sql_update_quiz_mark = "UPDATE quiz SET total_mark = '$new_mark' WHERE id = '$quiz_id'";
                    $result_update_quiz_mark = mysqli_query($conn, $sql_update_quiz_mark);

                    $sql_select_new_mark = "SELECT * FROM quiz WHERE id='$quiz_id'";
                    $result_select_new_mark = mysqli_query($conn, $sql_select_new_mark);
                    $row_select_new_mark = mysqli_fetch_assoc($result_select_new_mark);
                    $mark = $row_select_new_mark['total_mark'];

                    $sql_new_select = "SELECT * FROM quiz_topics WHERE quiz_id='$quiz_id' AND topic_id='$topic_id'";
                    $result_new_select = mysqli_query($conn, $sql_new_select);
                    $row_new_select = mysqli_fetch_assoc($result_new_select);
                    $questions_count = $row_new_select['questions_count'];
                } else {
                    $sql_select_marks = "SELECT * FROM quiz_topics WHERE quiz_id = '$quiz_id'";
                    $result_select_marks = mysqli_query($conn, $sql_select_marks);
                    $new_mark = 0;
                    while ($row_select_marks = mysqli_fetch_assoc($result_select_marks)) {
                        $old_mark = $row_select_marks['questions_count'];
                        $new_mark += $old_mark;
                    }

                    $sql_update_quiz_mark = "UPDATE quiz SET total_mark = '$new_mark' WHERE id = '$quiz_id'";
                    $result_update_quiz_mark = mysqli_query($conn, $sql_update_quiz_mark);

                    $sql_select_new_mark = "SELECT * FROM quiz WHERE id='$quiz_id'";
                    $result_select_new_mark = mysqli_query($conn, $sql_select_new_mark);
                    $row_select_new_mark = mysqli_fetch_assoc($result_select_new_mark);
                    $mark = $row_select_new_mark['total_mark'];
                }
            }
        }
    } else {
        header("Location: view-subject.php?subject_id=$subject_id");
    }
} else {
    header("Location: subjects.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patron - <?php echo $quiz_title; ?></title>
    <!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta charset="utf-8" />
    <meta name="keywords" content="patron online quiz platform forr creating online quiz for students in schools and universities, that helps teachers and students in the education proccess with less effort and cost" />
    <meta name="description" content="We provide integrated, educational-leading technology that enables teachers to make an online quiz to their students in a modern way and get analyzed feedback about the answers of the students." />
    <link rel="icon" href="../images/icon.png">
    <!--    <link rel="stylesheet" href="css/bootstrap.min.css">-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/quiz.css">
</head>

<body>

    <div class="quizArea">
        <div class="multipleChoiceQues">
            <div class="info">
                <h1 class="brand"><a href="../index.php" target="_blank">patron</a></h1>
                <h3 class="mc_quiz" style="text-transform: capitalize">
                    <?php echo $quiz_title; ?></h3>
                <h3 class="mc_quiz">Questions: <?php echo $mark; ?></h3>
                <div class="timer">
                    <i class="fas fa-hourglass-start"></i>
                    <p id="demo"></p>
                </div>
            </div>
            <!--
            <div class="my-progress">
                <progress class="my-progress-bar" min="0" max="100" value="0" step="9" aria-labelledby="my-progress-completion"></progress>
                <p id="my-progress-completion" class="js-my-progress-completion sr-only" aria-live="polite">0% complete</p>
            </div>
            -->
            <div class="quizBox">
                <div class="question"> </div>
                <div class="answerOptions"></div>
                <div class="buttonArea">
                    <button id="next" class="hidden">Next</button>
                    <button id="submit" class="hidden">Submit</button>
                </div>
            </div>
        </div>
        <div class="resultArea">
            <div class="resultPage1">
                <div class="resultBox">
                    <div class="info">
                        <h1 class="brand"><a href="../index.php" target="_blank">patron</a></h1>
                        <h3 class="mc_quiz" style="text-transform: capitalize"><?php echo $subject_title; ?> &#40; <?php echo $quiz_title; ?> &#41;</h3>
                        <h3 class="mc_quiz">Questions: <?php echo $mark; ?></h3>

                    </div>
                </div>
                <div class="briefchart">
                    <svg height="300" width="300" id="_cir_progress">
                        <g>
                            <rect x="0" y="1" width="30" height="15" fill="#292939" />
                            <text x="32" y="14" font-size="14" class="_text_incor">Incorrect : 12 </text>
                        </g>
                        <g>
                            <rect x="160" y="1" width="30" height="15" fill="#f8c765" />
                            <text x="192" y="14" font-size="14" class="_text_cor">Correct : 12</text>
                        </g>

                        <circle class="_cir_P_x" cx="150" cy="150" r="120" stroke="#292939" stroke-width="20" fill="none" onmouseover="evt.target.setAttribute('stroke', 'rgba(171, 78, 107,0.7)');" onmouseout="evt.target.setAttribute('stroke','#292939');"></circle>

                        <circle class="_cir_P_y" cx="150" cy="150" r="120" stroke="#f8c765" stroke-width="20" stroke-dasharray="0,1000" fill="none" onmouseover="evt.target.setAttribute('stroke', 'rgba(150, 128, 137,0.7)');" onmouseout="evt.target.setAttribute('stroke','#f8c765');"></circle>
                        <text x="50%" y="50%" text-anchor="middle" stroke="none" stroke-width="1px" dy=".3em" class="_cir_Per">0%</text>
                    </svg>
                </div>

                <div class="resultBtns">
                    <button class="viewanswer">Back to subject</button>
                </div>
                <!--
                <div class="resultBtns">
                    <button class="viewanswer">View Answers</button>
                                        <button class="viewchart">View Chart</button>
                                  <button class="replay"><i class="fa fa-repeat" style="font-size:1em;"></i> <br />Replay</button>
            </div>
            -->
            </div>

            <!--
            <div class="resultPage2">
                <h1>Your Result</h1>
                <div class="chartBox">
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>
                <button class="backBtn">Back</button>
            </div>


            <div class="resultPage3">
                <h1>Your Answers</h1>
                <div class="allAnswerBox">

                </div>
                <button class="backBtn">Back</button>
            </div>
-->
        </div>
    </div>

    <!--
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.js"></script>
    <script src="https://raw.githubusercontent.com/emn178/Chart.PieceLabel.js/master/src/Chart.PieceLabel.js"></script>
    <!--   <script src="../js/quiz.js"></script> -->




    <script>
        var duration = <?php echo $duration; ?>;
        var seconds = Math.floor(duration * 60 * 1000);;
        // Set the date we're counting down to
        var countDownDate = new Date().getTime() + seconds;

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
                $(".multipleChoiceQues").hide();
                $(".resultArea").show();
                renderResult(resultList);
            }
        }, 1000);
    </script>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>

    <script>
        $("html").niceScroll({
            cursorcolor: "#ff7d66",
            cursorwidth: "6px",
            cursorborder: 0,
            cursorborderradius: "3px",
        });
    </script>

    <script>
        var $progressValue = 0;
        var resultList = [];

        const quizdata = [];
        <?php
        $sql7 = "SELECT * FROM quiz_topics WHERE quiz_id = '$quiz_id'";
        $result7 = mysqli_query($conn, $sql7);
        while ($row7 = mysqli_fetch_assoc($result7)) {
            $topic_id = $row7['topic_id'];
            $questions_count = $row7['questions_count'];

            $sql8 = "SELECT * FROM questions WHERE topic_id = '$topic_id' ORDER BY RAND() LIMIT $questions_count";
            $result8 = mysqli_query($conn, $sql8);
            while ($row8 = mysqli_fetch_assoc($result8)) {
                $question_id = $row8['id'];
                $question = $row8['question'];
                $answer1 = $row8['answer1'];
                $answer2 = $row8['answer2'];
                $answer3 = $row8['answer3'];
                $answer4 = $row8['answer4'];
                $correct_answer = $row8['correct_answer'];
                $topic_of_question = $row8['topic_id'];
                $subject_of_question = $row8['subject_id'];
        ?>
                quizdata.push({
                    question: "<?php echo $question; ?>",
                    options: ["<?php echo $answer1; ?>", "<?php echo $answer2; ?>", "<?php echo $answer3; ?>", "<?php echo $answer4; ?>"],
                    answer: "<?php echo $correct_answer; ?>",
                    category: 1,
                    topic: <?php echo $topic_of_question; ?>,
                    subject: <?php echo $subject_of_question; ?>,
                    questionID: <?php echo $question_id; ?>
                });


        <?php    }
        }
        ?>

        /** Random shuffle questions **/
        function shuffleArray(question) {
            var shuffled = question.sort(function() {
                return 0.5 - Math.random();
            });
            return shuffled;
        }

        function shuffle(a) {
            for (var i = a.length; i; i--) {
                var j = Math.floor(Math.random() * i);
                var _ref = [a[j], a[i - 1]];
                a[i - 1] = _ref[0];
                a[j] = _ref[1];
            }
        }

        /*** Return shuffled question ***/
        function generateQuestions() {
            var questions = shuffleArray(quizdata);
            return questions;
        }

        /*** Return list of options ***/
        function returnOptionList(opts, i) {
            var optionHtml =
                '<li class="myoptions">' +
                '<input value="' +
                opts +
                '" name="optRdBtn" type="radio" id="rd_' +
                i +
                '">' +
                '<label for="rd_' +
                i +
                '">' +
                opts +
                "</label>" +
                '<div class="bullet">' +
                '<div class="line zero"></div>' +
                '<div class="line one"></div>' +
                '<div class="line two"></div>' +
                '<div class="line three"></div>' +
                '<div class="line four"></div>' +
                '<div class="line five"></div>' +
                '<div class="line six"></div>' +
                '<div class="line seven"></div>' +
                "</div>" +
                "</li>";

            return optionHtml;
        }

        /** Render Options **/
        function renderOptions(optionList) {
            var ulContainer = $("<ul>").attr("id", "optionList");
            for (var i = 0, len = optionList.length; i < len; i++) {
                var optionContainer = returnOptionList(optionList[i], i);
                ulContainer.append(optionContainer);
            }
            $(".answerOptions").html("").append(ulContainer);
        }

        /** Render question **/
        function renderQuestion(question) {
            $(".question").html("<h1>" + question + "</h1>");
        }

        /** Render quiz :: Question and option **/
        function renderQuiz(questions, index) {
            var currentQuest = questions[index];
            renderQuestion(currentQuest.question);
            renderOptions(currentQuest.options);
            //console.log("Question");
            //console.log(questions[index]);

        }

        /** Return correct answer of a question ***/
        function getCorrectAnswer(questions, index) {
            return questions[index].answer;
            /* var topic_id = questions[index].topic_id;
             var question_id = questions[index].questionID;
             var std_answer = questions[index].answer;

             $.ajax({
                 url: 'students-answers.php?quiz_id=<?php echo $quiz_id ?>&subject_id=<?php echo $subject_id ?>',
                 type: 'GET',
                 data: {
                     topic_id: topic_id,
                     question_id: question_id,
                     std_answer: std_answer
                 }
             })*/
        }

        /** pushanswers in array **/
        function correctAnswerArray(resultByCat) {
            var arrayForChart = [];
            for (var i = 0; i < resultByCat.length; i++) {
                arrayForChart.push(resultByCat[i].correctanswer);
            }

            return arrayForChart;
        }
        /** Generate array for percentage calculation **/
        function genResultArray(results, wrong) {
            var resultByCat = resultByCategory(results);
            var arrayForChart = correctAnswerArray(resultByCat);
            arrayForChart.push(wrong);
            return arrayForChart;
        }

        /** percentage Calculation **/
        function percentCalculation(array, total) {
            var percent = array.map(function(d, i) {
                return ((100 * d) / total).toFixed(2);
            });
            return percent;
        }

        /*** Get percentage for chart **/
        function getPercentage(resultByCat, wrong) {
            var totalNumber = resultList.length;
            var wrongAnwer = wrong;
            //var arrayForChart=genResultArray(resultByCat, wrong);
            //return percentCalculation(arrayForChart, totalNumber);
        }

        /** count right and wrong answer number **/
        function countAnswers(results) {
            var countCorrect = 0,
                countWrong = 0;

            for (var i = 0; i < results.length; i++) {
                if (results[i].iscorrect == true) countCorrect++;
                else countWrong++;
            }

            return [countCorrect, countWrong];
        }

        /**** Categorize result *****/
        function resultByCategory(results) {
            var categoryCount = [];
            var ctArray = results.reduce(function(res, value) {
                if (!res[value.category]) {
                    res[value.category] = {
                        category: value.category,
                        correctanswer: 0,
                    };
                    categoryCount.push(res[value.category]);
                }
                var val = value.iscorrect == true ? 1 : 0;
                res[value.category].correctanswer += val;
                return res;
            }, {});

            categoryCount.sort(function(a, b) {
                return a.category - b.category;
            });

            return categoryCount;
        }

        /** Total score pie chart**/
        function totalPieChart(_upto, _cir_progress_id, _correct, _incorrect) {
            $("#" + _cir_progress_id)
                .find("._text_incor")
                .html("Incorrect : " + _incorrect);
            $("#" + _cir_progress_id)
                .find("._text_cor")
                .html("Correct : " + _correct);


            var unchnagedPer = _upto;

            _upto = _upto > 100 ? 100 : _upto < 0 ? 0 : _upto;

            var _progress = 0;

            var _cir_progress = $("#" + _cir_progress_id).find("._cir_P_y");
            var _text_percentage = $("#" + _cir_progress_id).find("._cir_Per");

            var _input_percentage;
            var _percentage;

            var _sleep = setInterval(_animateCircle, 25);

            function _animateCircle() {
                //2*pi*r == 753.6 +xxx=764
                _input_percentage = (_upto / 100) * 764;
                _percentage = (_progress / 100) * 764;

                _text_percentage.html(_progress + "%");

                if (_percentage >= _input_percentage) {
                    _text_percentage.html(
                        '<tspan x="50%" dy="0em">' +
                        unchnagedPer +
                        '% </tspan><tspan  x="50%" dy="1.9em">Your Score</tspan>'
                    );
                    clearInterval(_sleep);
                } else {
                    _progress++;

                    _cir_progress.attr("stroke-dasharray", _percentage + ",764");
                }
            }
        }

        function renderBriefChart(correct, total, incorrect) {
            var percent = (100 * correct) / total;
            if (Math.round(percent) !== percent) {
                percent = percent.toFixed(2);
            }

            totalPieChart(percent, "_cir_progress", correct, incorrect);
        }
        /*** render chart for result **/
        function renderChart(data) {
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: [
                        "Verbal communication",
                        "Non-verbal communication",
                        "Written communication",
                        "Incorrect",
                    ],
                    datasets: [{
                        data: data,
                        backgroundColor: ["#e6ded4", "#968089", "#e3c3d4", "#ab4e6b"],
                        borderColor: [
                            "rgba(239, 239, 81, 1)",
                            "#8e3407",
                            "rgba((239, 239, 81, 1)",
                            "#000000",
                        ],
                        borderWidth: 1,
                    }, ],
                },
                options: {
                    pieceLabel: {
                        render: "percentage",
                        fontColor: "black",
                        precision: 2,
                    },
                },
            });
        }

        /** List question and your answer and correct answer  

        *****/
        function getAllAnswer(results) {
            var innerhtml = "";
            for (var i = 0; i < results.length; i++) {
                var _class = results[i].iscorrect ? "item-correct" : "item-incorrect";
                var _classH = results[i].iscorrect ? "h-correct" : "h-incorrect";

                var _html =
                    '<div class="_resultboard ' +
                    _class +
                    '">' +
                    '<div class="_header">' +
                    results[i].question +
                    "</div>" +
                    '<div class="_yourans ' +
                    _classH +
                    '">' +
                    results[i].clicked +
                    "</div>";

                var html = "";
                if (!results[i].iscorrect)
                    html = '<div class="_correct">' + results[i].answer + "</div>";
                _html = _html + html + "</div>";
                innerhtml += _html;
            }

            $(".allAnswerBox").html("").append(innerhtml);
        }
        /** render  Brief Result **/
        function renderResult(resultList) {
            var results = resultList;
            //console.log(results);
            var countCorrect = countAnswers(results)[0],
                countWrong = countAnswers(results)[1];

            renderBriefChart(countCorrect, resultList.length, countWrong);
        }

        function renderChartResult() {
            var results = resultList;
            var countCorrect = countAnswers(results)[0],
                countWrong = countAnswers(results)[1];
            var dataForChart = genResultArray(resultList, countWrong);
            renderChart(dataForChart);
        }

        /** Insert progress bar in html **/
        function getProgressindicator(length) {
            var progressbarhtml = " ";
            for (var i = 0; i < length; i++) {
                progressbarhtml +=
                    '<div class="my-progress-indicator progress_' +
                    (i + 1) +
                    " " +
                    (i == 0 ? "active" : "") +
                    '"></div>';
            }
            $(progressbarhtml).insertAfter(".my-progress-bar");
        }

        /*** change progress bar when next button is clicked ***/
        function changeProgressValue() {
            $progressValue += 9;
            if ($progressValue >= 100) {} else {
                if ($progressValue == 99) $progressValue = 100;
                $(".my-progress")
                    .find(".my-progress-indicator.active")
                    .next(".my-progress-indicator")
                    .addClass("active");
                $("progress").val($progressValue);
            }
            $(".js-my-progress-completion").html($("progress").val() + "% complete");
        }

        function addClickedAnswerToResult(questions, presentIndex, clicked) {
            var correct = getCorrectAnswer(questions, presentIndex);
            var result = {
                index: presentIndex,
                question: questions[presentIndex].question,
                clicked: clicked,
                iscorrect: clicked == correct ? true : false,
                answer: correct,
                category: questions[presentIndex].category,
            };

            resultList.push(result);

            //console.log("result");
            //console.log(result);
        }

        $(document).ready(function() {
            var presentIndex = 0;
            var clicked = 0;

            var questions = generateQuestions();
            renderQuiz(questions, presentIndex);
            getProgressindicator(questions.length);

            $(".answerOptions ").on("click", ".myoptions>input", function(e) {
                clicked = $(this).val();

                if (questions.length == presentIndex + 1) {
                    $("#submit").removeClass("hidden");
                    $("#next").addClass("hidden");
                } else {
                    $("#next").removeClass("hidden");
                }
            });

            $("#next").on("click", function(e) {
                e.preventDefault();
                addClickedAnswerToResult(questions, presentIndex, clicked);

                $(this).addClass("hidden");

                presentIndex++;
                renderQuiz(questions, presentIndex);
                changeProgressValue();
            });

            $("#submit").on("click", function(e) {
                addClickedAnswerToResult(questions, presentIndex, clicked);
                $(".multipleChoiceQues").hide();
                $(".resultArea").show();
                renderResult(resultList);
            });

            $(".resultArea").on("click", ".viewchart", function() {
                $(".resultPage2").show();
                $(".resultPage1").hide();
                $(".resultPage3").hide();
                renderChartResult();
            });

            $(".resultArea").on("click", ".backBtn", function() {
                $(".resultPage1").show();
                $(".resultPage2").hide();
                $(".resultPage3").hide();
                renderResult(resultList);
            });

            $(".resultArea").on("click", ".viewanswer", function() {
                /*  $(".resultPage3").show();
                  $(".resultPage2").hide();
                  $(".resultPage1").hide();
                  getAllAnswer(resultList);*/
                window.location.replace("view-subject.php?subject_id=<?php echo $subject_id ?>");

            });

            $(".resultArea").on("click", ".replay", function() {
                window.location.reload(true);
            });
        });
    </script>
</body>

</html>